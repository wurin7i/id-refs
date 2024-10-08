<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function getConnection(): string
    {
        return config('database.connections.vault') ? 'vault' : config('database.default');
    }

    public function up()
    {
        Schema::create('ref_regions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('label');
            $table->string('bps_code')->unique()->nullable();
            $table->string('name');
            $table->unsignedTinyInteger('level');
            $table->foreignId('parent_id')->nullable()
                ->references('id')->on('ref_regions');
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ref_regions');
    }
};
