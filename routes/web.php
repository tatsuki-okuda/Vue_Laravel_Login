<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\BlogController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::redirect('/login', '/');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::resource('/blogs', BlogController::class)
    ->names(['index'=>'blog.index',
            'create' => 'blog.create',
            'edit' => 'blog.edit',
            'update' => 'blog.update',
            'destroy' => 'blog.destroy',
            'store'=>'blog.store'])
    ->middleware(['auth']);


// config/aouthで設定したuser分のrouteをセットする
foreach(config('fortify.users') as $user){
    // prefixとgroupにつけることで各ルーティングの最初に名前をつけられる　　$user/login　のように
    Route::prefix($user)
    ->namespace('\Laravel\Fortify\Http\Controllers')
    // 各ルートに"$user.login"のようにが名付けられる
    ->name($user.'.')
    ->group(function () use($user) {
        /**
        * ログイン 画面
        * @method GET
        */
        Route::name('login')->middleware('guest')
        ->get('/login', 'AuthenticatedSessionController@create');
        /**
        * ログイン 認証
        * @method POST
        */
        Route::name('login')->middleware(['guest', 'throttle:'.config('fortify.limiters.login')])
        ->post('/login', 'AuthenticatedSessionController@store');
        /**
        * ログアウト
        * @method POST
        */
        Route::name('logout')->middleware('guest')
        ->post('/logout', 'AuthenticatedSessionController@destroy');
        /**
        * 登録
        * @method POST
        */
        Route::name('register')->middleware(['guest:'.config('fortify.guard')])
        ->post('/register', 'RegisteredUserController@store');
        /**
        * 登録
        * @method GET
        */
        Route::name('register')->middleware(['guest:'.config('fortify.guard')])
        ->get('/register', 'RegisteredUserController@create');
        /**
        * ダッシュボード
        * @method GET
        */
        Route::name('dashboard')->middleware(['auth:'.\Str::plural($user), 'verified'])
        ->get('/dashboard', function () use($user) {
            return Inertia::render($user.'.dashboard');
        });
    });
}




