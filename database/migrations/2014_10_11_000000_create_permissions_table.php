<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('view_status')->default(false);
            $table->tinyInteger('add_status')->default(false);
            $table->tinyInteger('edit_status')->default(false);
            $table->tinyInteger('delete_status')->default(false);
            $table->tinyInteger('active_status')->default(false);

            $table->tinyInteger('analytics_status')->default(false);
            $table->tinyInteger('inbox_status')->default(false);
            $table->tinyInteger('newsletter_status')->default(false);
            $table->tinyInteger('calendar_status')->default(false);
            $table->tinyInteger('banners_status')->default(false);
            $table->tinyInteger('settings_status')->default(false);
            $table->tinyInteger('roles_status')->default(false);
            $table->tinyInteger('tags_status')->default(false);
            $table->tinyInteger('popups_status')->default(false);
            $table->tinyInteger('menus_status')->default(false);
            $table->tinyInteger('file_manager_status')->default(false);
            $table->tinyInteger('webmaster_status')->default(false);
            $table->tinyInteger('modules_status')->default(false);


            $table->string('data_sections')->nullable();

            $table->tinyInteger('home_status')->default(false);
            $table->text('home_links')->nullable();

            $table->longText('home_details_ar')->nullable();
            $table->longText('home_details_en')->nullable();
            $table->longText('home_details_ch')->nullable();
            $table->longText('home_details_hi')->nullable();
            $table->longText('home_details_es')->nullable();
            $table->longText('home_details_ru')->nullable();
            $table->longText('home_details_pt')->nullable();
            $table->longText('home_details_fr')->nullable();
            $table->longText('home_details_de')->nullable();
            $table->longText('home_details_th')->nullable();
            $table->longText('home_details_br')->nullable();

            $table->tinyInteger('status');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('permissions');
    }
}
