<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListSourcesController extends Controller
{
    public function __invoke()
    {
        $sources = array_keys(config('services.news-api-providers'));
        return response(['data' => $sources]);
    }}
