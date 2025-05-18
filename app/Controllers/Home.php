<?php

namespace App\Controllers;

use App\Models\Core;

class Home extends BaseController
{
    public function index()
    {
        $data =  array(
            'title' => 'Home',
            'body'  => 'welcome_message'
        );
        return view('template', $data);
    }
}
