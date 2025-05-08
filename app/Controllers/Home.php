<?php

namespace App\Controllers;

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
