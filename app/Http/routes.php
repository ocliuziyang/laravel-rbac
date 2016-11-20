<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/test', function () {

    trait Drive {
        public function hello() {
            echo 'say hello trait!<br>';
        }
    }

    class Person {
        public function eat() {
            echo '人类吃东西<br>';
        }
    }

    class Student extends Person {
        use Drive;
        public function study() {
            echo '学生学习<br>';
        }
    }

    $stu = new Student();
    $stu->study();
    $stu->eat();
    $stu->hello();

});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin\Auth'], function () {

    //登陆 注销
    Route::get('auth/login', 'AuthController@getLogin')->name('admin.auth.login');
    Route::post('auth/login', 'AuthController@postLogin')->name('admin.auth.login');
    Route::get('auth/logout', 'AuthController@getLogout')->name('admin.auth.logout');
    //Register
    Route::get('auth/register', 'AuthController@getRegister')->name('admin.auth.register');
    Route::post('auth/register', 'AuthController@postRegister')->name('admin.auth.register');

});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    Route::get('/index', 'IndexController@index')->name('admin.index');
    //用户管理
    Route::resource('user', 'UserController');

});


Route::get('/createEntrustTest', function (){

    //创建 user 用户
    $user = new \App\Models\User();
    $user->name = 'owner';
    $user->email = 'owner@owner.com';
    $user->password = Hash::make('owner');
    $user->save();

    //创建 role 角色
    $owner = new \App\Models\Role();
    $owner->name = 'owner';
    $owner->display_name = '项目所有者';
    $owner->description = '创建项目源代码的 coder';
    $owner->save();

    $admin = new \App\Models\Role();
    $admin->name = 'admin';
    $admin->display_name = '系统管理员';
    $admin->description = '系统后台的超级管理员';
    $admin->save();

    //为用户设置角色
    $user->attachRole($owner);

    //创建权限
    $postIndex = new \App\Models\Permission();
    $postIndex->name = 'admin.post.index';
    $postIndex->display_name = '访问文章主页';
    $postIndex->description = '访问文章主页权限';
    $postIndex->save();

    $userIndex = new \App\Models\Permission();
    $userIndex->name = 'admin.user.index';
    $userIndex->display_name = '访问管理用户主页';
    $userIndex->description = '访问管理用户主页权限';
    $userIndex->save();

    //为角色添加权限
    $owner->attachPermissions([$postIndex, $userIndex]);
    $admin->attachPermission($postIndex);



});
