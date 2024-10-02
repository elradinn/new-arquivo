<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('folder_id')->unique();
            $table->text('resolution')->nullable();
            $table->uuid('destination')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('folder_id')->references('item_id')->on('folders')->onDelete('cascade');
            $table->foreign('destination')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('workflows');
    }
};
