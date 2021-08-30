<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_logs', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id');
            $table->string('request_id')->default('')->unique();
            $table->json('from')->nullable();
            $table->json('to')->nullable();
            $table->json('content')->nullable();
            $table->json('extra')->nullable();
            $table->enum('status', ['unknown', 'success', 'pending', 'fail'])->nullable()->default('unknown');
            $table->dateTime('success_at')->nullable();
            $table->dateTime('fail_at')->nullable();
            $table->string('fail_reason')->nullable();

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
        Schema::dropIfExists('send_logs');
    }
}
