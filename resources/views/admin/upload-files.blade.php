@extends('admin.layouts.main')
@push('title')
<title>{{ $page_title }}</title>
@endpush
@section('main-section')
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0 font-size-18">{{ $page_title }}</h4>

          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item"><a href="{{ url('/admin/') }}"><i class="mdi mdi-home-outline"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
            </ol>
          </div>

        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-12">
        @if (session()->has('smsg'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session()->get('smsg') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (session()->has('emsg'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session()->get('emsg') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">{{ $title }} Record</h4>
          </div>
          <div class="card-body">
            <form action="{{ $url }}" class="needs-validation" method="post" enctype="multipart/form-data" novalidate>
              @csrf
              <div class="row">
                {{-- <div class="col-md-2 col-sm-12 mb-3">
                  <div class="form-group">
                    <label>Band Score</label>
                    <input name="band_score" type="number" class="form-control" placeholder="Band Score"
                      value="{{ $ft == 'edit' ? $sd->band_score : old('band_score') }}" step="any" min="1" max="9">
                    <span class="text-danger">
                      @error('band_score')
                      {{ $message }}
                      @enderror
                    </span>
                  </div>
                </div> --}}
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label" for="file">Upload Image</label>
                    <input type="file" class="form-control" id="file" name="file" {{ $ft=='edit' ? '' : 'requir' }}>
                    <span class="text-danger">
                      @error('file')
                      {{ $message }}
                      @enderror
                    </span>
                    <span id="audExtError" class="text-danger"></span>
                  </div>
                </div>
              </div>
              <button class="btn btn-primary" type="submit">Submit</button>
            </form>
          </div>
        </div>
        <!-- end card -->
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table id="datatable" class="table table-bordered dt-responsiv nowra w-100">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Date</th>
                  <th>File</th>
                  <th>Url</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                $i = 1;
                @endphp
                @foreach ($rows as $row)
                <tr id="row{{ $row->id }}">
                  <td>{{ $i }}</td>
                  <td>{{ getFormattedDate($row->created_at,'d M Y - h:i A') }}</td>
                  <td>
                    <a href="{{ asset($row->file_path) }}" target="_blank"
                      class="waves-effect waves-light btn btn-xs btn-info">view</a> | <a
                      href="{{ asset($row->file_path) }}" download
                      class="waves-effect waves-light btn btn-xs btn-danger">download</a>
                  </td>
                  <td>
                    <img src="{{ asset($row->file_path) }}" height="80" width="80">
                    <input type="text" id="url{{ $row->id }}" value="{{ asset($row->file_path) }}">&nbsp;&nbsp;
                    <a onclick="copyFunc('{{ $row->id }}')" href="javascript:void()" data-toggle="tooltip"
                      class="waves-effect waves-light btn btn-xs btn-warning" title="Copy to clipboard">Copy</a>
                  </td>
                  <td>
                    <a href="javascript:void()" onclick="DeleteAjax('{{ $row->id }}','{{ $row->file_name }}')"
                      class="waves-effect waves-light btn btn-xs btn-danger">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                  </td>
                </tr>
                @php
                $i++;
                @endphp
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function copyFunc(id) {
    var copyText = document.getElementById("url" + id);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");

    var tooltip = document.getElementById("myTooltip");
    tooltip.innerHTML = "Copied: " + copyText.value;
  }

  function DeleteAjax(id) {
      //alert(id);
      var cd = confirm("Are you sure ?");
      if (cd == true) {
        $.ajax({
          url: "{{ url('admin/upload-files/delete') }}" + "/" + id,
          success: function(data) {
            if (data == '1') {
              var msg = 'Record deleted successfully';
              $('#row' + id).remove();
              $('#toastMsg').text(msg);
              $('#liveToast').show();
            }
          }
        });
      }
    }
</script>
@endsection
