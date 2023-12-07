<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminLogin extends Controller
{
  public function index()
  {
    return view('auth.login');
  }
  public function login(Request $request)
  {
    //printArray($request->all());
    //die;
    $field = User::where('email', $request['username'])->orWhere('username', $request['username'])->first();
    // printArray($field->toArray());
    // die;
    if (is_null($field)) {
      session()->flash('emsg', 'Email address not exist.');
      return redirect('admin/login');
    } else {
      if ($field->password == $request['password']) {
        $lc = $field->login_count == '' ? 0 : $field->login_count + 1;
        $field->login_count = $lc;
        $field->last_login = date("Y-m-d H:i:s");
        $field->save();
        session()->flash('smsg', 'Succesfully logged in');
        $request->session()->put('userLoggedIn', ['user_id' => $field->id, 'user_name' => $field->name, 'username' => $field->username, 'role' => $field->role]);
        //return "logged in";
        //printArray($request->session()->all());
        //echo $request->session()->get('userLoggedIn')['user_id'];

        return redirect('admin/dashboard');
      } else {
        session()->flash('emsg', 'Incorrect password entered');
        return redirect('admin/login');
      }
    }
  }
}
