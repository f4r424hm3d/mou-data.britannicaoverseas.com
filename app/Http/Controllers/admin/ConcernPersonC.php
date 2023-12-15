<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ConcernPerson;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConcernPersonC extends Controller
{
  public function index($university_id, $id = null)
  {
    $page_no = $_GET['page'] ?? 1;
    $university = University::find($university_id);
    $rows = ConcernPerson::where('university_id', $university_id)->get();
    if ($id != null) {
      $sd = ConcernPerson::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/concern-person/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/concern-person');
      }
    } else {
      $ft = 'add';
      $url = url('admin/concern-person/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "University Concern Person";
    $page_route = "concern-person";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route', 'university',  'page_no');
    return view('admin.concern-person')->with($data);
  }
  public function getData(Request $request)
  {
    // return $request;
    // die;
    $rows = ConcernPerson::where('id', '!=', '0');
    if ($request->has('university_id') && $request->university_id != '') {
      $rows = $rows->where('university_id', $request->university_id);
    }
    $rows = $rows->paginate(10)->withPath('/admin/concern-person/');
    $i = 1;
    $output = '<table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
    <thead>
      <tr>
        <th>Sr. No.</th>
        <th>Name</th>
        <th>Designation</th>
        <th>Department</th>
        <th>Contact No</th>
        <th>Email</th>
        <th>University</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>';
    foreach ($rows as $row) {
      $output .= '<tr id="row' . $row->id . '">
      <td>' . $i . '</td>
      <td>' . $row->name . '</td>
      <td>' . $row->designation . '</td>
      <td>' . $row->department . '</td>
      <td>
        Contact Number : ' . $row->mobile . ' <br>
        Whatsapp : ' . $row->whatsapp . '
      </td>
      <td>
        Official : ' . $row->official_email . ' <br>
        Personal : ' . $row->personal_email . '
      </td>
      <td>' . $row->getUniversity->name . '</td>
      <td>
        <a href="javascript:void()" onclick="DeleteAjax(' . $row->id . ')"
          class="waves-effect waves-light btn btn-xs btn-outline btn-danger">
          <i class="fa fa-trash" aria-hidden="true"></i>
        </a>
        <a href="' . url("admin/concern-person/" . $request->university_id . "/update/" . $row->id) . '"
                      class="waves-effect waves-light btn btn-xs btn-outline btn-info">
                      <i class="fa fa-edit" aria-hidden="true"></i>
                    </a>
      </td>
    </tr>';
      $i++;
    }
    $output .= '</tbody></table>';
    $output .= '<div>' . $rows->links('pagination::bootstrap-5') . '</div>';
    return $output;
  }
  public function storeAjax(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'university_id' => 'required',
      'name' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => $validator->errors(),
      ]);
    }

    $field = new ConcernPerson();
    $field->name = $request['name'];
    $field->mobile = $request['mobile'];
    $field->whatsapp = $request['whatsapp'];
    $field->personal_email = $request['personal_email'];
    $field->official_email = $request['official_email'];
    $field->designation = $request['designation'];
    $field->department = $request['department'];
    $field->university_id  = $request['university_id'];
    $field->created_by = session('userLoggedIn.user_id');
    $field->save();
    return response()->json(['success' => 'Record hase been added succesfully.']);
  }
  public function delete($id)
  {
    echo $result = ConcernPerson::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'university_id' => 'required',
        'name' => 'required',
      ]
    );
    $field = ConcernPerson::find($id);
    $field->name = $request['name'];
    $field->mobile = $request['mobile'];
    $field->whatsapp = $request['whatsapp'];
    $field->personal_email = $request['personal_email'];
    $field->official_email = $request['official_email'];
    $field->designation = $request['designation'];
    $field->department = $request['department'];
    $field->university_id  = $request['university_id'];
    $field->created_by = session('userLoggedIn.user_id');
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/concern-person/' . $request->university_id);
  }
}
