<?php

use App\Enums\Category\CategoryAttributeName;
use App\Enums\Order\OrderAttributeName;
use App\Enums\Order\OrderProductAttributeName;
use App\Enums\Product\ProductAttributeName;
use Database\TableName;
use App\Enums\User\UserAttributeName;
use App\Enums\User\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TableName::QUEUED_JOBS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create(TableName::FAILED_JOBS, function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create(TableName::NOTIFICATIONS, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create(TableName::MEDIA, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('model');
            $table->uuid('uuid')->nullable()->unique();
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size');
            $table->text('manipulations')->nullable();
            $table->text('custom_properties')->nullable();
            $table->text('generated_conversions')->nullable();
            $table->text('responsive_images')->nullable();
            $table->unsignedInteger('order_column')->nullable()->index();
            $table->nullableTimestamps();
        });

        Schema::create(TableName::USERS, function (Blueprint $table) {
            $table->id(UserAttributeName::ID);
            $table->string(UserAttributeName::EMAIL)->unique();
            // $table->timestamp(UserAttributeName::EMAIL_VERIFIED_AT)->nullable();
            $table->string(UserAttributeName::PASSWORD)->nullable();
            $table->string(UserAttributeName::ROLE)->default(UserRole::CUSTOMER);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create(TableName::PASSWORD_RESETS, function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create(TableName::CATEGORIES, function (Blueprint $table) {
            $table->id(CategoryAttributeName::ID);
            $table->string(CategoryAttributeName::NAME);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create(TableName::PRODUCTS, function (Blueprint $table) {
            $table->id(ProductAttributeName::ID);
            $table->unsignedBigInteger(ProductAttributeName::CATEGORY_ID)->nullable();
            $table->string(ProductAttributeName::NAME);
            $table->text(ProductAttributeName::DESCRIPTION)->nullable();
            $table->unsignedDecimal(ProductAttributeName::PRICE);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create(TableName::ORDERS, function (Blueprint $table) {
            $table->id(OrderAttributeName::ID);
            $table->unsignedBigInteger(OrderAttributeName::USER_ID)->nullable();
            $table->unsignedDecimal(OrderAttributeName::TOTAL_PRICE)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create(TableName::ORDERS_PRODUCTS, function (Blueprint $table) {
            $table->id(OrderProductAttributeName::ID);
            $table->unsignedBigInteger(OrderProductAttributeName::ORDER_ID);
            $table->unsignedBigInteger(OrderProductAttributeName::PRODUCT_ID);
            $table->unsignedInteger(OrderProductAttributeName::QUANTITY);
            $table->unsignedDecimal(OrderProductAttributeName::PRICE);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(TableName::ORDERS_PRODUCTS);
        Schema::dropIfExists(TableName::ORDERS);
        Schema::dropIfExists(TableName::PRODUCTS);
        Schema::dropIfExists(TableName::CATEGORIES);
        Schema::dropIfExists(TableName::PASSWORD_RESETS);
        Schema::dropIfExists(TableName::USERS);
        Schema::dropIfExists(TableName::MEDIA);
        Schema::dropIfExists(TableName::NOTIFICATIONS);
        Schema::dropIfExists(TableName::FAILED_JOBS);
        Schema::dropIfExists(TableName::QUEUED_JOBS);
    }
}
