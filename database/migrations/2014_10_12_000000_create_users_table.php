<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address_street')->nullable();
            $table->string('address_suite')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_zipcode')->nullable();
            $table->decimal('address_geo_lat')->default(0);
            $table->decimal('address_geo_lng')->default(0);
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_catch_phrase')->nullable();
            $table->string('company_business_strength')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
