<?php

namespace App\Controllers;

use App\Models\PostModel;

class Admin extends BaseController
{
    public function index()
    {
        $model = new PostModel();
        $data['posts'] = $model->where('user_id', session()->get('user_id'))->findAll();
        return view('admin/dashboard', $data);
    }
}