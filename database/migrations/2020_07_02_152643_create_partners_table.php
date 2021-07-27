<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePartnersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('partners', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('city_id')->nullable()->index('city_id_partners_fk_id_idx');
			$table->integer('country_id')->nullable()->index('country_id_partners_fk_id_idx');
			$table->integer('category_id')->nullable()->index('category_id_partners_id_fk_idx');
			$table->integer('tag_id')->nullable()->index('tag_id_partners_fk_idx');
			$table->string('block', 100)->nullable();
			$table->string('speciality', 100)->nullable();
			$table->text('description', 65535)->nullable();
			$table->string('email', 191)->nullable();
			$table->string('contact', 250)->nullable();
			$table->boolean('is_regular')->nullable();
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
		Schema::drop('partners');
	}

}
