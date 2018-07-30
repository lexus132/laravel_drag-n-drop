<?php namespace App\Repositories\Employees;

use App\Models\Employees;
use App\Repositories\Employees\EmployeesRepository;
use Illuminate\Support\Facades\DB;

class EloquentEmployeesRepository implements EmployeesRepository {

    public $limit = 25;
    
    public function __construct() {
	$this->limit = env('APP_LIMIT_ITEM', 25);
    }    
    
    public function all()
    {
      return Employees::where('id', '>', 0)->paginate($this->limit);
    }
    
    public function headS()
    {
      return Employees::all()->toArray();
    }
    
    public function findByLine($line)
    {
      return Employees::where('position', 'like', '%'.$line.'%')->orderBy('id', 'ASC')->get();
    }

    public function orderFilter($order = '')
    {
	switch ($order) {
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
	    case 'e':
		$order = 'employment';
		break;
	    case 'sal':
		$order = 'salary';
		break;
	    default:
		$order = 'id';
		break;
	}
	return Employees::where('id', '>', 0)->orderBy($order)->paginate($this->limit);
    }

    public function find($id)
    {
	return Employees::find($id);
    }
    
    public function updateHead($id, $head = null)
    {
	$head = (!empty($head))? $head : null;
	$temp = Employees::find($id);
	$temp->head = $head;
	$temp->save();
	return $temp;
    }
    
    public function findHeadsById($id)
    {
	return Employees::where('head', '=', $id)->get();
    }
    
    public function dellWorker($id)
    {
	return Employees::find($id)->delete();
    }

    public function saveWorker($data)
    {
	if(!empty($data['ident'])){
	    $worker = Employees::find((int)$data['ident']);
	} else {
	    $worker = new Employees();
	}
	$worker->surname = (!empty($data['surname']))? ucfirst(strtolower($data['surname'])) : '';
	$worker->name = (!empty($data['name']))? ucfirst(strtolower($data['name'])) : '';
	$worker->middle_name = (!empty($data['middle_name']))? ucfirst(strtolower($data['middle_name'])) : '';
	$worker->position = (!empty($data['position']))? $data['position'] : '';
	$worker->salary = (!empty($data['salary']))? $data['salary'] : 0;
	$worker->employment = (!empty($data['employment']))? $data['employment'] : date('Y-m-d', time());
	$worker->head = (!empty($data['head']))? (int)$data['head'] : null;
	if($worker->save()){
	    return $worker->id;
	} else {
	    return null;
	}
    }

    public function findNoHead()
    {
	return Employees::where('id', '>', 0)->whereNull('head')->with('avatar')->get();
    }
    
    public function search($search = '', $orderItem = 'id', $orderLine = 'ASC')
    {
	if(!empty($search)){
	    return Employees::where('name', 'like', "%{$search}%", 'or')
		->where('surname', 'like', "%{$search}%", 'or')
		->where('middle_name', 'like', "%{$search}%", 'or')
		->where('position', 'like', "%{$search}%", 'or')
		->where('salary', 'like', "%{$search}%", 'or')
//		->where('employment', 'like', "%{$search}%", 'or')
		    ->orderBy($orderItem, $orderLine)
		    ->paginate($this->limit);
	} else {
	    return null;
	}
    }
    
    public function searchByData($search, $step = 1, $orderItem = 'id', $orderLine = 'ASC')
    {
	$count = 0;
	if($step < 1){
	    $start = 0;
	} else {
	    $start = ($step-1) * $this->limit;
	}
	$rezult = Employees::where('name', 'like', "%{$search['name']}%", 'and')
		->where('surname', 'like', "%{$search['surname']}%", 'and')
		->where('middle_name', 'like', "%{$search['middle_name']}%", 'and')
		->where('position', 'like', "%{$search['position']}%", 'and')
		->where('salary', 'like', "%{$search['salary']}%", 'and')
		->where('employment', 'like', "%{$search['employment']}%", 'and')
		    ->orderBy($orderItem, $orderLine)
		    ->limit($this->limit)
		    ->offset($start)->with('avatar')->get();
	$count = Employees::where('name', 'like', "%{$search['name']}%")
		->where('surname', 'like', "%{$search['surname']}%", 'and')
		->where('middle_name', 'like', "%{$search['middle_name']}%", 'and')
		->where('position', 'like', "%{$search['position']}%", 'and')
		->where('salary', 'like', "%{$search['salary']}%", 'and')
		->where('employment', 'like', "%{$search['employment']}%", 'and')
		    ->count();
	if($count > 0){
	    return array('workers' => $rezult, 'count' => $count);
	} else {
	    return null;
	}
    }
    
}