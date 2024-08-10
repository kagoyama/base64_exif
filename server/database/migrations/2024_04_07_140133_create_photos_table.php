<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('投稿者id');
            $table->string('upload_name')->comment('アップロードファイル名');
            $table->string('shot_date')->nullable()->comment('撮影日');
            $table->string('gps')->nullable()->comment('座標');
            $table->timestamps();

            $table->softDeletes();
            $table->comment('写真テーブル');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
