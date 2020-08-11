 <!-- Modal -->
  <div class="modal fade" id="co_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add CO Law </h4>
        </div>
        <form action="#" id="frm_co" method="POST">
          @csrf
          <div class="modal-body">
            <div class="container">
                <div class="form-group">
                  <label for="co">CO Name:</label>
                  <input type="text" class="form-control" id="co_name" name="co_name">
                </div>
                
                <div class="form-group">
                  <label for="tel">Tel:</label>
                  <input type="text" class="form-control" name="co_tel">
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="Email" class="form-control" name="co_email">
                </div>
                 <div class="form-group">
                  <label for="other">Address:</label>
                  <textarea name="other" class="form-control" cols="30" rows="3"></textarea>
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
  