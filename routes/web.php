<?php

use App\Http\Controllers\GradeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/", [IndexController::class, "show"])->name("index");

Route::get("/index/api", [IndexController::class, "api"])->name("api");

Route::group(["prefix" => "subject", "as" => "subject.", "middleware" => ['auth']], function () {

    Route::get('/', [SubjectController::class, 'show'])->name("show");

    Route::post('/add', [SubjectController::class, 'store'])->name("store");

    Route::put("/update", [SubjectController::class, 'update'])->name("update");

    Route::delete("/delete", [SubjectController::class, 'destroy'])->name("destroy");

    Route::get("/generate/report/excel/id/{id}", [SubjectController::class, "generateReport"])->name("report");
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

    Route::get("/", [UserController::class, "show"])->name("show");

    Route::get('/find/id', [UserController::class, "api"])->name("api");

    Route::get("/api/data", [UserController::class, "userDataApi"])->name("dataApi");

    Route::post("/store/new/data", [UserController::class, "store"])->name("store");

    Route::delete("/delete/data", [UserController::class, "destroy"])->name("destroy");

    Route::put('/update/data', [UserController::class, "update"])->name("update");
});

Route::group(["prefix" => "student", "as" => "student.", "middleware" => ['auth']], function () {

    Route::get("/", [StudentController::class, "show"])->name("show");
    
    Route::post("/store/data", [StudentController::class, "store"])->name("store");

    Route::put('/update/data', [StudentController::class, "update"])->name("update");

    Route::delete("/delete/data", [StudentController::class, "destroy"])->name("destroy");

    Route::get("/find/id", [StudentController::class, "api"])->name("api");

    Route::get("/find/nav/id", [StudentController::class, "apiNav"])->name("apiNav");

    Route::get("/data/per/subject", [StudentController::class, "dataApi"])->name("dataApi");

    Route::get("/data/all", [StudentController::class, "all"])->name("all");

    Route::get("/get/unique/sy", [StudentController::class, "unique_sy"])->name("sy");

    Route::get("/generate/copy", [GradeController::class, "generate_copy"])->name("generate");

    Route::post("/upload/data", [StudentController::class, "upload"])->name("upload");
});
require __DIR__ . '/auth.php';
