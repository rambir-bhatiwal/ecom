<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile')->nullable()->after('email');
            $table->string('phone')->nullable()->after('profile');
            $table->string('address')->nullable()->after('phone'); 
            $table->string('insta_profile')->nullable()->after('address');
            $table->string('fb_profile')->nullable()->after('insta_profile');
            $table->string('twitter_profile')->nullable()->after('fb_profile');
            $table->string('linkdin_profile')->nullable()->after('twitter_profile');
            $table->string('git_profile')->nullable()->after('linkdin_profile');
            $table->string('website')->nullable()->after('git_profile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('insta_profile');
            $table->dropColumn('fb_profile');
            $table->dropColumn('twitter_profile');
            $table->dropColumn('linkdin_profile');
            $table->dropColumn('git_profile');
            $table->dropColumn('website');
        });
    }
};
