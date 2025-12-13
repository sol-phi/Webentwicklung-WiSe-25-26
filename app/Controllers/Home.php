<?php
// Datei: app/Controllers/Home.php

namespace App\Controllers;

class Home extends BaseController
{
    public function getIndex()
    {
        return redirect()->to(base_url('main-controller/tasks'));
    }
}