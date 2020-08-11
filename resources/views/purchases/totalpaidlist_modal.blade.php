<div class="modal fade" id="modal_purchasetotalpaidlist" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1006px;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Total Paid</h4>
        </div>
        <form action="#" id="frmsavepurchasepaidlist">
          <div class="modal-body">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <div class="row">
              <div class="col-lg-4">
                  <label for="customer">Customer</label>
                  <input type="text" name="customerpaid" id="customerpaid" class="form-control">
              </div>
              <div class="col-lg-4">
                  <label for="tpaid">TotalPaid</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="getpaid" id="getpaid" class="form-control" style="text-align:right;" readonly>
                    <div class="input-group-addon">
                      <span class="" id="getcur"></span>
                      <input type="hidden" id="getpaidcur" name="getpaidcur">
                    </div>
                  </div>
                  
              </div>
              <div class="col-lg-4">
                  <label for="paydate">PayDate</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="paydate" id="paydate" class="form-control">
                    <div class="input-group-addon">
                     <span class="fa fa-calendar"></span>
                    </div>
                  </div>
                  
              </div>
            </div>
            
            <br>  
            <table class="table table-bordered table-hover">
              <tr>
              <th>N<sup>o</sup></th>
              <th>Inv#</th>
              <th>Total</th>
              <th>Deposited</th>
              <th>Balance</th>
              <th>Deposit</th>
              <th>Balance</th>
              <th>%paid</th>
              <th>Action</th>
              </tr>
              <tbody id="spl">
                
              </tbody>
            </table>
            
            <label for="Note">Pay Method</label>
            <select name="paymethod" id="paymethod" class="form-control">
              <option value=""></option>
              <option value="Cash">Cash</option>
              <option value="Bank">Bank</option>
              <option value="Other">Other</option>
            </select>
            <label for="Note">Note</label>
            <input type="text" style="width:100%" class="form-control" name="paynote">
            
          </div>
        </form>
        <div class="modal-footer">
            <label style="display:inline;float:left;font-family:khmer os system;font-size:22px;font-weight:normal;" id="readnum">អានចំនួន</label>
           <button id="btnsavepaid" type="button" class="btn btn-info en">Save</button>
          <button id="btncancel" type="button" class="btn btn-default en" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      
    </div>
  </div>