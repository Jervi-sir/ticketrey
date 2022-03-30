<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id, advertiser_id, template_id, is_verified
        //images, details, tickets_left
        //campaign_start, campaign_end

        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertiser_id')->constrained();
            $table->foreignId('template_id')->constrained();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_active')->default(0);

            $table->bigInteger('tickets_left');

            $table->longText('images');
            $table->longText('details');

            $table->date('campaign_starts');
            $table->date('campaign_ends');

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
        Schema::dropIfExists('offers');
    }
};
