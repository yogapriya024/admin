<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 191);
            $table->string('service', 250)->nullable();
            $table->string('type', 100)->nullable();
            $table->string('company', 250)->nullable();
            $table->string('contact_name', 100)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('url', 250)->nullable();
            $table->date('last_date')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('customer_requests');
    }
}
