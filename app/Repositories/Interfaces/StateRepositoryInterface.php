<?php
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface StateRepositoryInterface
{
    public function getAll(Request $request);
}