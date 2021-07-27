<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('lead_id');
            $table->integer('partner_id');
            $table->text('description')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
            $table->foreign('partner_id', 'projects_partner_lead_id_fk')->references('id')->on('partners')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('lead_id', 'projects_lead_partner_id_fk')->references('id')->on('leads')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
