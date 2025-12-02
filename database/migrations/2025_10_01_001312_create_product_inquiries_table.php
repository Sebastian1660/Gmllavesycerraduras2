<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->decimal('product_price', 10, 2)->nullable();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->text('message');
            $table->enum('status', ['pending', 'answered', 'closed'])->default('pending');
            $table->text('admin_response')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_inquiries');
    }
};