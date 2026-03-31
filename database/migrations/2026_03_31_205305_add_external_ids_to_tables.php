<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('external_id')->nullable()->after('id');
            $table->string('marketplace')->nullable()->after('external_id');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->string('external_id')->nullable()->after('id');
            $table->string('marketplace')->nullable()->after('external_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('external_category_id')->nullable()->after('category_id');
            $table->string('external_brand_id')->nullable()->after('brand_id');
            $table->string('marketplace')->nullable()->after('id');
            $table->string('barcode')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['external_id', 'marketplace']);
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['external_id', 'marketplace']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['external_category_id', 'external_brand_id', 'marketplace']);
        });
    }
};
