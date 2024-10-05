<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // Hiển thị danh sách sinh viên
    public function index()
    {
        $students = Student::with('classroom')->get();
        return view('students.index', compact('students'));
    }

    // Hiển thị form tạo sinh viên
    public function create()
    {
        $classrooms = Classroom::all();
        return view('students.create', compact('classrooms'));
    }

    // Lưu sinh viên mới
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'MSSV' => 'required|integer|unique:students',
            'LastName' => 'required|string|max:255',
            'FirstName' => 'required|string|max:255',
            'BirthDay' => 'required|date|date_format:Y-m-d|beforeOrEqual:'.now()->subYears(18)->toDateString(),
            'Gender' => 'required|in:male,female',
            'Avatar' => 'nullable|image|max:2048',
            'IdClass' => 'required|exists:classrooms,IdClass',
        ]);

        if ($request->hasFile('Avatar')) {
            // Lưu tệp và lấy đường dẫn
            $avatarPath = $request->file('Avatar')->store('avatars', 'public');
            // Gán đường dẫn đúng cho Avatar
            $validatedData['Avatar'] = $avatarPath;
        } else {
            $validatedData['Avatar'] = 'avatars/profile.png'; // Ảnh mặc định
        }

        // Tạo sinh viên mới với dữ liệu đã được validate
        Student::create($validatedData);

        return redirect()->route('students.index')->with('success', 'Sinh viên đã được tạo thành công.');
    }

    // Hiển thị form sửa sinh viên
    public function edit(Student $student)
    {
        $classrooms = Classroom::all();
        return view('students.edit', compact('student', 'classrooms'));
    }

    // Cập nhật sinh viên
    public function update(Request $request, Student $student)
    {
        // Xác thực dữ liệu yêu cầu
        $request->validate([
            'MSSV' => 'required|integer|unique:students,MSSV,' . $student->MSSV . ',MSSV',
            'LastName' => 'required|string|max:255',
            'FirstName' => 'required|string|max:255',
            'BirthDay' => 'required|date|date_format:Y-m-d|beforeOrEqual:'.now()->subYears(18)->toDateString(),
            'Gender' => 'required|in:male,female',
            'Avatar' => 'nullable|image|max:2048',
            'IdClass' => 'required|exists:classrooms,IdClass',
        ]);

        // Biến để lưu trữ đường dẫn của avatar
        $avatarPath = $student->Avatar;

        // Xử lý tải lên hình đại diện nếu có
        if ($request->hasFile('Avatar')) {
            // Xóa avatar cũ nếu tồn tại (tùy chọn)
            if ($student->Avatar) {
                Storage::disk('public')->delete($student->Avatar);
            }

            // Lưu hình đại diện mới
            try {
                $avatarPath = $request->file('Avatar')->store('avatars', 'public');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['Avatar' => 'Có lỗi xảy ra khi tải lên hình đại diện: ' . $e->getMessage()]);
            }
        }

        // Cập nhật sinh viên với dữ liệu đã xác thực
        $updateSuccess = $student->update($request->except('Avatar') + ['Avatar' => $avatarPath]);

        // Kiểm tra xem có thay đổi nào không
        if (!$updateSuccess) {
            return redirect()->back()->withErrors(['update' => 'Có lỗi xảy ra khi cập nhật thông tin sinh viên.']);
        }

        return redirect()->route('students.index')->with('success', 'Sinh viên đã được cập nhật thành công.');
    }

    // Xóa sinh viên
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Sinh viên đã được xóa thành công.');
    }

    // Hiển thị sinh viên theo class
    public function show($id)
    {
        // Lấy sinh viên theo MSSV
        $students = Student::where('MSSV', $id)->get();

        return view('students.info', compact('students')); // Truyền danh sách sinh viên và lớp học vào view
    }
}
