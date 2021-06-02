<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\InviteController;


// AUTH
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->delete('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/test', [AuthController::class, 'test']);
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getBaseAccountInfo']);
// CHANGES
Route::middleware('auth:sanctum')->get('/user/changes', [UserController::class, 'getAllChangeAccount']);
Route::middleware('auth:sanctum')->get('/user/changes/replenishments', [UserController::class, 'getReplenishmentsChangeAccount']);
Route::middleware('auth:sanctum')->get('/user/changes/invoice', [UserController::class, 'getInvoiceChangeAccount']);
Route::middleware('auth:sanctum')->post('/user/changes/create', [UserController::class, 'createChangeAccount']);
Route::middleware('auth:sanctum')->post('/user/changes/delete', [UserController::class, 'deleteAccountChange']);

Route::middleware('auth:sanctum')->get('/user/names', [UserController::class, 'getAccountNames']);
// GROUPS
Route::middleware('auth:sanctum')->get('/groups', [GroupController::class, 'checkMyGroups']);
Route::middleware('auth:sanctum')->get('/group', [GroupController::class, 'getGroupInfo']);
Route::middleware('auth:sanctum')->post('/groups/create', [GroupController::class, 'createGroup']);
Route::middleware('auth:sanctum')->delete('/groups/leave', [GroupController::class, 'leaveGroup']);
Route::middleware('auth:sanctum')->delete('/groups/kick', [GroupController::class, 'leaveGroup']);
// INVITES
Route::middleware('auth:sanctum')->get('/invite/get', [InviteController::class, 'getInvites']);
Route::middleware('auth:sanctum')->post('/invite/create', [InviteController::class, 'createInvite']);
Route::middleware('auth:sanctum')->post('/invite/success', [InviteController::class, 'acceptInvite']);
Route::middleware('auth:sanctum')->delete('/invite/reject', [InviteController::class, 'rejectInvite']);
