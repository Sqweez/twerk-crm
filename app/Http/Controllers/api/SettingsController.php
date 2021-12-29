<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function getSettings(): JsonResponse {
        $whatsappMessage = 'Добрый день, %ИМЯ%! Напоминаем, что сегодня у вас истекает срок действия абонемента!';
        if (Cache::has('whatsapp_message')) {
            $whatsappMessage = Cache::get('whatsapp_message');
        }

        return $this->responseSuccess(['whatsappMessage' => $whatsappMessage]);
    }

    public function getSettingsByKey($key): JsonResponse {
        $setting = '';
        if (Cache::has($key)) {
            $setting = Cache::get($key);
        }

        return $this->responseSuccess(['setting' => $setting]);
    }

    public function setSettings(Request $request) {
        $whatsappMessage = $request->get('whatsappMessage');
        Cache::forever('whatsapp_message', $whatsappMessage);
        $this->responseSuccess();
    }
}
