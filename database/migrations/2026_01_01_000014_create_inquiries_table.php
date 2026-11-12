<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->index();
            $table->string('email')->nullable();
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->foreignId('centre_id')->nullable()->constrained('centres')->nullOnDelete();
            $table->foreignId('mou_partner_id')->nullable()->constrained('mou_partners')->nullOnDelete();
            $table->string('referral_code_entered')->nullable()->index();
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'closed'])->default('new')->index();

            // Marketing attribution fields
            $table->string('utm_source')->nullable()->index();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable()->index();
            $table->string('utm_content')->nullable();
            $table->text('referrer_url')->nullable();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // Index for dashboard reporting
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
