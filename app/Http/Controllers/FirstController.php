<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Employees\EloquentEmployeesRepository;
use App\Repositories\Avatar\EloquentAvatarRepository;
use Illuminate\Support\Facades\View;
use Cookie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class FirstController extends Controller
{
    public $baseItems = array('name','surname','middle_name','position','salary','employment');
    public $baseLines = array(
	0 => "Выберите направление",
	1 => "Информационные технологии",
	2 => "Маркетинг",
	3 => "Финансы",
	4 => "Производственный процесс",
	5 => "Работа с клиентами",
	6 => "Международные отношения",
	7 => "Директор",
    );
    public $baseOrderLines = array('ASC','DESC');
    
    public function __construct() {
//	parent::__construct();
	$this->middleware('auth');
    }

    public function index(){
	$data = array();
	return view('index')->withData($data);
    }
    
    public function indexList(Request $request)
    {
	$data = array();
	$order = '';
	if(empty($request->cookie('order-item'))){
	    Cookie::queue('order-item', 'id', 12400);
	    Cookie::queue('order-line', env('APP_ORDER', 'ASC'), 12400);
	}
	    return view('index');
    }
    
    public function saveOrd(Request $request)
    {
	$order = 'id';
	if(empty($request->cookie('order-item'))){
	    Cookie::queue('order-item', 'id', 12400);
	    Cookie::queue('order-line', env('APP_ORDER', 'ASC'), 12400);
	}
	if($request->has('ord')){
	    switch ($request->ord) {
		case 'n':
		    $order = 'name';
		    break;
		case 's':
		    $order = 'surname';
		    break;
		case 'm':
		    $order = 'middle_name';
		    break;
		case 'p':
		    $order = 'position';
		    break;
		case 'in':
		    $order = 'employment';
		    break;
		case 'sal':
		    $order = 'salary';
		    break;
		default:
		    $order = 'id';
		    break;
	    }
	}
	if($request->cookie('order-item') == $order and $order != 'id'){
	    if($request->cookie('order-line') == 'ASC'){
		Cookie::queue('order-line', 'DESC', 12400);
	    } else {
		Cookie::queue('order-line', 'ASC', 12400);
	    }
	} else {
	    Cookie::queue('order-item', $order, 12400);
	    Cookie::queue('order-line', 'ASC', 12400);
	}
	return response()->json([
	    'successful' => true,
	]);
    }
    
    public function shearch(Request $request)
    {
	$data = array();
	$order = '';
	if($request->has('s')){
	    $search = $request->s;
	    $data['search'] = $search;
	    $employeesRepo = new EloquentEmployeesRepository();
	    $data['rezult'] = $employeesRepo->search($search);
	    return view('search')->withData($data);
	} else {
	    return redirect()->route('workers');
	}
    }
    
    public function serchName(Request $request)
    {
	$rezult = null;
	$data = array(
		'name' => '',
		'surname' => '',
		'middle_name' => '',
		'position' => '',
		'salary' => '',
		'employment' => '',
	    );
	$orderItem = 'id';
	$orderLine = 'ASC';
	$page = 1;
	if($request->has('name')){
	    $data['name'] = trim($request->name);
	}
	if($request->has('sure')){
	    $data['surname'] = trim($request->sure);
	}
	if($request->has('middle')){
	    $data['middle_name'] = trim($request->middle);
	}
	if($request->has('position')){
	    $data['position'] = trim($request->position);
	}
	if($request->has('salary')){
	    $data['salary'] = trim($request->salary);
	}
	if($request->has('inner')){
	    $data['employment'] = trim($request->inner);
	}
	if($request->has('p') and ($request->p >= 1)){
	    $page = (int)trim($request->p);
	}
	if(!empty($request->cookie('order-item')) and in_array($request->cookie('order-item'), $this->baseItems)){
	    $orderItem = $request->cookie('order-item');
	}
	if(!empty($request->cookie('order-line')) and in_array($request->cookie('order-line'), $this->baseOrderLines)){
	    $orderLine = $request->cookie('order-line');
	}
	$employeesRepo = new EloquentEmployeesRepository();
	$rezult = $employeesRepo->searchByData($data, $page, $orderItem, $orderLine);
	if(!empty($rezult['count'])){
	    $view = view('workers')->withData($rezult)->render();
	    return response()->json([
		'successful' => array(
		    'workers' => $view,
		    'counter' => $this->customPaginat($rezult['count'], $page)
		),
	    ]);
	} else {
	    return response()->json([
		'errors' => 'Error',
	    ]);
	    
	}
    }
    
    public function seeItem(Request $request){
	if(!empty($request->route('ident'))){
	    $id = (int)$request->route('ident');
	    $employeesRepo = new EloquentEmployeesRepository();
	    $worker = $employeesRepo->find($id);
	    if(!empty($worker->name)){
		return view('worker_item')->withData($worker);
	    }
	}
	return redirect()->route('workers');
    }
    
    public function deleteWorker(Request $request){
	if(!empty($request->has('ident'))){
	    $id = (int)$request->ident;
	    $employeesRepo = new EloquentEmployeesRepository();
	    $tempD = new EloquentAvatarRepository();
	    if($employeesRepo->dellWorker($id) and $tempD->dellAvaByWorker($id)){
		return response()->json([
		    'successful' => true
		]);
	    }
	}
	return response()->json([
	    'errors' => 'Error',
	]);
    }
    
    public function editItem(Request $request){
	$data = array();
	$worker = array(
	    'id' => '',
	    'surname' => '',
	    'name' => '',
	    'middle_name' => '',
	    'position' => '',
	    'employment' => '',
	    'salary' => '',
	    'head' => '',
	    'avatar' => '',
	);
	$head = '';
	if(!empty($request->route('ident'))){
	    $id = (int)$request->route('ident');
	    $employeesRepo = new EloquentEmployeesRepository();
	    $tempWorker = $employeesRepo->find($id);
	    if(!empty($tempWorker->name)){
		$worker = array(
		    'id' => $tempWorker->id,
		    'surname' => $tempWorker->surname,
		    'name' => $tempWorker->name,
		    'middle_name' => $tempWorker->middle_name,
		    'position' => (!empty($tempWorker->position))? $tempWorker->position : '',
		    'employment' => (!empty($tempWorker->employment))? $tempWorker->employment : '',
		    'salary' => (!empty($tempWorker->salary))? $tempWorker->salary : '',
		    'head' => (!empty($tempWorker->head))? $tempWorker->head : '',
		    'avatar' => (!empty($tempWorker->avatar))? $tempWorker->avatar->url : '',
		);
		if(!empty($tempWorker->head)){
		    $tempHead = $employeesRepo->find((int)$tempWorker->head);
		    $head = "$tempHead->surname $tempHead->name $tempHead->middle_name $tempHead->position";
		}
		return view('worker_add')->withData($worker)->withHead($head)->withLines($this->baseLines);
	    }
	} else {
	    return view('worker_add')->withData($worker)->withHead($head)->withLines($this->baseLines);
	}
	return redirect()->route('workers');
    }
    
    public function saveItem(Request $request)
    {
	$input = $request->except(['_token', 'head-lines']);
	$validator = Validator::make($request->all(),[
	    'id' => 'exists:employees,id',
	    'surname' => 'required | regex:/^([А-Яа-я])+$/u',
	    'name' => 'required | regex:/^([А-Яа-я])+$/u',
	    'middle_name' => 'required | regex:/^([А-Яа-я])+$/u',
	    'position' => 'required',
	    'employment' => 'required | date',
	    'salary' => 'integer | min:0',
	    'head' => 'exists:employees,id',
	    'img' => 'mimes:jpg,jpeg,png',
        ]
	,[
	    'id.exists' => 'Что-то пошло не так :-0',
	    'surname.regex' => 'Использованы недопустимые символы',
	    'surname.required' => 'Обязательно для заполнения',
	    'name.regex' => 'Использованы недопустимые символы',
	    'name.required' => 'Обязательно для заполнения',
	    'middle_name.regex' => 'Использованы недопустимые символы',
	    'middle_name.required' => 'Обязательно для заполнения',
	    'position.required' => 'Обязательно для заполнения',
	    'employment.required' => 'Обязательно для заполнения',
	    'salary.integer' => 'Использываны недопустимые символы',
	]
		);
	// custom validate
//	if(!$validator->fails()){
//	}
	
	if(count($validator->errors()) > 0 ){
	    return response()->json([
		'errors' => $validator->errors(),
	    ]);
	} else {
	    $employeesRepo = new EloquentEmployeesRepository();
	    $tepmVal = $employeesRepo->saveWorker($input);
	    if($tepmVal){
		$avatarRepo = new EloquentAvatarRepository();
		if($request->hasFile('img') and $request->img->isValid()){
		    $file = $request->img;
		    $avatarRepo->saveFile($file, $tepmVal);
		} else if(!empty($input['remove_img'])){
		    $avatarRepo->dellAvaByWorker($tepmVal);
		}
		return response()->json([
		    'successful' => route('see_item', ['ident' => $tepmVal]),
		]);
	    } else {
		$validator->getMessageBag()->add('other', 'Что-то пошло не так :-0');
		return response()->json([
		    'errors' => $validator->errors(),
		]);
	    }
	}

    }
    
    public function gateHeads(Request $request){
	$data = array();
	if($request->has('line') and ($request->line != 0) and !empty($this->baseLines[(int)$request->line])){
	    $employeesRepo = new EloquentEmployeesRepository();
	    $line = $this->baseLines[(int)$request->line];
	    $workers = $employeesRepo->findByLine($line);
	    if($workers->count() > 0){
		$view = view('heads_select')->withData($workers)->render();
		return response()->json([
		    'successful' => array(
			'workers' => $view,
		    ),
		]);
	    } else {
		return response()->json([
		    'errors' => 'Error',
		]);

	    }
	}
    }
    
    public function addElemDragn(Request $request){
	$data = array();
	if($request->has('ident')){
	    $employeesRepo = new EloquentEmployeesRepository();
	    $worker = $employeesRepo->find((int)$request->ident);
	    if(!empty($worker->id)){
		$view = view('drag_drop_elem')->withData($worker)->render();
		return response()->json([
		    'successful' => $view,
		]);
	    } else {
		return response()->json([
		    'errors' => 'Error',
		]);

	    }
	}
    }
    
    public function updateHead(Request $request){
	$data = array();
	if(isset($request->ident) and isset($request->head)){
	    $employeesRepo = new EloquentEmployeesRepository();
	    $worker = $employeesRepo->updateHead((int)$request->ident, (int)$request->head);
	    if(!empty($worker->id) and empty($request->head)){
		$view = view('drag_drop_elem')->withData($worker)->render();
		return response()->json([
		    'successful' => $view,
		]);
	    } else if(!empty($worker->id) and !empty($request->head)){
		$view = view('drag_drop_elem_smal')->withData($worker)->render();
		return response()->json([
		    'successful' => $view,
		]);
	    } else {
		return response()->json([
		    'errors' => 'Error',
		]);

	    }
	}
    }
    
    public function dragNdrop(Request $request){
	$data = array();
	$employeesRepo = new EloquentEmployeesRepository();
	$data = $employeesRepo->findNoHead();
	return view('dragNdrop')->withData($data);
    }
    
    public function seeWrker(Request $request){
	$data = array();
	if(!empty($request->route('ident'))){
	    $id = (int)$request->route('ident');
	    $employeesRepo = new EloquentEmployeesRepository();
	    $data = $employeesRepo->find($id);
	    return view('worker_small')->withData($data)->render();
	}
    }
    
    public function customPaginat($countItem = 1, $activPage = 1){
	if($countItem > 0){
	    $limit = env('APP_LIMIT_ITEM', 25);
	    $rezArr = array();
	    $count_page = ceil($countItem/$limit);
	    if($activPage == 1){
		$rezArr[] = array(
		    'name' => '«',
		    'href' => '',
		    'active' =>  "disabled"
		);  
	    } else {
		$rezArr[] = array(
		    'name' => '«',
		    'href' => $activPage-1,
		    'active' =>  ""
		);
	    }
	    if($count_page <= 9 ){
		for($item = 1;$item <= $count_page; $item ++){
		    if($item === $activPage){
			$rezArr[$item] = array(
			    'name' => $item,
			    'href' => '',
			    'active' =>  "active"
			); 
		    } else {
			$rezArr[$item] = array(
			    'name' => $item,
			    'href' => '#',
			    'active' => ''
			);
		    }
		}
	    } else if($count_page > 9){
		for($item = 1; $item <= $count_page; $item ++){
		    if($item === $activPage and $item !== 1 and $item !== $count_page){
			$rezArr[] = array(
			    'name' => $item,
			    'href' => '',
			    'active' =>  "active"
			);
		    } else if($item === $activPage and ($item === 1 or $item === $count_page)){
			$rezArr[] = array(
			    'name' => $item,
			    'href' => '',
			    'active' =>  'active'
			);
		    } else if($item !== $activPage and ($item == 1 or $item == $count_page)){
			$rezArr[] = array(
			    'name' => $item,
			    'href' => '#',
			    'active' =>  ''
			);
		    } else if($item !== $activPage and ($item == 2 or $item == $count_page-1)){
			$rezArr[] = array(
			    'name' => $item,
			    'href' => '#',
			    'active' =>  ''
			);
		    } else if(($item === ($activPage+1)) or ($item === ($activPage-1))){
			$rezArr[] = array(
			    'name' => $item,
			    'href' => '#',
			    'active' =>  ''
			);
		    } else if(($item === ($activPage+2)) or ($item === ($activPage-2))){
			$rezArr[] = array(
			    'name' => $item,
			    'href' => '#',
			    'active' =>  ''
			);
		    } else if(($item === ($activPage+3)) or ($item === ($activPage-3))){
			$rezArr[] = array(
			    'name' => $item,
			    'href' => '#',
			    'active' =>  ''
			);
		    } else if(($item === ($activPage+4)) or ($item === ($activPage-4))){
			$rezArr[] = array(
			    'name' => '...',
			    'href' => '',
			    'active' =>  'disabled'
			);
		    }
		}
	    }
	    if($activPage == $count_page){
		$rezArr[] = array(
		    'name' => '»',
		    'href' => '',
		    'active' =>  "disabled"
		);  
	    } else {
		$rezArr[] = array(
		    'name' => '»',
		    'href' => $activPage+1,
		    'active' =>  ""
		);
	    }
	    $view = view('custom_paginate')->withData($rezArr)->render();
	    return $view;
	} else {
	    return null;
	}
    }
}
