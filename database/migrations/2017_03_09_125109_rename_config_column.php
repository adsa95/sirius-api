<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameConfigColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Using $table->change() won't work here, as the Doctrine DBAL
        // that is responsible for modifying columns cannot detect
        // the database type automatically, and therefore refuses to touch
        // columns of the 'json' type.
        //
        // We'll work around this by dropping the column and adding it again
        // with the proper default value.

        // Make sure we don't lose any extensions
        $configs = DB::table('configs')->select('id', 'config')->get();

        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn('config');
        });

        Schema::table('configs', function (Blueprint $table) {
            $table->json('extensions')->default('{}');
        });

        foreach ($configs as $config) {
            $config->extensions = $config->config;

            if ($config->config === '[]') {
                $config->extensions = '{}';
            }

            DB::table('configs')->where('id', $config->id)->update([
                'extensions' => $config->extensions,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $configs = DB::table('configs')->select('id', 'extensions')->get();

        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn('extensions');
        });

        Schema::table('configs', function (Blueprint $table) {
            $table->json('config')->default('{}');
        });

        foreach ($configs as $config) {
            DB::table('configs')->where('id', $config->id)->update([
                'config' => $config->extensions,
            ]);
        }
    }
}
