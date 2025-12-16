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
        Schema::create('shipping_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_document_id')->constrained()->onDelete('cascade');
            $table->string('model_number'); // 型号 e.g., ES-02, EV-07, AQUA-003
            $table->string('product_name')->nullable(); // 产品名称
            $table->string('category')->nullable(); // 分类
            $table->integer('quantity')->default(0); // 数量
            $table->integer('carton_quantity')->nullable(); // 箱数
            $table->decimal('unit_price', 10, 2)->nullable(); // 单价
            $table->decimal('total_price', 12, 2)->nullable(); // 总价
            $table->string('carton_number')->nullable(); // 箱号
            $table->decimal('gross_weight', 10, 2)->nullable(); // 毛重(kg)
            $table->decimal('net_weight', 10, 2)->nullable(); // 净重(kg)
            $table->decimal('volume', 10, 3)->nullable(); // 体积(m³)
            $table->string('specifications')->nullable(); // 规格
            $table->text('notes')->nullable(); // 备注
            $table->integer('row_number')->nullable(); // Excel中的行号
            $table->timestamps();

            $table->index('model_number');
            $table->index('shipping_document_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_items');
    }
};
