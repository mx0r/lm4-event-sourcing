<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarReportTable
    extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_reports',
            function (Blueprint $table) {
                $table->string('license_plate')
                      ->unique();
                $table->integer('visit_count')
                      ->default(0);
                $table->decimal('amount_paid', 8, 2, true)
                      ->default(0);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_reports');
    }
}
