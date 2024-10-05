<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students'; // Tên bảng

    protected $primaryKey = 'MSSV'; // Khóa chính
    protected $casts = [
        'MSSV' => 'string',
        'IdClass' => 'string'
    ];

    protected $fillable = ['MSSV', 'LastName', 'FirstName', 'BirthDay', 'Gender', 'Avatar', 'IdClass']; // Các trường có thể được gán hàng loạt

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'IdClass'); // Mối quan hệ nhiều-một với bảng Classroom
    }
}
