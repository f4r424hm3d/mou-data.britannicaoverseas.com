<div class="modal fade" id="bulkFollowUp" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Bulk Follow Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-3">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form id="bulkFollowUpForm" method="post">
                  @csrf
                  <h5>Lead Status</h5>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Lead Status <span class="text-danger">*</span></label>
                      <select name="lead_status" id="b_lead_status" class="form-control select" required>
                        <option value="">Select...</option>
                        @foreach ($leadStatuses as $ls)
                        <option value="<?php echo $ls->id; ?>">
                          <?php echo $ls->title; ?>
                        </option>
                        @endforeach
                      </select>
                    </div>
                    <div class=" form-group col-md-6">
                      <label>Lead Sub Status</label>
                      <select name="lead_sub_status" id="b_lead_sub_status" class="form-control select">
                        <option value="">Select...</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Lead Followup Status <span class="text-danger">*</span></label>
                      <select name="lead_follow_status" id="b_lead_follow_status" class="form-control select" required>
                        <option value="">Select</option>
                        @foreach ($lfs as $row)
                        <option value="<?php echo $row->id; ?>">
                          <?php echo $row->status; ?>
                        </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <input class="form-check-input" type="checkbox" name="call_answered_status"
                        id="b_call_answered_status" value="1">
                      <label for="b_call_answered_status">Call Not Answered</label>
                    </div>
                  </div>
                  <hr>
                  <h5>Follow Up</h5>
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label class="form-label" for="followup_date">Next Follow up Date </label>
                      <input name="followup_date" placeholder="Enter Date" class="form-control" type="date"
                        id="b_followup_date" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                      <label class="form-label" for="type">Type</label>
                      <select id="b_type" name="type" class="form-control select">
                        <option value="">Select</option>
                        @foreach ($fuptype as $row)
                        <option value="<?php echo $row->slug; ?>">
                          <?php echo $row->type; ?>
                        </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                      <label class="form-label" for="status">Status</label>
                      <select id="b_status" name="status" class="form-control select">
                        <option value="">Select</option>
                        @foreach ($fupsts as $row)
                        <option value="<?php echo $row->slug; ?>">
                          <?php echo $row->status; ?>
                        </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-12 col-sm-12">
                      <label class="form-label sr-only" for="description">Follow Up Note </label>
                      <textarea rows="2" class="form-control mb-2 mr-sm-2" id="b_description" name="description"
                        placeholder="Add notes"></textarea>
                    </div>
                  </div>
                  <hr>
                  <h5>Comments</h5>
                  <div class="row">
                    <div class="form-group col-md-12 col-sm-12">
                      <label class="form-label sr-onl" for="comment">Comment</label>
                      <textarea rows="6" class="form-control mb-2 mr-sm-2" id="b_comment" name="comment"
                        placeholder="Add Comment"></textarea>
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
  $(document).ready(function() {
    $('#bulkFollowUpForm').on('submit', function(event) {
      event.preventDefault();
      //var fd = new FormData(this)
      var lead_status = $("#b_lead_status").val();
      var lead_sub_status = $("#b_lead_sub_status").val();
      var lead_follow_status = $("#b_lead_follow_status").val();
      var call_answered_status = $("#b_call_answered_status").val();
      var followup_date = $("#b_followup_date").val();
      var type = $("#b_type").val();
      var status = $("#b_status").val();
      var description = $("#b_description").val();
      var comment = $("#b_comment").val();
      alert(lead_status);
      var users_arr = [];
      $(".checkbox:checked").each(function() {
        var userid = $(this).val();
        users_arr.push(userid);
      });
      //fd.append('ids', users_arr);
      $.ajax({
        url: "{{ url('common/add-bulk-lead-followup') }}",
        method: "POST",
        data: {
          lead_status:lead_status,
          lead_sub_status:lead_sub_status,
          lead_follow_status:lead_follow_status,
          call_answered_status:call_answered_status,
          followup_date:followup_date,
          type:type,
          status:status,
          description:description,
          comment:comment,
          ids:users_arr,
          _token: '{{csrf_token()}}'
        },
        // contentType: false,
        // cache: false,
        // processData: false,
        success: function(result) {
          alert(result);
          //location.reload(true);
        }
      })
    });
    $('#b_lead_status').on('change', function(event) {
      var lead_status = $('#b_lead_status').val();
      alert(lead_status);
      $.ajax({
        url: "{{ url('common/get-sub-status-by-status') }}",
        method: "get",
        data: {
          status_id: lead_status
        },
        success: function(result) {
          $('#b_lead_sub_status').html(result);
        }
      })
    });
  });
</script>