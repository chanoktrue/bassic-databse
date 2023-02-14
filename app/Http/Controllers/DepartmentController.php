<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

// แบบที่ 2
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index() {
        // แบบที่1
        // $departments = Department::all();
        
        // การแบ่งหน้า
        $departments = Department::paginate(5);
        $trashDepartments = Department::onlyTrashed()->paginate(3);

        // แบบที่2
        // $departments = DB::table('departments')->get();

        // การแบ่งหน้า
        // $departments = DB::table('departments')->paginate(3);

        // การ Join
        // $departments = DB::table('departments')
        // ->join('users', 'departments.user_id', 'users.id')
        // ->select('departments.*', 'users.name')
        // ->paginate(5);

        return view('admin.department.index', compact('departments', 'trashDepartments'));
    }

    public function store(Request $request) {
        
        // debug
        // dd($request->department_name);

        // การตรวจสอบ
        $request->validate(
            [
                'department_name'=>'required|unique:departments|max:255'
            ],[
                'department_name.required' => 'กรุณาป้อนชื่อแผนกด้วยครับ',
                'department_name.max' => 'ห้ามป้อนเกิน 255 ตัวอักษร',
                'department_name.unique' => 'มีข้อมูลชื่อแผนกนี้ใฐานข้อมูลแล้ว'
            ]
        );

        // บันทุกข้อมูล

        // แแบที่1 Eloquent
        // $department = new Department;
        // $department->department_name = $request->department_name;
        // $department->user_id = Auth::user()->id;
        // $department->save();


        // แบบที่2 Query Bulider
        $datas = array();
        $datas["department_name"] = $request->department_name;
        $datas["user_id"] = Auth::user()->id;

        DB::table('departments')->insert($datas);

        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");

    }

    public function edit($id) {
        $department = Department::find($id);
        return view('admin.department.edit', compact('department'));
    }

    public function update(Request $request, $id) {

        // ตรวจสอบข้อมูล
        $request->validate(
            [
                'department_name'=>'required|max:255'
            ],[
                'department_name.required' => 'กรุณาป้อนชื่อแผนกด้วยครับ',
                'department_name.max' => 'ห้ามป้อนเกิน 255 ตัวอักษร'
            ]
        );    
        

        // แแบที่1 Eloquent
        
        // $update = Department::find($id)->update([
        //     'department_name' => $request->department_name,
        //     'user_id' => Auth::user()->id
        // ]);

        // แบบที่ 2
        DB::update(
            'update departments set department_name = ? where id = ?', [$request->department_name, $id]
        );

        return redirect()->route('department')->with('success', "อัพเด๖ข้อมูลเรียบร้อย");
    }

    public function softdelete($id) {
        // dd($id);
        $delete =  Department::find($id)->delete();
        return redirect()->back()->with('success', "ลบข้อมูลเรียบร้อย");
    }
}
