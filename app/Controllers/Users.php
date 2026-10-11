<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        $users = $userModel->findAll();

        return view('users', [
            'users' => $users
        ]);
    }

    public function newUser()
    {
        return view('users_new');
    }

    public function create()
    {
        $rules = [
            'username'  => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|min_length[2]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return view('users_new', [
                'validation' => $this->validator
            ]);
        }

        $userModel = new UserModel();

        $userModel->insert([
            'username'   => $this->request->getPost('username'),
            'full_name'  => $this->request->getPost('full_name'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/users');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('users_edit', [
            'user' => $user
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'username'  => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,' . $id . ']',
            'full_name' => 'required|min_length[2]|max_length[100]',
            'avatar'    => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,2048]',
        ];

        if (!$this->validate($rules)) {
            return view('users_edit', [
                'user'       => $user,
                'validation' => $this->validator
            ]);
        }

        $data = [
            'username'  => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
        ];

        $avatar = $this->request->getFile('avatar');

        if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/';
            $newName = $avatar->getRandomName();

            $avatar->move($uploadPath, $newName);

            $image = service('image');
            $image
                ->withFile($uploadPath . $newName)
                ->fit(200, 200, 'center')
                ->save($uploadPath . $newName);

            $data['avatar'] = $newName;
        }

        $userModel->update($id, $data);

        return redirect()->to('/users');
    }
}