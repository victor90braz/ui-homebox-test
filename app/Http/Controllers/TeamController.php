<?php

namespace App\Http\Controllers;

class TeamController extends Controller{

    protected $name;
    protected $members = [];

    public function __construct($name, $members=[])
    {
    $this->name = $name;
    $this->members = $members;
    }

    public static function start(...$params) { // ...$params to get all parameters from constructor
    return new static(...$params);
    }

    public function name() {
    return $this->name;
    }

    public function add($name) {
    return $members[] = $name;
    }

    public function members() {
    return $this->members;
    }

}
