<?php

namespace App\Http\Controllers\admin;

use App\Exports\UniversityListExport;
use App\Http\Controllers\Controller;
use App\Imports\UniversityImport;
use App\Imports\UniversityListBulkUpdateImport;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UniversityC extends Controller
{
  public function index(Request $request, $id = null)
  {
    $limit_per_page = $request->limit_per_page ?? 10;
    $order_by = $request->order_by ?? 'name';
    $order_in = $request->order_in ?? 'ASC';
    $rows = University::withCount('concernPeople')->orderBy($order_by, $order_in);
    if ($request->has('search') && $request->search != '') {
      $rows = $rows->where('name', 'like', '%' . $request->search . '%')->orWhere('country', 'like', '%' . $request->search . '%')->orWhere('city', 'like', '%' . $request->search . '%')->orWhere('state', 'like', '%' . $request->search . '%');
    }
    $rows = $rows->paginate($limit_per_page)->withQueryString();

    $cp = $rows->currentPage();
    $pp = $rows->perPage();
    $i = ($cp - 1) * $pp + 1;

    $lpp = ['10', '20', '50'];
    $orderColumns = ['Name' => 'name', 'Date' => 'created_at', 'City' => 'city', 'State' => 'state', 'Country' => 'country'];

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
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route', 'i', 'limit_per_page', 'order_by', 'order_in', 'lpp', 'orderColumns');
    return view('admin.universities')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'name' => 'required|unique:universities,name',
      ]
    );
    $field = new University;
    if ($request->hasFile('logo')) {
      $fileOriginalName = $request->file('logo')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('logo')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('logo')->move('university/', $file_name);
      if ($move) {
        $field->logo_name = $file_name;
        $field->logo_path = 'university/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    if ($request->hasFile('banner')) {
      $fileOriginalName = $request->file('banner')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('banner')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('banner')->move('university/', $file_name);
      if ($move) {
        $field->banner_name = $file_name;
        $field->banner_path = 'university/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
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
    $field->whatsapp = $request['whatsapp'];
    $field->created_by = session('userLoggedIn.user_id');
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/university/add');
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'name' => 'required|unique:universities,name,' . $id,
      ]
    );
    $field = University::find($id);
    if ($request->hasFile('logo')) {
      $fileOriginalName = $request->file('logo')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('logo')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('logo')->move('university/', $file_name);
      if ($move) {
        $field->logo_name = $file_name;
        $field->logo_path = 'university/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    if ($request->hasFile('banner')) {
      $fileOriginalName = $request->file('banner')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('banner')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('banner')->move('university/', $file_name);
      if ($move) {
        $field->banner_name = $file_name;
        $field->banner_path = 'university/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
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
    $field->whatsapp = $request['whatsapp'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/universities');
  }
  public function delete($id)
  {
    echo $result = University::find($id)->delete();
  }
  public function import(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:xlsx,csv,xls'
    ]);
    $filePath = $request->file;

    $import = new UniversityImport();
    $importedData = Excel::toCollection($import, $filePath)->first();

    $totalRows = $importedData->count();
    $totalInsertedRows = 0;

    foreach ($importedData as $row) {
      $university = University::where('name', $row['name'])->first();
      $status = isset($row['status']) ? $row['status'] : '0';
      if (!$university) {
        University::create([
          'name' => $row['name'],
          'slug' => slugify($row['name']),
          'institute_type' => $row['institute_type'],
          'address' => $row['address'],
          'city' => $row['city'],
          'state' => $row['state'],
          'country' => $row['country'],
          'phone_number' => $row['phone_number'],
          'phone_number2' => $row['phone_number2'],
          'phone_number3' => $row['phone_number3'],
          'email' => $row['email'],
          'email2' => $row['email2'],
          'email3' => $row['email3'],
          'whatsapp' => $row['whatsapp'],
          'created_by' => session('userLoggedIn.user_id')
        ]);
        $totalInsertedRows++;
      }
    }

    //return "Total rows: $totalRows, Total inserted rows: $totalInsertedRows";
    if ($totalRows > 0) {
      if ($totalInsertedRows > 0) {
        session()->flash('smsg', $totalInsertedRows . ' out of ' . $totalRows . ' rows imported successfully.');
      } else {
        session()->flash('emsg', 'No new data imported. All rows already exist or duplicate rows found.');
      }
    } else {
      session()->flash('emsg', 'No data found for import.');
    }
    return redirect('admin/universities');
  }
  public function add(Request $request, $id = null)
  {
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
    $page_title = "Add University";
    $page_route = "universities";
    $data = compact('sd', 'ft', 'url', 'title', 'page_title', 'page_route');
    return view('admin.add-university')->with($data);
  }
  public function export()
  {
    //echo "faraz";
    return Excel::download(new UniversityListExport, 'university-list-' . date('Ymd-his') . '.xlsx');
  }
  public function bulkUpdateImport(Request $request)
  {
    // printArray($data->all());
    // die;
    $request->validate([
      'file' => 'required|mimes:xlsx,csv,xls'
    ]);
    $file = $request->file;
    if ($file) {
      try {
        $result = Excel::import(new UniversityListBulkUpdateImport, $file);
        // session()->flash('smsg', 'Data has been imported succesfully.');
        return redirect('admin/universities');
      } catch (\Exception $ex) {
        dd($ex);
      }
    }
  }
}
