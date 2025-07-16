<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\{Font, MaxContentWidth, ModalWidth, PrimaryColor, RecordsPerPage, TableSortDirection};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
//        Schema::disableForeignKeyConstraints();

        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('theme', 255)->nullable();
            $table->string('language', 10)->nullable();
            $table->string('fullwidth')->nullable();
            $table->string('color', 20)->nullable();
//            $table->string('font', 255)->nullable();
            $table->string('background', 20)->nullable();
            $table->string('background_image', 255)->nullable();
            $table->string('template', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->string('site_language')->default('en');
            $table->string('primary_color')->default(PrimaryColor::DEFAULT);
            $table->string('background_color', 255)->nullable();
            $table->string('font')->default(Font::DEFAULT);
            $table->string('max_content_width')->default(MaxContentWidth::DEFAULT);
            $table->string('table_sort_direction')->default(TableSortDirection::DEFAULT);
            $table->unsignedTinyInteger('records_per_page')->default(RecordsPerPage::DEFAULT);

            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->text('about')->nullable();

            $table->string('facebook', 255)->nullable();
            $table->string('twitter', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('github', 255)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->string('youtube', 255)->nullable();
            $table->string('medium', 255)->nullable();

            $table->string('keywords', 255)->nullable();
            $table->text('desc')->nullable();

            $table->string('ga_id', 20)->nullable();
            $table->string('gtag', 20)->nullable();
            $table->string('fathom_id', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
