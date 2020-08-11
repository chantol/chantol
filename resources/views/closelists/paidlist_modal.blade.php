<div class="modal fade" id="salepaidmodal" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Paid Information</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                
                <div class="col-lg-2">
                  <div class="row" style="margin-left:1px;margin-right:1px;">
                     <label for="inv">Invoice#</label>
                        <input type="text" class="form-control" name="invnum" id="invnum" value="" readonly>
                  </div>
                    
                       
                   
                </div>
                <div class="col-lg-4">
                    <div class="row" style="margin-right:1px;">
                      <label for="inv">Paid Name</label>
                    <input type="text" class="form-control" name="supname" id="supname" value="" readonly>
                    </div>
                    
                  
                </div>
                <div class="col-lg-2">
                    <div class="row" style="margin-right:1px;">
                      <label for="inv">Total Amount</label>
                      <input type="text" class="form-control" name="totalinv" id="totalinv" value="" readonly style="text-align:right;">
                    </div>
                    
                  
                </div>
                <div class="col-lg-2">
                    <div class="row" style="margin-right:1px;">
                      <label for="inv">Total Paid</label>
                    <input type="text" class="form-control" name="tpaid" id="tpaid" readonly style="text-align:right;" value="">
                  
                    </div>
                    
                </div>
                <div class="col-lg-2">
                  <div class="row" style="margin-right:1px;">
                    <label for="inv">Balance</label>
                    <input type="text" class="form-control" name="bal" id="bal" readonly style="text-align:right;" value="">
                  </div>
                    
                  
                </div>
           </div>
            <br>
            <div class="row">
              <div class="col-lg-12" id="ppdt">
                
              </div>
            </div>
        </div>
        {{-- <div class="modal-footer">
           <button id="btnsavepaid" type="button" class="btn btn-danger en">Save</button>
          <button id="btncancel" type="button" class="btn btn-default en" data-dismiss="modal">Cancel</button>
        </div> --}}
      </div>
      
    </div>
  </div>