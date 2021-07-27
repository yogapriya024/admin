<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeadTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function(Blueprint $table)
        {
            $table->dropForeign('tag_leads_id_fk');
            $table->dropColumn('tag_id');
        });
        Schema::create('lead_tag', function(Blueprint $table)
        {
            $table->integer('tag_id')->index('tag_leads_id_fk_idx');
            $table->integer('lead_id')->index('lead_tag_id_fk_idx');
            $table->foreign('tag_id', 'tag_leads_id_fk')->references('id')->on('tags')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('lead_id', 'lead_tag_id_fk')->references('id')->on('leads')->onUpdate('NO ACTION')->onDelete('NO ACTION');

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
            $table->integer('tag_id')->nullable()->index('tag_leads_id_fk_idx');
            $table->foreign('tag_id', 'tag_leads_id_fk')->references('id')->on('tags')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
        Schema::table('leads', function(Blueprint $table)
        {
            $table->dropForeign('tag_leads_id_fk');
            $table->dropForeign('lead_tag_id_fk');
            $table->dropColumn('tag_id');
            $table->dropColumn('lead_id');
        });
    }
}
