<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNameToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->after('id');
        });

//        $categories = \Illuminate\Support\Facades\DB::table('categories')->selectRaw('id, CONCAT(\'{"en":"\', name_en, \'","tr":"\', name_tr, \'", "el":"\', name_el, \'"}\') AS `name`')->get();

        foreach(\App\Models\Category::all() as $cat) {
            $cat->setTranslation('name', 'en', $cat->name_en);
            $cat->setTranslation('name', 'tr', $cat->name_tr);
            $cat->setTranslation('name', 'el', $cat->name_el);
            $cat->save();
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('name_en');
            $table->dropColumn('name_tr');
            $table->dropColumn('name_el');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('name_en');
            $table->string('name_tr');
            $table->string('name_el');
        });
    }
}
