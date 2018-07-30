<?php namespace App\Repositories\Avatar;

interface AvatarRepository {

    public function all();

    public function find($id);

}