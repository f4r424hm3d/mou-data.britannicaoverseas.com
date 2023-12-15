<style>
  .f-timeline {
    list-style-type: none;
    position: relative
  }

  .f-timeline:before {
    background: #dee2e6;
    left: 9px;
    width: 2px;
    height: 100%
  }

  .f-timeline-item:before,
  .f-timeline:before {
    content: " ";
    display: inline-block;
    position: absolute;
    z-index: 400
  }

  .f-timeline-item:before {
    background: #fff;
    border-radius: 50%;
    border: 3px solid #2979ff;
    left: 0;
    width: 20px;
    height: 20px
  }
</style>
<div class="modal fade" id="viewNotesToAppModel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div id="allnotesmodelid">
              <center>
                <div class="spinner-border spinner-border-s text-success mr-2" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </center>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
