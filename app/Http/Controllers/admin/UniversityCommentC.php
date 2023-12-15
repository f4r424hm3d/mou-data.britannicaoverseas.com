<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\UniversityFollowup;
use Illuminate\Http\Request;

class UniversityCommentC extends Controller
{
  public function store(Request $request)
  {
    $field = new UniversityFollowup();
    $field->university_id = $request->university_id;
    $field->comment = $request->comment;
    $field->user_id = session('userLoggedIn.user_id');
    $field->created_at = date('Y-m-d H:i:s');
    $ad = $field->save();
    echo $msg = $ad ? 'success' : 'failed';
  }
  public function getRecentNote(Request $request)
  {
    if ($request->id) {
      $university_id = $request->id;
      $row = UniversityFollowup::where(['university_id' => $university_id])->latest()->first();
      $output = '<span><p>' . $row->comment . '</p></span>';
      echo $output;
    }
  }
  public function getAllNotes(Request $request)
  {
    if ($request->id) {
      $university_id = $request->id;
      $rows = UniversityFollowup::orderBy('created_at', 'desc')->where(['university_id' => $university_id])->get();
      $output = '';
      foreach ($rows as $row) {
        $output .= '<ul class="f-timeline">';
        $fld = getFormattedDate($row->created_at, 'd M Y | h:i A');
        $output .= '<li class="f-timeline-item"><strong>' . $fld . '</strong><p>' . $row->comment . '</p></li>';
        $output .= '</ul>';
      }
      echo $output;
    }
  }
}
