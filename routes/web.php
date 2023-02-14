<?php

use Illuminate\Support\Facades\Route;

// แบบที่1
// use App\Models\User;

// แบบที่2
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\DepartmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {

        // แบบที่1 มี Model
        // $users = User::all();

        // แบบที่2 ดึงจาก Table โดยตรง
        $users = DB::table('users')->get();

        return view('dashboard', compact('users'));

    })->name('dashboard');
});


Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/department/all', [DepartmentController::class, 'index'])->name('department');
    Route::post('/depmartment/add', [DepartmentController::class, 'store'])->name('addDepartment');
    Route::get('/department/edit/{id}', [DepartmentController::class, 'edit']);
    Route::post('/department/update/{id}', [DepartmentController::class, 'update']);
    Route::get('/department/softdelete/{id}', [DepartmentController::class, 'softdelete']);
});

