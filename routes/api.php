<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('v1')->group(function (){
    Route::post('update_balance',[UserController::class,'updateBalance']);
});
