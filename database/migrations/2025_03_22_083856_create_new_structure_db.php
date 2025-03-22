<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор пользователя
            $table->string('name'); // Имя пользователя
            $table->string('password'); // Пароль пользователя
            $table->string('phone', 20)->unique(); // Уникальный номер телефона пользователя
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания пользователя
            $table->softDeletes(); // Виртуальное удаление пользователя
        });

        Schema::create('warehouses', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор склада
            $table->string('name'); // Название склада
            $table->text('location')->nullable(); // Адрес склада
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания склада
            $table->softDeletes(); // Виртуальное удаление склада
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор категории
            $table->string('name'); // Название категории
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания категории
            $table->softDeletes(); // Виртуальное удаление категории
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор единицы измерения
            $table->string('name', 50); // Название единицы измерения
            $table->string('short_name', 10); // Краткое название единицы измерения
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания единицы измерения
            $table->softDeletes(); // Виртуальное удаление единицы измерения
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор поставщика
            $table->string('name'); // Название поставщика
            $table->text('contact_info')->nullable(); // Контактная информация поставщика
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания поставщика
            $table->softDeletes(); // Виртуальное удаление поставщика
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор клиента
            $table->string('name'); // Название клиента
            $table->string('phone', 20)->unique(); // Уникальный номер телефона клиента
            $table->text('address')->nullable(); // Адрес клиента
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания клиента
            $table->softDeletes(); // Виртуальное удаление клиента
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор материала
            $table->string('name'); // Название материала
            $table->unsignedBigInteger('category_id'); // Идентификатор категории материала
            $table->unsignedBigInteger('unit_id'); // Идентификатор единицы измерения материала
            $table->text('description')->nullable(); // Описание материала
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания материала
            $table->softDeletes(); // Виртуальное удаление материала

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade'); // Связь с категориями
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade'); // Связь с единицами измерения
        });

        Schema::create('batches', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор партии
            $table->unsignedBigInteger('material_id'); // Идентификатор материала
            $table->unsignedBigInteger('supplier_id')->nullable(); // Идентификатор поставщика
            $table->string('batch_number', 50)->nullable(); // Номер партии
            $table->string('serial_number', 50)->nullable(); // Серийный номер
            $table->decimal('quantity', 15, 3); // Количество
            $table->date('arrival_date'); // Дата прибытия
            $table->date('expiration_date')->nullable(); // Дата истечения срока годности
            $table->enum('status', ['active', 'expired', 'damaged'])->default('active'); // Статус партии
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания партии
            $table->softDeletes(); // Виртуальное удаление партии

            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade'); // Связь с материалами
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null'); // Связь с поставщиками
        });

        Schema::create('warehouse_arrivals', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор прибытия на склад
            $table->unsignedBigInteger('batch_id'); // Идентификатор партии
            $table->unsignedBigInteger('warehouse_id'); // Идентификатор склада
            $table->unsignedBigInteger('user_id'); // Идентификатор пользователя
            $table->decimal('quantity', 15, 3); // Количество
            $table->date('arrival_date'); // Дата прибытия
            $table->enum('status', ['pending', 'received', 'rejected'])->default('pending'); // Статус прибытия
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания прибытия
            $table->softDeletes(); // Виртуальное удаление прибытия

            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade'); // Связь с партиями
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade'); // Связь со складами
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Связь с пользователями
        });

        Schema::create('warehouse_stock', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор запаса на складе
            $table->unsignedBigInteger('batch_id'); // Идентификатор партии
            $table->unsignedBigInteger('material_id'); // Идентификатор материала
            $table->unsignedBigInteger('warehouse_id'); // Идентификатор склада
            $table->decimal('quantity', 15, 3); // Количество
            $table->timestamp('last_updated'); // Дата и время последнего обновления

            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade'); // Связь с партиями
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade'); // Связь с материалами
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade'); // Связь со складами
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор продажи
            $table->unsignedBigInteger('client_id'); // Идентификатор клиента
            $table->unsignedBigInteger('user_id'); // Идентификатор пользователя
            $table->unsignedBigInteger('warehouse_id'); // Идентификатор склада
            $table->date('sale_date'); // Дата продажи
            $table->enum('status', ['pending', 'paid', 'shipped', 'completed', 'cancelled'])->default('pending'); // Статус продажи
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания продажи
            $table->softDeletes(); // Виртуальное удаление продажи

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade'); // Связь с клиентами
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Связь с пользователями
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade'); // Связь со складами
        });

        Schema::create('sales_details', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор деталей продажи
            $table->unsignedBigInteger('sale_id'); // Идентификатор продажи
            $table->unsignedBigInteger('batch_id'); // Идентификатор партии
            $table->unsignedBigInteger('material_id'); // Идентификатор материала
            $table->decimal('quantity', 15, 3); // Количество
            $table->decimal('price_per_unit', 15, 2)->nullable(); // Цена за единицу
            $table->decimal('total_price', 15, 2)->nullable(); // Общая цена
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания деталей продажи
            $table->softDeletes(); // Виртуальное удаление деталей продажи

            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade'); // Связь с продажами
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade'); // Связь с партиями
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade'); // Связь с материалами
        });

        Schema::create('returns', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор возврата
            $table->unsignedBigInteger('sale_detail_id'); // Идентификатор деталей продажи
            $table->unsignedBigInteger('batch_id'); // Идентификатор партии
            $table->unsignedBigInteger('material_id'); // Идентификатор материала
            $table->unsignedBigInteger('warehouse_id'); // Идентификатор склада
            $table->unsignedBigInteger('user_id'); // Идентификатор пользователя
            $table->decimal('quantity', 15, 3); // Количество
            $table->date('return_date'); // Дата возврата
            $table->text('reason')->nullable(); // Причина возврата
            $table->timestamp('created_at')->useCurrent(); // Дата и время создания возврата
            $table->softDeletes(); // Виртуальное удаление возврата

            $table->foreign('sale_detail_id')->references('id')->on('sales_details')->onDelete('cascade'); // Связь с деталями продажи
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade'); // Связь с партиями
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade'); // Связь с материалами
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade'); // Связь со складами
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Связь с пользователями
        });

        Schema::create('warehouse_arrival_photos', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор фотографии
            $table->unsignedBigInteger('warehouse_arrival_id'); // Идентификатор прихода на склад
            $table->string('file_path'); // Путь к файлу фотографии
            $table->string('original_filename'); // Оригинальное имя файла
            $table->string('mime_type'); // MIME-тип файла
            $table->integer('file_size'); // Размер файла в байтах
            $table->text('ai_recognition_data')->nullable(); // Данные распознавания ИИ
            $table->text('description')->nullable(); // Описание фотографии
            $table->timestamp('created_at')->useCurrent(); // Дата и время загрузки
            $table->softDeletes(); // Виртуальное удаление

            $table->foreign('warehouse_arrival_id')->references('id')->on('warehouse_arrivals')->onDelete('cascade'); // Связь с приходами на склад
        });
    }

    public function down()
    {
        Schema::dropIfExists('warehouse_arrival_photos');
        Schema::dropIfExists('returns');
        Schema::dropIfExists('sales_details');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('warehouse_stock');
        Schema::dropIfExists('warehouse_arrivals');
        Schema::dropIfExists('batches');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('units');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('users');
    }
};
