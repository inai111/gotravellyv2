<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends CustomController
{
    /**
     * menampilkan semua job
     */
    public function index()
    {
        return view('job.index');
    }

    /**
     * 
     */
    public function create()
    {
        return view('job.create');
    }
}
