<div class="modal fade" id="purchasetotalmodal" role="dialog">
    <div class="modal-dialog modal-lg" style="width:666px;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Total Paid</h4>
        </div>
        <form action="#" id="frmsavepurchasepaid">
          <div class="modal-body">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <div class="row">
              <div class="col-lg-6">
                <label for="Note">Paid on invoice#</label>
                <input type="text" style="width:100%" class="form-control" name="payoninv" id="payoninv" readonly>
              </div>
              <div class="col-lg-6">
                <label for="Note">Paid(%)</label>
                <input type="text" style="width:100%" class="form-control" name="p_paid" id="p_paid" readonly>
              </div>
            </div>
            
            <br>  
            <table class="table table-bordered table-hover">
                <tr>
                   <td class="text-center">Total</td>
                   <td class="text-center">Deposit</td>
                   <td class="text-center" colspan=2>Balance</td>
                  
                </tr>
                <tr>
                  <td><input type="text" class="form-control" name="total" id="total" style="text-align:right;width:168px;" readonly></td>
                  <td><input type="text" class="form-control" name="deposit" id="deposit" style="text-align:right;width:168px;" readonly></td>
                  <td><input type="text" class="form-control" name="balance" id="balance" style="text-align:right;width:168px;" readonly></td>
                  <td><input type="text" class="form-control" name="cur" id="cur" style="text-align:left;width:40px;" readonly></td>
                </tr>
                
            </table>
            <table class="table table-bordered table-hover">
              <tr>
                  <td rowspan=2>
                    <textarea name="numword" id="numword" cols="32" rows="4" style="font-family:khmer os system;font-size:16px;color:red;text-align:center;" readonly></textarea>
                  </td>
                  <td style="text-align:right;padding-top:12px;">Paid:</td>
                  <td><input type="text" class="form-control" name="paid" id="paid" style="text-align:right;width:168px;"></td>
                  <td><input type="text" class="form-control" name="cur1" id="cur1" style="text-align:left;width:40px;" readonly></td>
                </tr>
                <tr>
                  
                  <td style="text-align:right;padding-top:12px;">Balance:</td>
                  <td><input type="text" class="form-control" name="balance1" id="balance1" style="text-align:right;width:168px;" readonly></td>
                  <td><input type="text" class="form-control" name="cur2" id="cur2" style="text-align:left;width:40px;" readonly></td>
                </tr>
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
           <button id="btnsavepaid" type="button" class="btn btn-danger en">Save</button>
          <button id="btncancel" type="button" class="btn btn-default en" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      
    </div>
  </div>