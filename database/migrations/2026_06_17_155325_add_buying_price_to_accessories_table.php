<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('accessories', function (Blueprint $table) {
        $table->decimal('buying_price', 10, 2)->default(0)->after('price');
    });
}

    public function down()
{
    Schema::table('accessories', function (Blueprint $table) {
        $table->dropColumn('buying_price');
    });
}
};
