<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        echo view('templates/header');
        echo view('body');
        echo view('templates/footer');
    }

    public function test(): string
    {
        return view('test');
    }
}
