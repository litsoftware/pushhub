<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id');
            $table->enum('type', ['unknown', 'chat', 'email', 'sms']);
            $table->string('title')->default('');
            $table->string('name')->default('');
            $table->json('conf')->nullable();
            $table->integer('version')->default(1);
            $table->enum('status', ['unknown', 'valid', 'invalid'])->default('unknown');

            $table->unique(['type', 'name']);
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
        Schema::dropIfExists('channels');
    }
}
