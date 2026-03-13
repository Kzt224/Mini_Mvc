<?php

namespace App\Controllers;

use App\Http\Request;
use App\Models\User;


class HomeController extends Controller
{
    public function index()
    {
        $users = User::all();
        $this->view('index', ['users' => $users]);
    }

    public function showCreate()
    {
        $this->view('createUser', []);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'userName' => 'required|string|min:3|max:50',
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:8|max:50',
        ]);
        if (empty($validated)) {
            $this->Redirect('createUser');
            exit();
        }
        $admin = $request->get('isAdmin');
        if ($admin['isAdmin'] === 'on') {
            $validated['isAdmin'] = 1;
        } else {
            $validated['isAdmin'] = 0;
        }
        User::create($validated);
        $this->Redirect("/public");
    }

    public function delete(Request $request, array $param)
    {
        User::softDelete($param['id']);
        $this->Redirect("/public");
    }

    public function showEdit(Request $request, array $param)
    {
        $user = User::get($param['id']);
        $this->view('editUser', ['user' => $user]);
    }

    public function update(Request $request, array $param)
    {
        $id = $param['id'];
        $validated = $request->validate([
            'userName' => 'required|string|min:3|max:50',
            'email' => 'required|email|max:100',
        ]);
        if (empty($validated)) {
            $this->Redirect('editUser');
            exit();
        }
        $admin = $request->get('isAdmin');
        $value = 0;
        if ($admin['isAdmin'] === 'on') {
            $value = 1;
        } else {
            $value = 0;
        }
        if ($request->get('password') === '') {
            $updateUser = User::update($id, [
                'userName' => $request->input('userName'),
                'email' => $request->input('email'),
                'isAdmin' => $value
            ]);
            $this->view('editUser',['user'=>$updateUser]);
        } else {
            $updateUser = User::update($id, [
                'userName' => $request->input('userName'),
                'email' => $request->input('email'),
                'isAdmin' => $value,
                'password'=> $request->input('password')
            ]);
            $this->view('editUser',['user'=>$updateUser]);
        }
    }
    public function about(array $param)
    {
        $id = $param['id'] ?? null;
        $user = User::get($id);

        $this->view('about', ['user' => $user]);
    }
}
