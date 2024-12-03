<?php

use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "", "as" => "subject.", "middleware" => ['auth']], function () {
    // Route::get('/', [SubjectController::class, 'show'])->name("index");

    Route::get('/', [SubjectController::class, 'show'])->name("show");

    Route::post('/add/subject', [SubjectController::class, 'store'])->name("store");

    Route::put("/update/subject", [SubjectController::class, 'update'])->name("update");

    Route::delete("/delete/subject", [SubjectController::class, 'destroy'])->name("destroy");
});


Route::group(["prefix" => "grades", "as" => "grade.", "middleware" => ['auth']], function () {

    Route::get("/view/subject/id={id}", [GradeController::class, "show"])->name("show");

    Route::post("/enroll/student", [GradeController::class, "store"])->name("store");

    Route::put('/update', [GradeController::class, "update"])->name("update");

    Route::post("/upload/student/data", [GradeController::class, "upload"])->name("upload");

    Route::delete('/grades/id', [GradeController::class, "delete"])->name("destroy");

    Route::get("/find/id", [GradeController::class, "api"])->name("api");
});


Route::group(["prefix" => "user", "as" => "user.", "middleware" => ['auth']], function () {

    Route::get('/find/id', [UserController::class, "api"])->name("api");
});

Route::group(["prefix" => "student", "as" => "student.", "middleware" => ['auth']], function () {

    Route::get("/", [StudentController::class, "show"])->name("show");
    
    Route::get("/find/id", [StudentController::class, "api"])->name("api");

    Route::get("/data/all", [StudentController::class, "dataApi"])->name("dataApi");

    Route::post("/store/data", [StudentController::class, "store"])->name("store");

    Route::delete("/delete/data", [StudentController::class, "destroy"])->name("destroy");

    Route::put('/update/data', [StudentController::class, "update"])->name("update");

    Route::post("/upload/data", [StudentController::class, "upload"])->name("upload");
});
require __DIR__ . '/auth.php';
