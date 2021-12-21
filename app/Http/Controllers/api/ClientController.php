<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Clients\ClientsResource;
use App\Http\Services\TelegramService;
use App\Models\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index(): AnonymousResourceCollection {
        return ClientsResource::collection(Client::with('user')->get());
    }

    /**
     * @throws GuzzleException
     */
    public function cronExpiredClients(TelegramService $service) {
        $clients = Client::query()
            ->where('pass_expired_at', '=', now()->toDateString())
            ->get();
        $message = $this->getMessage($clients);
        return $service->sendMessage($message);
    }

    private function getMessage($clients): string {
        if ($clients->count() === 0) {
            return "Сегодня нет клиентов с истекающим абонементом";
        }
        $message = "Клиенты с истекающим абонементом \n";
        $clients->each(function ($client, $key) use (&$message) {
            $message .= sprintf("%s. %s - %s", ($key + 1), $client->fullname, $client->phone);
            $message .= "\n";
        });
        return urlencode($message);
    }

    public function store(Request $request): ClientsResource {
        $data = $request->all();
        $data['date'] = $data['date'] ?? null;
        $data['user_id'] = Auth::id();
        $client = Client::create($data);
        return new ClientsResource($client);
    }

    public function update($id, Request $request) {
        $data = $request->only(['name', 'surname', 'date', 'pass_expired_at']);
        $data['user_id'] = Auth::id();
        $client = Client::whereId($id)->update($data);
        return new ClientsResource(Client::find($id));
    }

    public function outdatedClients(): AnonymousResourceCollection {
        $clients = Client::query()
            ->whereDate('pass_expired_at', '<', now())
            ->orWhereNull('pass_expired_at')
            ->with('user')
            ->get();
        return ClientsResource::collection($clients);
    }

    public function nearlyOutdatedClients(): AnonymousResourceCollection {
        $clients = Client::query()
            ->whereDate('pass_expired_at', '<=', now()->addDays(3))
            ->whereDate('pass_expired_at', '>=', now())
            ->with('user')
            ->get();
        return ClientsResource::collection($clients);
    }

    public function destroy($id) {
        Client::destroy($id);
    }
}
