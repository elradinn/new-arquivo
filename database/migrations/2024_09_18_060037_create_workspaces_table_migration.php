<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workspaces', function (Blueprint $table) {
            // $table->increments('id');
            $table->uuid('item_id')->primary();
            $table->string('name');
            $table->unsignedBigInteger('owned_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');

            $table->foreign('owned_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('workspaces');
    }
};
