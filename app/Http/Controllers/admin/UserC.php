<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;

class UserC extends Controller
{
  public function generateUsername()
  {
    $number = mt_rand(1000, 9999); // better than rand()

    // call the same function if the barcode exists already
    if ($this->usernameExists($number)) {
      return $this->generateUsername();
    }

    // otherwise, it's valid and can be used
    return $number;
  }

  public function usernameExists($number)
  {
    // query the database and return a boolean
    // for instance, it might look like this in Laravel
    return User::whereUsername($number)->exists();
  }

  public function index($id = null)
  {
    $rows = User::where('role', '!=', 'admin')->get();
    if ($id != null) {
      $sd = User::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/users/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/users');
      }
    } else {
      $ft = 'add';
      $url = url('admin/users/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Users";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title');
    return view('admin.users')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'name' => 'required',
        'email' => 'required|unique:users,email',
        'mobile' => 'required|unique:users,mobile',
      ]
    );
    $username = $this->generateUsername();
    $password = Str::random(10);
    $field = new User;
    $field->role = 'user';
    $field->name = $request['name'];
    $field->email = $request['email'];
    $field->mobile = $request['mobile'];
    $field->username = $username;
    $field->password = $password;
    $field->status = 1;
    $res = $field->save();
    // if ($res) {
    //   $dd = [
    //     'to' => $request['email'],
    //     'to_name' => $request['name'],
    //     'subject' => 'Account Create',
    //   ];
    //   $emaildata = [
    //     'name' => $request['name'],
    //     'email' => $request['email'],
    //     'mobile' => $request['mobile'],
    //     'role' => $request['role'],
    //     'username' => $username,
    //     'password' => $password,
    //   ];

    //   Mail::send(
    //     'mails.user-account-create',
    //     $emaildata,
    //     function ($message) use ($dd) {
    //       $message->to($dd['to'], $dd['to_name']);
    //       $message->subject($dd['subject']);
    //       $message->priority(1);
    //     }
    //   );
    // }
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/users');
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = User::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'name' => 'required',
        'email' => 'required|unique:users,email,' . $id,
        'mobile' => 'required|unique:users,mobile,' . $id,
        'username' => 'required|unique:users,username,' . $id,
        'password' => 'required',
      ]
    );

    $field = User::find($id);
    $field->name = $request['name'];
    $field->email = $request['email'];
    $field->mobile = $request['mobile'];
    $field->username = $request['username'];
    $field->password = $request['password'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/users');
  }
}
