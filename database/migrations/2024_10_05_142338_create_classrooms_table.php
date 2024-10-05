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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->string('IdClass',255)->primary(); // Khóa chính
            $table->string('NameClass'); // Tên lớp
            $table->text('Note')->nullable(); // Ghi chú
            $table->boolean('Deleted')->default(false); // Trạng thái xóa
            $table->timestamps(); // Thêm created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
