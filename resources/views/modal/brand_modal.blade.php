 <!-- Modal -->
  <div class="modal fade" id="brand_modal" role="dialog" style="z-index:1300; ">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="background-color:#fff;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Brand</h4>
        </div>
        <div class="modal-body">
          <div class="container">
              <div class="form-group">
                <label for="catid">Category:</label>
                <input type="hidden" id="catid" name="category_id">
                <input type="text" class="form-control" id="cat_name" name="cat_name" readonly>
              </div>
              <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" class="form-control" id="brand_name" placeholder="Enter" name="brand_name" required>
              </div>
          </div>
        </div>
        <div class="modal-footer">
           <button type="button" class="btn btn-success btn_save_brand" >Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  