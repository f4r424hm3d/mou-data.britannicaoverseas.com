<?php

use App\Http\Controllers\admin\AdminDashboard;
use App\Http\Controllers\admin\AdminLogin;
use App\Http\Controllers\admin\ConcernPersonC;
use App\Http\Controllers\admin\UniversityC;
use App\Http\Controllers\admin\UniversityCommentC;
use App\Http\Controllers\admin\UniversityMouC;
use App\Http\Controllers\admin\UserC;
use App\Http\Controllers\admin\UserForgetPasswordC;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Clear Cache facade value:
Route::get('/clear-cache', function () {
  $exitCode = Artisan::call('cache:clear');
  return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
  $exitCode = Artisan::call('optimize');
  return '<h1>Reoptimized class loader</h1>';
});
Route::get('/f/optimize', function () {
  $exitCode = Artisan::call('optimize:clear');
  return true;
});

//Route cache:
Route::get('/route-cache', function () {
  $exitCode = Artisan::call('route:cache');
  return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
  $exitCode = Artisan::call('route:clear');
  return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
  $exitCode = Artisan::call('view:clear');
  return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function () {
  $exitCode = Artisan::call('config:cache');
  return '<h1>Clear Config cleared</h1>';
});

//For MIgrate:
Route::get('/migrate', function () {
  $exitCode = Artisan::call('migrate');
  return '<h1>Migrated</h1>';
});

Route::get('/f/migrate', function () {
  $exitCode = Artisan::call('migrate');
  return true;
});

/* ADMIN ROUTES BEFORE LOGIN */
Route::middleware(['userLoggedOut'])->group(function () {
  Route::get('/admin/login/', [AdminLogin::class, 'index']);
  Route::post('/admin/login/', [AdminLogin::class, 'login']);
  Route::get('/account/password/reset', [UserForgetPasswordC::class, 'viewForgetPassword']);
  Route::post('/forget-password', [UserForgetPasswordC::class, 'forgetPassword']);
  Route::get('/forget-password/email-sent', [UserForgetPasswordC::class, 'emailSent']);
  Route::get('/email-login', [UserForgetPasswordC::class, 'emailLogin']);
  Route::get('/password/reset', [UserForgetPasswordC::class, 'viewResetPassword']);
  Route::post('/reset-password', [UserForgetPasswordC::class, 'resetPassword']);
  Route::get('/account/invalid_link', [UserForgetPasswordC::class, 'invalidLink']);
});
/* ADMIN ROUTES AFTER LOGIN */
Route::middleware(['userLoggedIn'])->group(function () {
  Route::get('/', [AdminDashboard::class, 'index']);
  Route::get('/admin/logout/', function () {
    session()->forget('userLoggedIn');
    return redirect('admin/login');
  });
  Route::prefix('/admin')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index']);
    Route::get('/dashboard', [AdminDashboard::class, 'index']);
    Route::get('/profile', [AdminDashboard::class, 'profile']);
    Route::post('/update-profile', [AdminDashboard::class, 'updateProfile']);

    Route::prefix('/universities')->group(function () {
      Route::get('add', [UniversityC::class, 'add']);
      Route::get('', [UniversityC::class, 'index']);
      Route::post('/store', [UniversityC::class, 'store']);
      Route::get('/delete/{id}', [UniversityC::class, 'delete']);
      Route::get('/update/{id}', [UniversityC::class, 'add']);
      Route::post('/update/{id}', [UniversityC::class, 'update']);
      Route::post('/import', [UniversityC::class, 'import']);
      Route::post('/bulk-update-import', [UniversityC::class, 'bulkUpdateImport']);
      Route::get('/export', [UniversityC::class, 'export']);
    });
    Route::prefix('/university-mou')->group(function () {
      Route::get('/{university_id}', [UniversityMouC::class, 'index']);
      Route::post('/{university_id}/store', [UniversityMouC::class, 'store']);
      Route::get('/delete/{id}', [UniversityMouC::class, 'delete']);
      Route::get('/{university_id}/update/{id}', [UniversityMouC::class, 'index']);
      Route::post('/{university_id}/update/{id}', [UniversityMouC::class, 'update']);
    });
    Route::prefix('/concern-person')->group(function () {
      Route::get('/get-data', [ConcernPersonC::class, 'getData']);
      Route::get('/delete/{id}', [ConcernPersonC::class, 'delete']);
      Route::post('/store-ajax', [ConcernPersonC::class, 'storeAjax']);
      Route::post('/update/{id}', [ConcernPersonC::class, 'update']);
      Route::get('/{university_id}/', [ConcernPersonC::class, 'index']);
      Route::get('/{university_id}/update/{id}', [ConcernPersonC::class, 'index']);
    });

    Route::middleware('checkRole')->group(function () {
      Route::prefix('/users')->group(function () {
        Route::get('', [UserC::class, 'index']);
        Route::post('/store', [UserC::class, 'store']);
        Route::get('/delete/{id}', [UserC::class, 'delete']);
        Route::get('/update/{id}', [UserC::class, 'index']);
        Route::post('/update/{id}', [UserC::class, 'update']);
      });
    });
  });
});

Route::prefix('common')->group(function () {
  Route::get('/change-status', [CommonController::class, 'changeStatus']);
  Route::get('/update-field', [CommonController::class, 'updateFieldById']);
  Route::get('/update-bulk-field', [CommonController::class, 'updateBulkField']);

  Route::post('add-lead-note', [UniversityCommentC::class, 'store']);
  Route::get('get-lead-notes', [UniversityCommentC::class, 'getAllNotes']);
  Route::get('get-recent-lead-note', [UniversityCommentC::class, 'getRecentNote']);
});
