<?php

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
//use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Request;
//use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/workers', [
    'as' => 'workers', 'uses' => 'FirstController@indexList'
]);
Route::match(['get', 'post'],'/search/{search?}', [
    'as' => 'shearch_work', 'uses' => 'FirstController@shearch'
]);
Route::post('/serch-name', [
    'as' => 'serch_name', 'uses' => 'FirstController@serchName'
]);
Route::post('/save-ord', [
    'as' => 'save_ord', 'uses' => 'FirstController@saveOrd'
]);
Route::get('/{ident?}', [
    'as' => 'see_item', 'uses' => 'FirstController@seeItem'
])->where('ident', '[0-9]*');

Route::get('/edit/{ident?}', [
    'as' => 'edit_item', 'uses' => 'FirstController@editItem'
])->where('ident', '[0-9]*');

Route::post('/save', [
    'as' => 'save_item', 'uses' => 'FirstController@saveItem'
]);

Route::post('/gat-heads', [
    'as' => 'gate_heads', 'uses' => 'FirstController@gateHeads'
]);

Route::get('/add', [
    'as' => 'add_item', 'uses' => 'FirstController@editItem'
])->where('ident', '[0-9]*');

Route::post('/dell-worker', [
    'as' => 'dell_worker', 'uses' => 'FirstController@deleteWorker'
]);

Route::get('/drag-n-drop', [
    'as' => 'drag_n_drop', 'uses' => 'FirstController@dragNdrop'
]);

Route::get('/see-worker/{ident?}', [
    'as' => 'see_worker', 'uses' => 'FirstController@seeWrker'
]);

Route::post('/add-elem-dragn', [
    'as' => 'add_elem_dragn', 'uses' => 'FirstController@addElemDragn'
]);

Route::post('/drope-head', [
    'as' => 'drope_head', 'uses' => 'FirstController@updateHead'
]);

//Route::get('/test', [
//    'as' => 'test', 'uses' => function(){
//	    $all = new App\Repositories\Employees\EloquentEmployeesRepository();
//	    dump($all->find(10)->head);
////	    dump($all->dropeHead(10));
////	    dump($all->find(10)->head);
//	    dd('End');
//	}
//]);

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');