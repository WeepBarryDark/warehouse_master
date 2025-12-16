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
        Schema::create('shipping_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->nullable(); // 订单号/批次号 e.g., LM250220-2C
            $table->date('eta_date')->nullable(); // 预计到达时间
            $table->string('container_number')->nullable(); // 柜号
            $table->string('file_name'); // 原始文件名
            $table->string('file_path'); // 文件存储路径
            $table->string('file_type')->default('xlsx'); // 文件类型
            $table->integer('file_size')->nullable(); // 文件大小(bytes)
            $table->decimal('total_amount', 12, 2)->nullable(); // 总货款
            $table->integer('total_items')->default(0); // 总项目数
            $table->text('notes')->nullable(); // 备注
            $table->string('status')->default('pending'); // pending, processed, failed
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('order_number');
            $table->index('eta_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_documents');
    }
};
