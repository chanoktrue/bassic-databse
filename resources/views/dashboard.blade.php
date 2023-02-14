<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี , {{Auth::user()->name}}

            <b class="float-end"> จำนวนผู้ใช้ระบบ <span>{{count($users)}} </span> คน</b>
        </h2>
    </x-slot>

    <div class="py-12">
     

        <div class="container">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">อีเมล</th>
                        <th scope="col">เริ่มใช้งานระบบ</th>
                      </tr>
                    </thead>
                    <tbody>
                    @php($i=1)
                    @foreach ($users as $user)
                      <tr>
                        <th>{{$i++}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        {{-- // แบบที่ 1 --}}
                        {{-- <td>{{$user->created_at->diffForHumans()}}</td> --}}
                        {{-- // แบบที่ 2 --}}
                        <td>{{Carbon\Carbon::parse($user->created_at)->diffForHumans()}}</td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
            </div>
        </div>

        
    </div>
</x-app-layout>
