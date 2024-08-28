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
        Schema::create('flat_owner_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flat_id')->constrained('flats')->onDelete('cascade');
            $table->string('owner_name');
            $table->string('members');
            $table->string('park_slott');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flat_owner_details');
    }
};