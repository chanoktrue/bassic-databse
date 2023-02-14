<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี , {{Auth::user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row"> 
                
                <div class="col-md-8">

                    @if(session("success"))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif

                    <div class="card">

                        <div class="card-header">ตารางข้อมูลแผนก</div>
                        
                        <div class="container">
                            <div class="row">
                                <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">ชื่อแผนก</th>
                                        <th scope="col">สร้างโดย</th>
                                        <th scope="col">Create_At</th>
                                        <th scope="col">แก้ไขข้อมูล</th>
                                        <th scope="col">ลบข้อมูล</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($departments as $department)
                                      <tr>
                                        <th>{{$departments->firstItem()+$loop->index}}</th>
                                        <td>{{$department->department_name}}</td>
                                        {{-- join แบบที่1 Eloquent --}}
                                        <td>{{$department->user->name}}</td>                                        
                                        {{-- แบบที่2 --}}
                                        {{-- <td>{{$department->name}}</td> --}}
                                        <td>
                                            @if($department->created_at == NULL)
                                                ไม่ถูกนิยาม
                                            @else
                                                {{Carbon\Carbon::parse($department->created_at)->diffForHumans()}}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('/department/edit/'.$department->id)}}" class="btn btn-primary">แก้ไข</a>
                                        </td>
                                        <td>
                                            <a href="{{url('/department/softdelete/'.$department->id)}}" class="btn btn-danger">ลบข้อมูล</a>
                                        </td>
                                      </tr>
                                    @endforeach
                                    </tbody>
                                  </table>
                                  {{$departments->links()}}
                            </div>
                        </div>               

                    </div>

                    <div class="card my-2">
                        <div class="card-header">ถังขยะ</div>
                        
                        <div class="container">
                            <div class="row">
                                <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">ชื่อแผนก</th>
                                        <th scope="col">สร้างโดย</th>
                                        <th scope="col">Create_At</th>
                                        <th scope="col">กู้คืนข้อมูล</th>
                                        <th scope="col">ลบถาวร</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($trashDepartments as $department)
                                      <tr>
                                        <th>{{$departments->firstItem()+$loop->index}}</th>
                                        <td>{{$department->department_name}}</td>
                                        {{-- join แบบที่1 Eloquent --}}
                                        <td>{{$department->user->name}}</td>                                        
                                        {{-- แบบที่2 --}}
                                        {{-- <td>{{$department->name}}</td> --}}
                                        <td>
                                            @if($department->created_at == NULL)
                                                ไม่ถูกนิยาม
                                            @else
                                                {{Carbon\Carbon::parse($department->created_at)->diffForHumans()}}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('/department/edit/'.$department->id)}}" class="btn btn-primary">กู้คืนข้อมูล</a>
                                        </td>
                                        <td>
                                            <a href="{{url('/department/softdelete/'.$department->id)}}" class="btn btn-danger">ลบถาวร</a>
                                        </td>
                                      </tr>
                                    @endforeach
                                    </tbody>
                                  </table>
                                  {{$departments->links()}}
                            </div>
                        </div>   
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"> แบบฟอร์ม</div>
                        <div class="card-body">
                            <form action="{{route('addDepartment')}}" method="post">
                                @csrf
                                <div class="from-group">
                                    <label for="department_name">ชื่อตำแหน่งงาน</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>
                                @error('department_name')
                                    <div class="my-2">
                                        <span class="text-danger my-2">{{$message}}</span>
                                    </div>
                                @enderror
                                <br>
                                <input type="submit" value="บันทึก" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>

            </div>    
        </div>
    </div>
</x-app-layout>
