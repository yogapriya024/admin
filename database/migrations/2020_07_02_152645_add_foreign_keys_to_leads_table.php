<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLeadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('leads', function(Blueprint $table)
		{
			$table->foreign('country_id', 'country_id_leads_fk')->references('id')->on('country')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('city_id', 'lead_city_id_fk')->references('id')->on('city')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('tag_id', 'tag_leads_id_fk')->references('id')->on('tags')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('leads', function(Blueprint $table)
		{
			$table->dropForeign('country_id_leads_fk');
			$table->dropForeign('lead_city_id_fk');
			$table->dropForeign('tag_leads_id_fk');
		});
	}

}
