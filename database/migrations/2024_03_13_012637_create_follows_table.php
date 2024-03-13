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
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade'); //user which is following/creating the following record

            //more granular approach to create FK
            $table->unsignedBigInteger('followed_user'); //create only the column
            $table->foreign('followed_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade'); // manually assign a FK

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
