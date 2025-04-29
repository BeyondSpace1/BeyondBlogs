<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;

class Blog extends BaseController
{
    // public function index()
    // {
    //     $model = new PostModel();
    //     $data['posts'] = $model->join('users', 'users.id = posts.user_id')
    //                            ->select('posts.*, users.name as author_name')
    //                            ->findAll();
    //     return view('blog/index', $data);
    // }
    public function index()
    {
        $model = new PostModel();
        $author = $this->request->getGet('author');
        $query = $model->join('users', 'users.id = posts.user_id')
                       ->select('posts.*, users.name as author_name');
        if ($author) {
            $query->like('users.name', $author);
        }
        $data['posts'] = $query->findAll();
        $data['author'] = $author; // Pass search term to view
        return view('blog/index', $data);
    }
    
    public function view($id)
    {
        $model = new PostModel();
        $data['post'] = $model->join('users', 'users.id = posts.user_id')
                              ->select('posts.*, users.name as author_name')
                              ->find($id);
        if (!$data['post']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('blog/view', $data);
    }

    public function author($userId)
    {
        $postModel = new PostModel();
        $userModel = new UserModel();
        $data['posts'] = $postModel->join('users', 'users.id = posts.user_id')
                                   ->select('posts.*, users.name as author_name')
                                   ->where('posts.user_id', $userId)
                                   ->findAll();
        $data['author'] = $userModel->find($userId);
        if (!$data['author']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('blog/author', $data);
    }
}