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
        Schema::create('blog_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('post_selector'); // CSS selector for post container
            $table->string('title_selector');
            $table->string('content_selector');
            $table->string('date_selector')->nullable();
            $table->integer('crawl_interval')->default(24); // hours
            $table->timestamp('last_crawled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_sources');
    }
};
