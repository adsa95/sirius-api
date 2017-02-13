<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiriusIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->string('sirius_id', 64)->nullable();
        });

        // Generate ID for existing configs
        $configs = DB::table('configs')->select('id', 'slack_ids', 'sirius_id')->get();

        foreach ($configs as $config) {
            if ($config->sirius_id === null) {
                DB::table('configs')->where('id', $config->id)->update([
                    'sirius_id' => hash('sha256', $config->slack_ids)
                ]);
            }
        }

        // Add NOT NULL
        Schema::table('configs', function (Blueprint $table) {
            $table->string('sirius_id', 64)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn('sirius_id');
        });
    }
}
