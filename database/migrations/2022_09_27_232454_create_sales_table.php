<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                ->constrained('clients');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->foreignId('subscription_id')
                ->constrained('subscriptions');
            $table->unsignedInteger('trainer_id')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedInteger('payment_type');
            $table->unsignedInteger('validity_visits');
            $table->date('active_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
