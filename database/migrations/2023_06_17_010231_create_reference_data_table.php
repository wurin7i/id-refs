<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use WuriN7i\IdData\Enums\ReferenceType;

return new class extends Migration
{
    public function up()
    {
        Schema::create('idd_reference_data', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('type', ReferenceType::getValues());
            $table->string('label');
            $table->integer('sort_order');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('idd_reference_data');
    }
};
