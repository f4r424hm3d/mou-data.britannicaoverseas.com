<div class="modal fade" id="commentListModel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Follow Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-3">
        <div id="allcommentsmodelid">
          <center>
            <div class="spinner-border spinner-border-s text-success mr-2" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </center>

        </div>
      </div>

    </div>
  </div>
</div>
<script>
  function viewAllCommentsList(id) {
    //alert(id);
    if (id != '') {
      $.ajax({
        url: "{{ url('common/get-followup-list') }}",
        method: "get",
        data: {
          std_id: id
        },
        success: function(data) {
          //alert(data);
          $('#allcommentsmodelid').html(data);
        }
      });
    }
  }
</script>