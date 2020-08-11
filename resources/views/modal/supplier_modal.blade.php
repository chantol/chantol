 <!-- Modal -->
  <div class="modal fade" id="supplier_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Supplier</h4>
        </div>
        <form action="#" id="frm_supplier" method="POST">
          @csrf
          <div class="modal-body">
            <div class="container">
                <div class="form-group">
                  <label for="category">Name:</label>
                  <input type="text" class="form-control" id="supplier_name" placeholder="Enter" name="supplier_name">
                </div>
                <div class="form-group">
                  <div style="border:1px solid #ddd;">
                    <div style="padding:5px;">
                        <label for="category">Sex:</label> &nbsp;
                        <label class="radio-inline"><input type="radio"  name="sex" checked value="1">Male</label>
                        <label class="radio-inline"><input type="radio"  name="sex" value="0">Female</label>
                    </div>
                      
                  </div>
                 
                </div>
                <div class="form-group">
                  <label for="tel">Tel:</label>
                  <input type="text" class="form-control" placeholder="Enter Telephone" name="tel">
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" placeholder="Enter Emaile" name="email">
                </div>
                 <div class="form-group">
                  <label for="Address">Address:</label>
                  <textarea name="address" class="form-control" cols="30" rows="10"></textarea>
                </div>
                 
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success btn_add_supplier" >Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
  