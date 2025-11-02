<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ref_references', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index();
            $table->string('code')->nullable()->index();
            $table->unique(['type', 'code']);
            $table->string('label');
            $table->integer('sort_order');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ref_references');
    }
};
