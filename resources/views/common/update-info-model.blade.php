<div class="modal fade" id="updateInfoModel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-3">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form id="editInfoForm" method="post">
                  @csrf
                  <input type="hidden" id="updinfo_student_id" name="id" value="">
                  <div class="row" id="rowDivUpdateInfo">

                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <button type="submit" class="btn btn-primary mb-2">Save</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function editInfoModelFunc(id) {
    $('#editInfoForm')[0].reset();
    //$('#editInfoForm').reset();
    $('#updinfo_student_id').val(id);
    //alert(id);
    $.ajax({
      url: "{{ url('common/get-student-info') }}",
      method: "get",
      data: {
        id: id
      },
      success: function(result) {
        //alert(result);
        $('#rowDivUpdateInfo').html(result);
      }
    })
  }

  $(document).ready(function() {
    $('#editInfoForm').on('submit', function(event) {
      event.preventDefault();
      var std_id = $('#updinfo_student_id').val();
      $.ajax({
        url: "{{ url('common/update-student-info') }}",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(result) {
          //alert(result);
          $('#editInfoForm')[0].reset();
          $("#updateInfoModel").modal('hide');
          fetchLastUpdatedRecord(std_id);
          if (result == 'success') {
            var msg = 'Record updated successfully.';
            var h = 'Success';
            var type = 'success';
          } else {
            var h = 'Failed';
            var msg = 'Some error occured';
            var type = 'error';
          }
          showToastr(h, msg, type);
        }
      })
    });
  });

  function fetchLastUpdatedRecord(id) {
    //alert(id);
    if (id != '') {
      $.ajax({
        url: "{{ url('common/get-last-updated-info') }}",
        method: "get",
        data: {
          id: id
        },
        success: function(data) {
          //alert(data);
          $('#quickInfoTable' + id).html(data);
        }
      });
    }
  }
</script>