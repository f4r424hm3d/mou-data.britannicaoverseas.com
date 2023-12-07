<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class UserForgetPasswordC extends Controller
{
  public function viewForgetPassword()
  {
    return view('auth.forget-password');
  }
  public function forgetPassword(Request $request)
  {
    // printArray($request->all());
    // die;
    $remember_token = Str::random(45);
    $otp_expire_at = date("YmdHis", strtotime("+10 minutes"));
    $field = User::whereEmail($request['email'])->first();
    if (is_null($field)) {
      session()->flash('emsg', 'Entered wrong email address. Please check.');
      return redirect('account/password/reset');
    } else {
      $login_link = url('email-login/?uid=' . $field->id . '&token=' . $remember_token);

      $reset_password_link = url('password/reset/?uid=' . $field->id . '&token=' . $remember_token);

      $emaildata = ['name' => $field->name, 'id' => $field->id, 'remember_token' => $remember_token, 'login_link' => $login_link, 'reset_password_link' => $reset_password_link];

      $dd = ['to' => $request['email'], 'to_name' => $field->name, 'subject' => 'Password Reset'];

      $chk = Mail::send(
        'mails.forget-password-link',
        $emaildata,
        function ($message) use ($dd) {
          $message->to($dd['to'], $dd['to_name']);
          $message->subject($dd['subject']);
          $message->priority(1);
        }
      );
      if ($chk == false) {
        $emsg = response()->Fail('Sorry! Please try again latter');
        session()->flash('emsg', $emsg);
        return redirect('account/password/reset');
      } else {
        $field->remember_token = $remember_token;
        $field->otp_expire_at = $otp_expire_at;
        $field->save();
        $request->session()->put('forget_password_email', $request['email']);
        return redirect('forget-password/email-sent');
      }
    }
  }

  public function emailSent()
  {
    return view('auth.email-sent');
  }

  public function emailLogin(Request $request)
  {
    //printArray($request->all());
    //die;
    $id = $request['uid'];
    $remember_token = $request['token'];
    $where = ['id' => $id, 'remember_token' => $remember_token];
    $field = User::where($where)->first();
    $current_time = date("YmdHis");
    //printArray($field->all());
    if (is_null($field)) {
      return redirect('account/invalid_link');
    } else {
      if ($current_time > $field->otp_expire_at) {
        return redirect('account/invalid_link');
      } else {
        $lc = $field->login_count == '' ? 0 : $field->login_count + 1;
        $field->login_count = $lc;
        $field->last_login = date("Y-m-d H:i:s");
        $field->remember_token = null;
        $field->otp_expire_at = null;
        $field->save();
        session()->flash('smsg', 'Succesfully logged in');
        $request->session()->put('userLoggedIn', ['user_id' => $field->id, 'user_name' => $field->name, 'username' => $field->username, 'role' => $field->role]);
        return redirect('admin/dashboard');
      }
    }
  }

  public function invalidLink()
  {
    return view('auth.invalid-link');
  }
  public function viewResetPassword(Request $request)
  {
    //printArray($request->all());
    //die;
    $id = $request['uid'];
    $remember_token = $request['token'];
    $where = ['id' => $id, 'remember_token' => $remember_token];
    $field = User::where($where)->first();
    $current_time = date("YmdHis");
    //printArray($field->all());
    if (is_null($field)) {
      return redirect('account/invalid_link');
    } else {
      return view('auth.reset-password');
    }
  }
  public function resetPassword(Request $request)
  {
    //printArray($request->all());
    //die;
    $request->validate(
      [
        'new_password' => 'required|min:8',
        'confirm_new_password' => 'required|min:8|same:new_password'
      ]
    );
    $id = $request['id'];
    $remember_token = $request['remember_token'];
    $where = ['id' => $id, 'remember_token' => $remember_token];
    $field = User::where($where)->first();
    $current_time = date("YmdHis");
    //printArray($field->all());
    if (is_null($field)) {
      return redirect('account/invalid_link');
    } else {
      if ($current_time > $field->otp_expire_at) {
        return redirect('account/invalid_link');
      } else {
        $lc = $field->login_count == '' ? 0 : $field->login_count + 1;
        $field->login_count = $lc;
        $field->last_login = date("Y-m-d H:i:s");
        $field->remember_token = null;
        $field->otp_expire_at = null;
        $field->password = $request['new_password'];
        $field->save();
        session()->flash('smsg', 'Succesfully logged in');
        $request->session()->put('userLoggedIn', ['user_id' => $field->id, 'user_name' => $field->name, 'username' => $field->username, 'role' => $field->role]);
        return redirect('admin/dashboard');
      }
    }
  }
}
