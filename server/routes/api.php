<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ======================= AUTH ROUTES =======================
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify-otp-register', [AuthController::class, 'verifyOtpRegister']);
    Route::post('/update-password-register', [AuthController::class, 'updatePasswordRegister']);
    Route::post('/refresh', [AuthController::class, 'refreshToken']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
});

// ======================= USER ROUTES =======================

Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/my-profile', [UserController::class, 'getMyProfile']);
    Route::get('/{username}', [UserController::class, 'getUserProfile']);
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
    Route::post('/change-password', [UserController::class, 'changePassword']);
});

Route::middleware(['auth'])->prefix('friends')->group(function () {
    Route::post('/request/{receiverId}', [FriendController::class, 'sendFriendRequest']);
    Route::post('/accept/{requestId}', [FriendController::class, 'acceptFriendRequest']);
    Route::post('/decline/{requestId}', [FriendController::class, 'declineFriendRequest']);
    Route::post('/cancel/{receiverId}', [FriendController::class, 'cancelSentRequest']);
    Route::get('/list', [FriendController::class, 'listFriends']);
    Route::get('/requests/received', [FriendController::class, 'receivedRequests']);
    Route::get('/requests/sent', [FriendController::class, 'sentRequests']);
    Route::delete('/unfriend/{friendId}', [FriendController::class, 'unfriend']);
    Route::post('/block/{userId}', [FriendController::class, 'blockUser']);
    Route::post('/unblock/{userId}', [FriendController::class, 'unblockUser']);
    Route::get('/blocked', [FriendController::class, 'blockedUsers']);
});

Route::middleware(['auth'])->prefix('posts')->group(function () {
    Route::post('/', [PostController::class, 'createPost']);                  // Tạo bài đăng mới
    Route::put('/{postId}', [PostController::class, 'updatePost']);          // Cập nhật bài đăng
    Route::delete('/{postId}', [PostController::class, 'deletePost']);       // Xoá bài đăng
    Route::get('/{postId}', [PostController::class, 'getPostDetail']);       // Xem chi tiết bài đăng

    Route::get('/me', [PostController::class, 'getMyPosts']);                // Bài đăng của bản thân
    Route::get('/user/{userId}', [PostController::class, 'getUserPosts']);   // Bài đăng của người khác
    Route::get('/feed', [PostController::class, 'getNewsFeed']);             // Bài đăng từ bạn bè (feed)

    Route::post('/{postId}/like', [PostController::class, 'likePost']);          // Like bài đăng
    Route::delete('/{postId}/unlike', [PostController::class, 'unlikePost']);    // Bỏ like
    Route::get('/{postId}/likes', [PostController::class, 'getPostLikes']);      // Danh sách người đã like

    Route::post('/{postId}/comments', [PostController::class, 'createComment']);       // Bình luận mới
    Route::get('/{postId}/comments', [PostController::class, 'getPostComments']);      // Danh sách bình luận
    Route::put('/comments/{commentId}', [PostController::class, 'updateComment']);     // Cập nhật bình luận
    Route::delete('/comments/{commentId}', [PostController::class, 'deleteComment']);  // Xoá bình luận

    Route::post('/media/upload', [PostController::class, 'uploadMedia']);             // Upload ảnh/video
});
