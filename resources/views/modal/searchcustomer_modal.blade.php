 <!-- Modal -->
  <div class="modal fade" id="searchcus_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Search Customer</h4>
        </div>
       
        
          <div class="modal-body">
            <div class="container">
                <div class="form-group">
                  <label for="search">Search:</label>
                  <input type="text" class="form-control" id="customersearch" name="customersearch" placeholder="Search" autofocus>
                </div>
                <table class="table table-bordered table-hover" id="tbl-cus">
                    <thead>
                      <tr>
                        <td>No</td>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Sex</td>
                        <td>Tel</td>
                        <td>Code</td>
                        <td>Price</td>
                      </tr>
                    </thead>
                    <tbody id="tbl_customersearch">
                      
                    </tbody>
                </table>
              
                 
            </div>
          </div>
          <div class="modal-footer">
            
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        
      </div>
      
    </div>
  </div>
  