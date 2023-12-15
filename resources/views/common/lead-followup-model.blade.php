@php
use App\Models\FollowupStatus;
use App\Models\FollowupType;
@endphp
<div class="modal fade" id="changeStatusModel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-3">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form id="leadStatusForm" method="post">
                  @csrf
                  <input type="hidden" id="csId" name="id" value="">
                  <h5>Lead Status</h5>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Lead Status <span class="text-danger">*</span></label>
                        <select name="lead_status" id="lead_status" class="form-control" required>
                          <option value="">Select...</option>
                        </select>
                      </div>
                    </div>
                    <div class=" form-group col-md-6">
                      <label class="form-label sr-onl" for="lead_sub_status">Lead Sub Status</label>
                      <select name="lead_sub_status" id="lead_sub_status" class="form-control select">
                        <option value="">Select...</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label class="form-label sr-onl" for="lead_follow_status">Lead Followup Status <span
                          class="text-danger">*</span></label>
                      <select name="lead_follow_status" id="lead_follow_status" class="form-control select" required>
                        <option value="">Select</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <input class="form-check-input" type="checkbox" name="call_answered_status"
                        id="call_answered_status" value="1">
                      <label for="call_answered_status">Call Not Answered</label>
                    </div>
                  </div>
                  <hr>
                  <h5>Follow Up</h5>
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label class="form-label" for="followup_date">Next Follow up Date <span
                          class="text-danger">*</span></label>
                      <input name="followup_date" placeholder="Enter Date" class="form-control" type="date"
                        id="followup_date" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                      <label class="form-label" for="type">Reminder</label>
                      <select id="type" name="type" class="form-control select">
                        <option value="">Select</option>
                        <?php
                        $fuptype = FollowupType::all();
                        foreach ($fuptype as $row) {
                        ?>
                        <option value="<?php echo $row->slug; ?>">
                          <?php echo $row->type; ?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                      <label class="form-label" for="status">Status</label>
                      <select id="status" name="status" class="form-control select">
                        <option value="">Select</option>
                        <?php
                        $fuptype = FollowupStatus::all();
                        foreach ($fuptype as $row) {
                        ?>
                        <option value="<?php echo $row->slug; ?>">
                          <?php echo $row->status; ?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-12 col-sm-12">
                      <label class="form-label sr-only" for="description">Follow Up Note </label>
                      <textarea rows="2" class="form-control mb-2 mr-sm-2" id="description" name="description"
                        placeholder="Add notes"></textarea>
                    </div>
                  </div>
                  <hr>
                  <h5>Comments</h5>
                  <div class="row">
                    <div class="form-group col-md-12 col-sm-12">
                      <label class="form-label sr-onl" for="form_comment">comment <span
                          class="text-danger">*</span></label>
                      <textarea rows="6" class="form-control mb-2 mr-sm-2" id="form_comment" name="comment"
                        placeholder="Add Comment" required></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <button type="submit" id="changeStatusForm_btn" class="btn btn-primary mb-2">Save</button>
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
  function changeStatusModelFunc(id) {
    $('#leadStatusForm')[0].reset();
    //$('#leadStatusForm').reset();
    $('#csId').val(id);
    //alert(id);
    $.ajax({
      url: "{{ url('common/get-lead-status') }}",
      method: "get",
      data: {
        id: id
      },
      success: function(result) {
        //alert(result);
        $('#lead_status').html(result);
        $('#lead_sub_status').html('<option value="">Select</option>');
        getLeadSubStatus();
        getLastComment(id);
        getLFS(id);
      }
    })
  }

  $(document).ready(function() {
    $('#leadStatusForm').on('submit', function(event) {
      event.preventDefault();
      var std_id = $('#csId').val();
      $.ajax({
        url: "{{ url('common/add-student-followup') }}",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(result) {
          $('#leadStatusForm')[0].reset();
          $("#changeStatusModel").modal('hide');
          fetchLastStatus(std_id);
          fetchLastLFS(std_id);
          fetchLastComment(std_id);
          getLastCAS(std_id);
          if (result == 'success') {
            var h = 'Success';
            var msg = 'Status has been updated successfully.';
            var type = 'success';
          } else {
            var h = 'Failed';
            var msg = 'Failed !. Some errors occured.';
            var type = 'error';
          }
          showToastr(h,msg,type);
        }
      })
    });
    $('#lead_status').on('change', function(event) {
      getLeadSubStatus();
    });
  });

  function getLeadSubStatus() {
    var lead_status = $('#lead_status').val();
    var id = $('#csId').val();
    //alert(id);
    $.ajax({
      url: "{{ url('common/get-lead-sub-status') }}",
      method: "get",
      data: {
        id: id,
        lead_status: lead_status,
      },
      success: function(result) {
        $('#lead_sub_status').html(result);
      }
    })
  }

  function getLastCAS(id) {
    //alert(id);
    $.ajax({
      url: "{{ url('common/get-last-cas') }}",
      method: "get",
      data: {
        std_id: id
      },
      success: function(data) {
        //alert(data);
        if (data == 1) {
          $('#cas' + id).show();
        } else {
          $('#cas' + id).hide();
        }
      }
    });
  }

  function getLFS(id) {
    //alert(id);
    $.ajax({
      url: "{{ url('common/get-lfs') }}",
      method: "get",
      data: {
        id: id,
      },
      success: function(result) {
        $('#lead_follow_status').html(result);
      }
    })
  }

  function fetchLastStatus(id) {
    //alert(id);
    if (id != '') {
      $.ajax({
        url: "{{ url('common/fetch-last-status') }}",
        method: "get",
        data: {
          std_id: id
        },
        success: function(data) {
          //alert(data);
          $('#lsspan' + id).text(data);
        }
      });
    }
  }

  function fetchLastLFS(id) {
    //alert(id);
    if (id != '') {
      $.ajax({
        url: "{{ url('common/fetch-last-lfs') }}",
        method: "get",
        data: {
          std_id: id
        },
        success: function(data) {
          //alert(data);
          $('#lfsb' + id).html(data);
        }
      });
    }
  }

  function fetchLastComment(id) {
    //alert(id);
    if (id != '') {
      $.ajax({
        url: "{{ url('common/fetch-last-comment') }}",
        method: "get",
        data: {
          std_id: id
        },
        success: function(data) {
          //alert(data);
          //$('#commenttd' + id).html(data);
          $('#followupdetails' + id).html(data);
        }
      });
    }
  }

  function getLastComment(id) {
    //alert(id);
    if (id != '') {
      $.ajax({
        url: "{{ url('common/get-last-comment') }}",
        method: "get",
        data: {
          std_id: id
        },
        success: function(data) {
          //alert(data);
          $('#form_comment').val(data);
        }
      });
    }
  }
</script>