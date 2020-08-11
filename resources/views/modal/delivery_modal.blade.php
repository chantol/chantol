 <!-- Modal -->
  <div class="modal fade" id="delivery_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Delivery</h4>
        </div>
        <form action="" id="frm_delivery" method="POST">
          @csrf
          <div class="modal-body">
            <div class="container">
                <div class="form-group">
                  <label for="category">Name:</label>
                  <input type="text" class="form-control" placeholder="Enter" name="delivery_name">
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
            <button type="submit" class="btn btn-success" >Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
  