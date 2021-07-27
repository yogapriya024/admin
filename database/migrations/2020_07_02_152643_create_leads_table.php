<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('leads', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 100)->nullable();
			$table->integer('city_id')->index('lead_city_id_fk_idx');
			$table->integer('country_id')->index('country_id_idx');
			$table->string('email', 191);
			$table->string('contact', 250)->nullable();
			$table->string('url', 250)->nullable();
			$table->integer('tag_id')->nullable()->index('tag_leads_id_fk_idx');
			$table->boolean('isrfp')->nullable();
			$table->text('rfp_email_text')->nullable();
			$table->text('description', 65535)->nullable();
			$table->date('date')->nullable();
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
		Schema::drop('leads');
	}

}
