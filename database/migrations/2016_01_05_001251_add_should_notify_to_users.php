<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddShouldNotifyToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('should_notify_about_running')->default(true);
            $table->boolean('should_notify_about_nominating')->default(true);
            $table->boolean('should_notify_about_voting')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'should_notify_about_running',
                'should_notify_about_nominating',
                'should_notify_about_voting',
            ]);
        });
    }
}
