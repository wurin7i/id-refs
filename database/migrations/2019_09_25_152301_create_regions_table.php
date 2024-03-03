<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use WuriN7i\IdData\Enums\RegionLevel;

return new class extends Migration
{
    public function up()
    {
        Schema::create('idd_regions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('label');
            $table->string('bps_code')->unique()->nullable();
            $table->string('name');
            $table->enum('level', RegionLevel::getValues())
                ->comment('0: country, 1: provinces, 2: regencies/cities, 3: subdistricts/districts, 4: villages');
            $table->unsignedInteger('parent_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('idd_regions');
    }
};
