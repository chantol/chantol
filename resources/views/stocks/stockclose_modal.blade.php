
  <!-- Modal -->
  <div class="modal fade" id="stockclose_modal" role="dialog">
    <div class="modal-dialog modal-lg" style="width:700px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Stock Close</h4>
        </div>
        <div class="modal-body">
          <form action="" id="frmclosestock">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <div class="row">
              <div class="col-sm-3">
                <label style="font-family:khmer os system;" for="proid">លេខកូដទំនិញ</label>
                <input type="hidden" name="pid" id="pid" class="form-control">
                <input type="text" name="pcode" id="pcode" class="form-control" style="height:40px;">
              </div>
              <div class="col-sm-9">
                <label style="font-family:khmer os system;" for="proname">ឈ្មោះទំនិញ</label>
                <input style="font-family:khmer os system;height:40px;" type="text" name="pname" id="pname" class="form-control">
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-6">
                <label style="font-family:khmer os system;" for="mode">ការងារ</label>
                <select name="job" id="job" class="form-control" style="font-family:khmer os system;height:40px;">
                  <option value="0">បិទស្តុក</option>
                  <option value="2">ថែមថយស្តុក</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label style="font-family:khmer os system;" for="date">ថ្ងៃបិទស្តុក</label>
                <div class="input-group">
                  <input type="text" name="closedate" id="closedate" class="form-control" style="height:40px;">
                  <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                  </div>
                </div>
              </div>
            </div>
            
           
            <div class="row">
              <div class="col-sm-6">
                <label style="font-family:khmer os system;" for="qty">ចំនួនរាយ</label>
                <input style="font-family:khmer os system;height:40px;text-align:right;" type="text" name="stockqty" id="stockqty" class="form-control" autocomplete="off" required>
              </div>
              <div class="col-lg-6">
                <label style="font-family:khmer os system;" for="unit">ឯកតារាយ</label>
                <input type="text" name="unit" id="unit" class="form-control"​ style="font-family:khmer os system;height:40px;" readonly>
              </div>
            </div>
            
             <div class="row">
              <div class="col-sm-4">
                <label style="font-family:khmer os system;" for="qty">ថ្លៃដើម</label>
                <input style="font-family:khmer os system;height:40px;text-align:right;" type="text" name="cost" id="cost" class="form-control" autocomplete="off" required>
              </div>
              <div class="col-sm-2">
                <label style="font-family:khmer os system;" for="qty">រូបិយ</label>
                <input style="font-family:khmer os system;height:40px;text-align:left;" type="text" name="cur" id="cur" class="form-control" autocomplete="off" readonly>
              </div>
              <div class="col-lg-6">
                <label style="font-family:khmer os system;" for="unit">សរុបទឹកប្រាក់</label>
                <input type="text" name="stockamount" id="stockamount" class="form-control"​ style="font-family:khmer os system;height:40px;" readonly>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnsavestock">Save Stock</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

