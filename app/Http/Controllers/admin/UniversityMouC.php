<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\UniversityMou;
use Illuminate\Http\Request;

class UniversityMouC extends Controller
{
  public function index($university_id, $id = null)
  {
    $university = University::find($university_id);
    $rows = UniversityMou::where('university_id', $university_id)->get();
    if ($id != null) {
      $sd = UniversityMou::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/university-mou/' . $university_id . '/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/university-mou');
      }
    } else {
      $ft = 'add';
      $url = url('admin/university-mou/' . $university_id . '/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "University MOU";
    $page_route = "university-mou";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route', 'university');
    return view('admin.university-mou')->with($data);
  }
  public function store($university_id, Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'file.*' => 'required|max:5000|mimes:jpg,jpeg,png,gif,pdf',
      ],
      [
        'file.*.required' => 'Please upload an image',
        'file.*.mimes' => 'Only jpg, jpeg, png and gif images are allowed',
        'file.*.max' => 'Sorry! Maximum allowed size for an image is 5MB',
      ]
    );
    if ($request->hasFile('file')) {
      foreach ($request->file('file') as $key => $file) {
        $field = new UniversityMou;
        $field->university_id = $request['university_id'];
        $field->title = $request['title'];
        $fileOriginalName = $file->getClientOriginalName();
        $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
        $file_name_slug = slugify($fileNameWithoutExtention);
        $file_name = $file_name_slug . '-' . time() . '.' . $file->getClientOriginalExtension();
        $move = $file->move('uploads/university/', $file_name);
        if ($move) {
          $field->file_name = $file_name;
          $field->file_path = 'uploads/university/' . $file_name;
        } else {
          session()->flash('emsg', 'Images not uploaded.');
        }
        $field->save();
      }
    }

    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/university-mou/' . $university_id);
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = UniversityMou::find($id)->delete();
  }
  public function update($university_id, $id, Request $request)
  {
    $request->validate(
      [
        'file' => 'nullable|max:5000|mimes:jpg,jpeg,png,gif,pdf',
      ]
    );
    $field = UniversityMou::find($id);
    if ($request->hasFile('file')) {
      $fileOriginalName = $request->file('file')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('file')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('file')->move('uploads/university/', $file_name);
      if ($move) {
        $field->file_name = $file_name;
        $field->file_path = 'uploads/university/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->title = $request['title'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/university-mou/' . $university_id);
  }
}
