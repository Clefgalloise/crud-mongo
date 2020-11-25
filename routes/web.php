<?php

use Illuminate\Support\Facades\Route;

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

Route::get('view/{id}', function () {
    $datas = [];
    for($i = 1; $i <= 15; $i++){
        $datas[] = [
            'id' => $i,
            'name' => 'Name'.$i,
            'description' => 'Description'.$i,
            'picture_url' => 'PictureUrl'.$i,
            'host_name' => 'Name Host'.$i,
            'host_about' => 'About Host'.$i,
            'host_response_time' => '2 Hours'.$i,
            'host_picture_url' => 'HostUrl'.$i,
            'other' => 'DATA NOT SHOWED IN LIST BUT IN VIEW'
        ];
    }

    $data = null;
    $dataSend = [];

    foreach($datas as $dataTemp){
        if($dataTemp['id'] == request('id')){
            $data = $dataTemp;         
        }
    }

    return view('view')->with('data', $data);;
});

Route::get('edit/{id}', function () {
    $datas = [];
    for($i = 1; $i <= 15; $i++){
        $datas[] = [
            'id' => $i,
            'name' => 'Name'.$i,
            'description' => 'Description'.$i,
            'picture_url' => 'PictureUrl'.$i,
            'host_name' => 'Name Host'.$i,
            'host_about' => 'About Host'.$i,
            'host_response_time' => '2 Hours'.$i,
            'host_picture_url' => 'HostUrl'.$i,
            'other' => 'DATA NOT SHOWED IN LIST BUT IN VIEW'
        ];
    }
    
    $data = null;
    $dataSend = [];

    foreach($datas as $dataTemp){
        if($dataTemp['id'] == request('id')){
            $data = $dataTemp;         
        }
    }
    
    return view('edit')->with('data', $data);;
});

