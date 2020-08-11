 <!-- Modal -->
 
  <div class="modal fade modaldraggable" id="additem_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Item</h4>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-lg-3">
                <label style="font-family:khmer os system" for="productcode">លេខកូដទំនិញ</label>
                <input type="text" class="form-control" id="acode" name="acode" style="height:40px;" autocomplete="off">
              </div>
              <div class="col-lg-9">
                <label style="font-family:khmer os system" for="productname">ឈ្មោះទំនិញ</label>
                <input type="text" class="form-control" id="aname" name="aname" style="height:40px;font-family:khmer os system;">
                <input type="hidden" class="form-control" id="abarcode" name="abarcode">
              </div>
               <div class="col-lg-3">
                <label style="font-family:khmer os system;margin-top:10px;" for="category">ចំនួន</label>
                <input type="text" class="form-control" id="aqty" name="aqty" style="height:40px;font-size:16px;">
              </div>
              <div class="col-lg-3">
                <label style="font-family:khmer os system;margin-top:10px;" for="category">ឯកតា</label>
                <select name="aunit" id="aunit" class="form-control" style="font-family:khmer os system;height:40px;">
                  
                </select>
              </div>
              <div class="col-lg-3">
                <label style="font-family:khmer os system;margin-top:10px;" for="category">តំលៃ</label>
                <input type="text" class="form-control" id="aprice" name="aprice" style="height:40px;font-size:16px;">
              </div>
              <div class="col-lg-3">
                <label style="font-family:khmer os system;margin-top:10px;" for="category">សរុបទឹកប្រាក់</label>
                <input type="text" class="form-control" id="aamount" name="aamount" style="height:40px;font-size:16px;" readonly>
                <input type="hidden" id="acur" name="acur" class="form-control">
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info btn_add_item" >Add List</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  