<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoVietnameseCharacters implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        // Kiểm tra xem chuỗi có chứa ký tự tiếng Việt hay không
        return !preg_match('/[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ]/u', $value);
    }

    public function message()
    {
        return 'Trường :attribute không được chứa ký tự tiếng Việt.';
    }
}
