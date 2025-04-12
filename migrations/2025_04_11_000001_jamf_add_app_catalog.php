<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class JamfAddAppCatalog extends Migration
{
    private $tableName = 'jamf';

    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->longtext('jamf_app_catalog_apps_management')->nullable();
            // $table->index('jamf_app_catalog_apps_management', 'jamf_app_catalog_idx');
        });
    }

    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            // $table->dropIndex('jamf_app_catalog_idx');
            $table->dropColumn('jamf_app_catalog_apps_management');
        });
    }
} 