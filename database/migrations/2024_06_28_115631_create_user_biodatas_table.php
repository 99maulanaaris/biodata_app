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
        Schema::create('user_biodatas', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id')->unique();
            $table->string('position');
            $table->string('no_telp')->unique();
            $table->string('no_ktp');
            $table->string('brithday');
            $table->enum('gender',['male','female'])->nullable();
            $table->string('religion')->nullable();
            $table->string('blood')->nullable();
            $table->string('status')->nullable();
            $table->string('address_ktp');
            $table->string('address');
            $table->string('skill');
            $table->string('sallary');
            $table->string('contact_darurat');
            $table->boolean('assignments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_biodatas');
    }
};
