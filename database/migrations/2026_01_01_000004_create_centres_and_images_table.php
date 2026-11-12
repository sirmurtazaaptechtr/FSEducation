<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('centres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->text('address')->nullable();
            $table->string('area')->nullable()->index();
            $table->string('city')->default('Karachi')->index();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->text('map_url')->nullable();
            $table->text('registration_note')->nullable();
            $table->string('cover_image')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('centre_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('centre_id')->constrained('centres')->cascadeOnDelete();
            $table->string('path');
            $table->string('caption')->nullable();
            $table->string('alt_text')->nullable();
            $table->integer('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('centre_images');
        Schema::dropIfExists('centres');
    }
};
