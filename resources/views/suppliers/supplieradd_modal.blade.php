 <!-- Modal -->
  <div class="modal fade" id="supplier_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modal_title"></h4>
        </div>
        <form action="#" id="frm_supplier" method="POST" autocomplete="off">
          @csrf
          <div class="modal-body">
            <div class="container">
                <div class="form-group">
                  <input type="hidden" name="coltype" id="coltype" value="{{ $text['coltype'] }}">
                  <input type="hidden" name="supid" id="supid">
                  <label for="category">Name:</label>
                  <input type="text" class="form-control" id="supplier_name" name="supplier_name">
                </div>
                <div class="form-group">
                    <div class="col-lg-6">
                      <div class="row">
                        <table class="table table-bordered">
                          <tr style="background-color:cyan;">
                              <td style="width:60px;"><label for="category">Sex:</label></td>
                              <td><label class="radio-inline"><input type="radio"  name="sex" checked value="Male">Male</label></td>
                              <td><label class="radio-inline"><input type="radio"  name="sex" value="Female">Female</label></td>
                          </tr>
                          
                        </table>
                      </div>
                      
                    </div>
                    <div class="col-lg-6">
                      <div class="row">
                         <table class="table table-bordered">
                          <tr style="background-color:yellow;">
                              <td style="width:60px;"><label for="active">Status:</label></td>
                              <td><label class="radio-inline"><input type="radio"  name="active" checked value="1">Active</label></td>
                              <td><label class="radio-inline"><input type="radio"  name="active" value="0">Disactive</label></td>
                          </tr>
                          
                        </table>
                      </div>
                    </div>
                </div>
                      
                <div class="form-group">
                  <label for="tel">Tel:</label>
                  <input type="text" class="form-control" name="tel" id="tel">
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" name="email" id="email" autocomplete="off">
                </div>
                 <div class="form-group">
                  <label for="Address">Address:</label>
                  <textarea name="address" id="address" class="form-control" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group" id="fcuscode">
                  <label for="cuscode">Customer Code:</label>
                  <input type="text" class="form-control autocustomercode" name="customercode" id="customercode" autocomplete="off">
                  <div id="customercodelist"></div>
                </div>
                <div class="form-group" id="fcusprice">
                  <label for="customerprice">Customer Price:</label>
                    <select name="customerprice" id="customerprice" class="form-control">
                      
                      <option value="Normal">Normal</option>
                      <option value="Dealer">Dealer</option>
                      <option value="Member">Member</option>
                      <option value="VIP">VIP</option>
                      <option value="Supper VIP">Supper VIP</option>
                    </select>
                </div>
                 
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnsavesup">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" id="closemodalsup">Close</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
  