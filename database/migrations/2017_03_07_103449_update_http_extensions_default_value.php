<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHttpExtensionsDefaultValue extends Migration
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
        $configs = DB::table('configs')->select('id', 'http_extensions')->get();

        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn('http_extensions');
        });

        Schema::table('configs', function (Blueprint $table) {
            $table->json('http_extensions')->default('{}');
        });

        foreach ($configs as $config) {
            if ($config->http_extensions === '[]') {
                $config->http_extensions = '{}';
            }

            DB::table('configs')->where('id', $config->id)->update([
                'http_extensions' => $config->http_extensions,
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
        $configs = DB::table('configs')->select('id', 'http_extensions')->get();

        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn('http_extensions');
        });

        Schema::table('configs', function (Blueprint $table) {
            $table->json('http_extensions')->default('[]');
        });

        foreach ($configs as $config) {
            if ($config->http_extensions === '{}') {
                $config->http_extensions = '[]';
            }

            DB::table('configs')->where('id', $config->id)->update([
                'http_extensions' => $config->http_extensions,
            ]);
        }
    }
}
