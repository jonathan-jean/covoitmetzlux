<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser()
    {
        return view('profile');
    }

    public function postUser(Request $request)
    {
        if ($request->has("phone"))
        {
            $user = auth()->user();
            $user->phone = $request->get('phone');
            $user->save();
            $request->session()->flash('info', "Le numero de téléphone a été mis à jour.");
        }
        return redirect('/user');
    }
}
