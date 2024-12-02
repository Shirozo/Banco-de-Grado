<?php

use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "", "as" => "subject."], function () {
    Route::get('/', [SubjectController::class, 'show'])->name("index");

    Route::get('/', [SubjectController::class, 'show'])->name("show");

    Route::post('/add/subject', [SubjectController::class, 'store'])->name("store");

    Route::put("/update/subject", [SubjectController::class, 'update'])->name("update");

    Route::delete("/delete/subject", [SubjectController::class, 'destroy'])->name("destroy");
});


Route::group(["prefix" => "grades", "as" => "grade."], function () {

    Route::get("/view/subject/id={id}", [GradeController::class, "show"])->name("show");

    Route::post("/enroll/student", [GradeController::class, "store"])->name("store");

    Route::put('/update', [GradeController::class, "update"])->name("update");

    Route::post("/upload/student/data", [GradeController::class, "upload"])->name("upload");

    Route::delete('/grades/id', [GradeController::class, "delete"])->name("destroy");

    Route::get("/find/id", [GradeController::class, "api"])->name("api");
});


Route::group(["prefix" => "user", "as" => "user."], function () {

    Route::get('/find/id', [UserController::class, "api"])->name("api");
});

Route::group(["prefix" => "student", "as" => "student."], function () {

    Route::get("/find/id", [StudentController::class, "api"])->name("api");
});
require __DIR__ . '/auth.php';