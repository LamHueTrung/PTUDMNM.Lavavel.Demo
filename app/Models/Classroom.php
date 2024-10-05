<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $table = 'classrooms'; // Tên bảng

    protected $primaryKey = 'IdClass'; // Khóa chính
    protected $casts = [
        'IdClass' => 'string',
    ];
    protected $fillable = ['IdClass','NameClass', 'Note', 'Deleted']; // Các trường có thể được gán hàng loạt

    public function students()
    {
        return $this->hasMany(Student::class, 'IdClass'); // Mối quan hệ một-nhiều với bảng Student
    }
}
