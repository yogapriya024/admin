<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPartnersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('partners', function(Blueprint $table)
		{
			$table->foreign('category_id', 'category_id_partners_id_fk')->references('id')->on('category')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('city_id', 'city_id_partners_fk_id')->references('id')->on('city')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('country_id', 'country_id_partners_fk_id')->references('id')->on('country')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('tag_id', 'tag_id_partners_fk')->references('id')->on('tags')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('partners', function(Blueprint $table)
		{
			$table->dropForeign('category_id_partners_id_fk');
			$table->dropForeign('city_id_partners_fk_id');
			$table->dropForeign('country_id_partners_fk_id');
			$table->dropForeign('tag_id_partners_fk');
		});
	}

}
