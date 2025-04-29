<?php

namespace App\Controllers;

use App\Models\PostModel;

class Post extends BaseController
{
    // public function __construct()
    // {
    //     if (!session()->get('isLoggedIn')) {
    //         return redirect()->to('/login');
    //     }
    // }

    public function create()
    {
        return view('admin/create_post');
    }

    // public function store()
    // {
    //     $model = new PostModel();
    //     $data = [
    //         'user_id' => session()->get('user_id'),
    //         'title' => $this->request->getPost('title'),
    //         'content' => $this->request->getPost('content')
    //     ];

    //     if ($model->insert($data)) {
    //         return $this->response->setJSON(['success' => true]);
    //     } else {
    //         return $this->response->setJSON(['success' => false, 'errors' => $model->errors()]);
    //     }
    // }
    public function store()
    {
        $model = new PostModel();
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|max_length[255]',
            'content' => 'required'
        ]);
    
        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'user_id' => session()->get('user_id'),
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content')
            ];
            if ($model->insert($data)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false, 'errors' => $model->errors()]);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }
    }
    

    public function edit($id)
    {
        $model = new PostModel();
        $data['post'] = $model->find($id);
        if ($data['post']['user_id'] != session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('admin/edit_post', $data);
    }

    // public function update($id)
    // {
    //     $model = new PostModel();
    //     $data = [
    //         'title' => $this->request->getPost('title'),
    //         'content' => $this->request->getPost('content')
    //     ];

    //     if ($model->update($id, $data)) {
    //         return $this->response->setJSON(['success' => true]);
    //     } else {
    //         return $this->response->setJSON(['success' => false, 'errors' => $model->errors()]);
    //     }
    // }
    public function update($id)
    {
        $model = new PostModel();
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|max_length[255]',
            'content' => 'required'
        ]);
    
        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content')
            ];
            if ($model->update($id, $data)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false, 'errors' => $model->errors()]);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }
    }
    public function delete($id)
    {
        $model = new PostModel();
        if ($model->delete($id)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }
}