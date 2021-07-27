<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PartnerTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', function(Blueprint $table)
        {
            $table->dropForeign('tag_id_partners_fk');
            $table->dropColumn('tag_id');
        });
        Schema::create('partner_tag', function(Blueprint $table)
        {
            $table->integer('tag_id')->index('tag_id_partners_fk');
            $table->integer('partner_id')->index('partner_tag_id_fk_idx');
            $table->foreign('tag_id', 'tag_id_partners_fk')->references('id')->on('tags')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('partner_id', 'partner_tag_id_fk')->references('id')->on('partners')->onUpdate('NO ACTION')->onDelete('NO ACTION');

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
            $table->integer('tag_id')->nullable()->index('tag_leads_id_fk_idx');
            $table->foreign('tag_id', 'tag_id_partners_fk')->references('id')->on('tags')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
        Schema::table('leads', function(Blueprint $table)
        {
            $table->dropForeign('partner_tag_id_fk');
            $table->dropForeign('tag_id_partners_fk');
            $table->dropColumn('tag_id');
            $table->dropColumn('partner_id');
        });
    }
}
