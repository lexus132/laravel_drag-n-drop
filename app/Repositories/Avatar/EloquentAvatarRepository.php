<?php namespace App\Repositories\Avatar;

use App\Models\Avatar;
use App\Repositories\Avatar\AvatarRepository;

class EloquentAvatarRepository implements AvatarRepository {

    public function all()
    {
      return Avatar::all();
    }
    
    public function find($id)
    {
      return Avatar::find($id);
    }
    
    public function saveFile($file, $id)
    {
	$tempI = false;
	$this->dellAvaByWorker($id);
	$destinationPath = public_path(). '/img/';
	$filename = $file->getClientOriginalName();
	while(!$tempI){
	    $tempName = str_random(16).'.'.$file->getClientOriginalExtension();
	    if($this->ifExist($tempName)){
		$tempI = true;
	    }
	}
	$url = '/img/'.$tempName;
	$file->move($destinationPath, $tempName);
	$avatart = new Avatar();
	$avatart->title = $filename;
	$avatart->url = $url;
	$avatart->employe_id = (int)$id;
	if($avatart->save()){
	    return $avatart->id;
	}
    }
    
    public function ifExist($line){
	$ifExist = Avatar::where('title', '=', $line)->get();
	if(!empty($ifExist->id)){
	    return false;
	} else {
	    return true;
	}
    }
    
    public function dellAvaByWorker($id)
    {
	$avatars = Avatar::where('employe_id', '=', $id)->get();
	Avatar::where('employe_id', '=', $id)->delete();
	if(!empty($avatars)){
	    foreach($avatars as $value){
		unlink(public_path().$value->url);
	    }
	}
	return true;
    }
    
}