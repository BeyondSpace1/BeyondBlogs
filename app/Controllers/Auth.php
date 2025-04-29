<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();
        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'user_id' => $user['id'],
                'name' => $user['name'],
                'isLoggedIn' => true
            ]);
            return redirect()->to('/dashboard');
        } else {
             $session->setFlashdata('error', 'Invalid email or password');
            return redirect()->to('/login');
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    // public function doRegister()
    // {
    //     $model = new UserModel();
    //     $data = [
    //         'name' => $this->request->getPost('name'),
    //         'email' => $this->request->getPost('email'),
    //         'password' => $this->request->getPost('password')
    //     ];

    //     if ($model->insert($data)) {
    //         session()->setFlashdata('success', 'Registration successful! Please log in.');
    //         return redirect()->to('/login');
    //     } else {
    //         session()->setFlashdata('error', 'Registration failed.');
    //         return redirect()->to('/register');
    //     }
    // }
    public function doRegister()
    {
        $model = new UserModel();
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ]);
    
        if ($validation->withRequest($this->request)->run()) {
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password')
            ];
            if ($model->insert($data)) {
                session()->setFlashdata('success', 'Registration successful! Please log in.');
                return redirect()->to('/login');
            } else {
                session()->setFlashdata('error', 'Registration failed.');
                return redirect()->to('/register');
            }
        } else {
            session()->setFlashdata('error', implode(', ', $validation->getErrors()));
            return redirect()->to('/register');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}