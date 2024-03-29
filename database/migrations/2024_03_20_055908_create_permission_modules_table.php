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
        Schema::create('permission_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id')->unsigned()->nullable();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->string('module_code');
            $table->foreign('module_code')->references('code')->on('modules')->onDelete('cascade');
            $table->boolean('create')->default(false);
            $table->boolean('edit')->default(false);
            $table->boolean('view')->default(false);
            $table->boolean('delete')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by')->nullable();
            $table->string( 'updated_by' )->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_modules');
    }
};
