<div class="modal fade" id="addNotesToAppModel" tabindex="-1" aria-labelledby="addNoteModelTitle" role="dialog"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNoteModelTitle">
          Description
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addNotesForm" method="post">
          @csrf
          <input type="hidden" id="university_id" name="university_id">
          <div class="row">
            <div class="form-group col-md-12 col-sm-12 hide-this">
              <div class="input-group mb-1">
                <input id="title" name="title" type="text" class="form-control" placeholder="Enter Title">
              </div>
            </div>
            <div class="form-group col-md-12 col-sm-12">
              <label class="form-label sr-only" for="comment">Comment</label>
              <textarea rows="8" class="form-control mb-2 mr-sm-2" id="comment" name="comment" placeholder="Enter comment"
                required></textarea>
            </div>
            <div class="form-group col-md-4">
              <button type="submit" id="changeStatusForm_btn" class="btn btn-primary mb-2">Save</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  function addNotesToApp(university_id) {
    //$('#app_id').val(id);
    $('#university_id').val(university_id);
  }

  $(document).ready(function() {
    $('#addNotesForm').on('submit', function(event) {
      event.preventDefault();
      $("#addNotesToAppModel").modal('hide');
      var university_id = $('#university_id').val();
      $.ajax({
        url: "{{ url('common/add-lead-note') }}",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(result) {
          //alert(result);
          $('#addNotesForm')[0].reset();
          fetchLastAppNote(university_id);
          if (result == 'success') {
            var h = 'Success';
            var msg = 'Record has been added.';
            var type = 'success';
          } else {
            var h = 'Failed';
            var msg = 'Failed !. SSomething went wrong.';
            var type = 'error';
          }
          showToastr(h, msg, type);
        }
      })
    });
  });

  function fetchLastAppNote(id) {
    //alert(id);
    if (id != '') {
      $.ajax({
        url: "{{ url('common/get-recent-lead-note') }}",
        method: "get",
        data: {
          id: id
        },
        success: function(data) {
          //alert(data);
          $('#notesSpace' + id).html(data);
          $('#viewNotesBtn' + id).show();
        }
      });
    }
  }

  function viewAppNotes(id) {
    //alert(id);
    if (id != '') {
      $.ajax({
        url: "{{ url('common/get-lead-notes') }}",
        method: "get",
        data: {
          id: id
        },
        success: function(data) {
          //alert(data);
          $('#allnotesmodelid').html(data);
        }
      });
    }
  }
</script>
