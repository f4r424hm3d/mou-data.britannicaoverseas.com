<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UniversityC extends Controller
{
  public function index($id = null)
  {
    $page_no = $_GET['page'] ?? 1;
    $rows = University::get();
    if ($id != null) {
      $sd = University::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/universities/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/universities');
      }
    } else {
      $ft = 'add';
      $url = url('admin/universities/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "University";
    $page_route = "universities";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route', 'page_no');
    return view('admin.universities')->with($data);
  }
  public function getData(Request $request)
  {
    $rows = University::where('id', '!=', '0');
    $rows = $rows->paginate(10)->withPath('/admin/universities/');
    $i = 1;
    $output = '<table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
    <thead>
      <tr>
        <th>S.No.</th>
        <th>Name</th>
        <th>Address</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>';
    foreach ($rows as $row) {
      $output .= '<tr id="row' . $row->id . '">
      <td>' . $i . '</td>
      <td>
      ' . $row->name . ' <br>
      (' . $row->institute_type . ')
      </td>
      <td>
       Address : ' . $row->address . ' <br>
       City : ' . $row->city . ' <br>
       State : ' . $row->state . ' <br>
       Country : ' . $row->country . ' <br>
      </td>
      <td>
       ' . $row->email . ' <br>
       ' . $row->email2 . ' <br>
       ' . $row->email3 . '
      </td>
      <td>
      ' . $row->phone_number . ' <br>
      ' . $row->phone_number2 . ' <br>
      ' . $row->phone_number3 . '
     </td>';
      $output .= '<td>
        <a href="' . url("admin/concern-person/" . $row->id) . '"
          class="waves-effect waves-light btn btn-xs btn-outline btn-primary">
          <i class="fa fa-plus" aria-hidden="true"></i>
        </a>
        <a href="javascript:void()" onclick="DeleteAjax(' . $row->id . ')"
          class="waves-effect waves-light btn btn-xs btn-outline btn-danger">
          <i class="fa fa-trash" aria-hidden="true"></i>
        </a>
        <a href="' . url("admin/universities/update/" . $row->id) . '"
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
      'name' => 'required|unique:universities,name',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => $validator->errors(),
      ]);
    }

    $field = new University;
    $field->name = $request['name'];
    $field->slug = slugify($request['name']);
    $field->institute_type = $request['institute_type'];
    $field->address = $request['address'];
    $field->city = $request['city'];
    $field->state = $request['state'];
    $field->country = $request['country'];
    $field->email = $request['email'];
    $field->email2 = $request['email2'];
    $field->email3 = $request['email3'];
    $field->phone_number = $request['phone_number'];
    $field->phone_number2 = $request['phone_number2'];
    $field->phone_number3 = $request['phone_number3'];
    $field->created_by = session('userLoggedIn.user_id');
    $field->save();
    return response()->json(['success' => 'Record hase been added succesfully.']);
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = University::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'name' => 'required|unique:universities,name,' . $id,
      ]
    );
    $field = University::find($id);
    $field->name = $request['name'];
    $field->slug = slugify($request['name']);
    $field->institute_type = $request['institute_type'];
    $field->address = $request['address'];
    $field->city = $request['city'];
    $field->state = $request['state'];
    $field->country = $request['country'];
    $field->email = $request['email'];
    $field->email2 = $request['email2'];
    $field->email3 = $request['email3'];
    $field->phone_number = $request['phone_number'];
    $field->phone_number2 = $request['phone_number2'];
    $field->phone_number3 = $request['phone_number3'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/universities');
  }
}
