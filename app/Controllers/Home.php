<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        echo view('template/startseiteHEADER');
        echo view('startseiteBODY');
        echo view('template/startseiteFOOTER');
    }

    public function test(): string
    {
        return view('test');
    }

}
