<?php

namespace App\Controllers;

class Template extends BaseController
{
    public function index(): string
    {
        return view('template');
    }
}