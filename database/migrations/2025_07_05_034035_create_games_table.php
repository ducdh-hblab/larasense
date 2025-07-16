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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable();
            $table->foreignId('developer_id')->nullable();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('intro', 255)->nullable();
            $table->text('overview')->nullable();
            $table->text('instruction')->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('gif', 255)->nullable();
            $table->string('video', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
