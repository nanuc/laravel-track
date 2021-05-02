<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaravelTrackMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('track_visitors', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index();
            $table->string('device_type')->index()->nullable();
            $table->string('device')->index()->nullable();
            $table->string('platform')->index()->nullable();
            $table->string('platform_version')->index()->nullable();
            $table->string('browser')->index()->nullable();
            $table->string('browser_version')->index()->nullable();
            $table->string('country')->index()->nullable();
            $table->string('city')->index()->nullable();
            $table->decimal('lat', 10, 7)->index()->nullable();
            $table->decimal('lng', 10, 7)->index()->nullable();
            $table->timestamps();
        });

        Schema::create('track_ab_tests', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->timestamps();
        });

        Schema::create('track_ab_test_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('track_ab_test_id')->nullable()->index();
            $table->string('key');
            $table->timestamps();
        });

        Schema::create('track_page_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('track_visitor_id')->nullable()->index();
            $table->string('page_name')->index()->nullable();
            $table->string('route')->index()->nullable();
            $table->string('method')->index();
            $table->string('url', 600)->index();
            $table->foreignId('track_campaign_id')->nullable()->index();
            $table->string('campaign_source', 600)->index()->nullable();
            $table->timestamps();
        });

        Schema::create('track_visitor_ab_test_option', function (Blueprint $table) {
            $table->id();
            $table->foreignId('track_visitor_id')->index();
            $table->foreignId('track_ab_test_id')->index();
            $table->foreignId('track_ab_test_option_id')->index();
        });

        Schema::create('track_goals', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->timestamps();
        });

        Schema::create('track_page_view_goal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('track_visitor_id')->index();
            $table->foreignId('track_page_view_id')->index()->nullable();
            $table->foreignId('track_goal_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('track_campaigns');
        Schema::dropIfExists('track_visitors');
        Schema::dropIfExists('track_ab_tests');
        Schema::dropIfExists('track_ab_test_options');
        Schema::dropIfExists('track_page_views');
        Schema::dropIfExists('track_visitor_ab_test_option');
        Schema::dropIfExists('track_goals');
        Schema::dropIfExists('track_page_view_goal');
    }
}
