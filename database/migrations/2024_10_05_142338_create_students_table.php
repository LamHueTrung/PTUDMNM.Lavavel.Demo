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
        Schema::create('students', function (Blueprint $table) {
            $table->string('MSSV')->primary(); // Khóa chính
            $table->string('LastName'); // Họ
            $table->string('FirstName'); // Tên
            $table->date('BirthDay'); // Ngày sinh
            $table->enum('Gender', ['Male', 'Female']); // Giới tính
            $table->string('Avatar')->nullable(); // Đường dẫn ảnh đại diện
            $table->string('IdClass'); // Khóa ngoại liên kết với bảng classrooms

            $table->timestamps(); // Thêm created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
