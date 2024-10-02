<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('numbering_schemes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('folder_item_id')->unique();
            $table->string('prefix');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('folder_item_id')->references('item_id')->on('folders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('numbering_schemes');
    }
};
