<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    public $arrName = array(
	    // Man
	    0 => array(
		'name' => array(
		    "Алексей","Артём","Вадим","Владимир","Валентин","Данил","Денис","Дмитрий","Егор","Кирилл","Леонид","Максим","Матвей","Никита","Олег","Павел","Пётр","Роман","Сергей","Станислав"
		),
		'middle' => array(
		    "Алексеевичй","Артёмович","Вадимович","Владимирович","Валентинович","Данилович","Денисович","Дмитриевич","Егорович","Кириллович","Леонидович","Максимович","Матвеевич","Никитович","Олегович","Павлович","Петрович","Романович","Сергеевич","Станиславович"
		),
		'sure' => array(
		    "Иванов","Смирнов","Кузнецов","Попов","Васильев","Петров","Соколов","Михайлов","Новиков","Федоров","Морозов","Волков","Алексеев","Лебедев","Семенов","Егоров","Павлов","Козлов","Степанов","Николаев",
		),
	    ),

	    // Woman
	    1 => array(
		'name' => array(
		    "Алена","Алина","Анна","Богдана","Вера","Влада","Дарина","Дарьяна","Зарина","Любава","Любовь","Людмила","Мария","Марина","Милена","Мирослава","Надежда","Ольга",
		),
		'middle' => array(
		    "Алексеевна","Артёмовна","Вадимовна","Владимировна","Валентиновна","Даниловна","Денисовна","Дмитриевна","Егоровна","Кирилловна","Леонидовна","Максимовна","Матвеевна","Никитишна","Олеговна","Павловна","Петровна","Романовна","Сергеевна","Станиславовна",
		),
		'sure' => array(
		    "Иванова","Смирнова","Кузнецова","Попова","Васильева","Петрова","Соколова","Михайлова","Новикова","Федорова","Морозова","Волкова","Алексеева","Лебедева","Семенова","Егорова","Павлова","Козлова","Степанова","Николаева",
		),
	    )
	);
    
    // Должностя
    public $position = array(
	'titles' => array(
	    1 => 'Информационные технологии',
	    2 => 'Маркетинг',
	    3 => 'Финансы',
	    4 => 'Производственный процесс',
	    5 => 'Работа с клиентами',
	    6 => 'Международные отношения'
	),
	'levels' => array(
	    1 => 'Руководитель по направлению',
	    2 => '%d-й зам. руководителя по направлению',
	    3 => 'Руководитель %d-го отдела по направлению',
	    4 => 'Руководитель %d-го сектора по направлению',
	    5 => '%d-й инженер по направлению',
	    6 => '%d-й старший сотрудник по направлению',
	    7 => '%d-й младший сотрудник по направлению',
	    8 => '%d-й внештатный сотрудник по направлению',
	)
    );

    public $dateStart = 1072908000;	    // 01.01.2004
    public $dateAll = 0;
    
    public $counter = 0;
    public $adder = 3;
    public $rezarr = array();
    public $minCountItem = 50000;
    public $maxSalary = 80000;
    
    public function __construct() {
	$this->dateAll = time()-$this->dateStart;
//	parent::__construct();
    }
    
    public function addPerson(&$arr = array(), $countadd = 3, $line = '', $head = null){
	for($tempStart = 0; $tempStart < $this->adder*$countadd*2; $tempStart++){
	    $this->counter++;
	    if($this->counter > $this->minCountItem){
		exit;
	    }
	    $gender = mt_rand(0, 1);
	    $date = date('Y-m-d', (mt_rand(0, $this->dateAll) + $this->dateStart));
	    $sure = $this->arrName[$gender]['sure'][array_rand($this->arrName[$gender]['sure'])];
	    $name = $this->arrName[$gender]['name'][array_rand($this->arrName[$gender]['name'])];
	    $middle = $this->arrName[$gender]['middle'][array_rand($this->arrName[$gender]['middle'])];
	    
	    if($countadd == 1){
		$arr[$this->counter] = array(
		    'id_line' => $tempStart+1,
		    'worker' => array(),
		);
		 DB::table('employees')->insert([
		    'id' => $this->counter,
		    'surname' => $sure,
		    'name' => $name,
		    'middle_name' => $middle,
		    'position' => $this->position['levels'][$countadd].' "'.$this->position['titles'][$tempStart+1].'"',
		    'employment' => $date,
		    'salary' => (int)round($this->maxSalary/$countadd),
		    'head' => null,
		    'created_at' => $date,
		]);
	    } else {
		$arr[$this->counter] = array(
		    'id_line' => $line,
		    'worker' => array(),
		);
		DB::table('employees')->insert([
		    'id' => $this->counter,
		    'surname' => $sure,
		    'name' => $name,
		    'middle_name' => $middle,
		    'position' => sprintf($this->position['levels'][$countadd],$tempStart+1).' "'.$this->position['titles'][$line].'"',
		    'employment' => $date,
		    'salary' => (int)round($this->maxSalary/$countadd),
		    'head' => $head,
		    'created_at' => $date,
		]);
	    }
	}
    }

    public function testArr(&$arr, $start, $line = '', $keyHad = null){
	if(count($arr) == 0){
	    $this->addPerson($arr,$start, $line, $keyHad);
	} else if($start !== 1){
	    foreach($arr as $key => &$vaue){
		if(isset($vaue['worker']) and is_array($vaue['worker'])){
		    $this->testArr($vaue['worker'], $start, $vaue['id_line'], $key);
		}
	    }
	}
    }
    
    public function run()
    {
        for($start = 1; $start < 7 ; $start++){
	    $this->testArr($this->rezarr, $start);
	}
    }
}
