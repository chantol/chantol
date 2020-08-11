
<div class="modal fade" id="modal_productscore" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Product Score Setup</h4>
        </div>
        <div class="modal-body">
          <form action="" class="form-inline" id="frm_add_score">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                      <label style="font-family:khmer os system;" for="month">សំរាប់ខែ</label>
                      <select name="formonth" id="formonth" class="form-control">
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-family:khmer os system;" for="year">សំរាប់ឆ្នាំ</label>
                      <select name="foryear" id="foryear" class="form-control">
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                      </select>
                    </div>
                    <input type="hidden" name="userid" value="{{ Auth::id() }}">
                    <input type="hidden" name="scid" id="scid">
              </div>
          </div>
          <hr>
            <div class="row">
              <div class="col-lg-12">
                  <label style="font-family:khmer os system;" for="productid">លេខកូដទំនិញ</label>
                  <input type="text" class="form-control" id="pid" name="pid" style="height:40px;margin-bottom:5px;" readonly>

                  <label style="font-family:khmer os system;" for="productname">ឈ្មោះទំនិញ</label>
                  <input type="text" class="form-control" id="pname" name="pname" style="height:40px;margin-bottom:5px;" readonly>
               
                  <div class="row">
                    <div class="col-lg-6">
                      <label style="font-family:khmer os system;" for="qtytarget">គោលដៅលក់</label>
                      <input type="text" class="form-control" name="qtyset" id="qtyset" style="height:40px;margin-bottom:5px;" autocomplete="off" required>
                    </div>
                    <div class="col-lg-6">
                      <label style="font-family:khmer os system;" for="unit">ឯកតា</label>
                      <select name="unit" id="unit" class="form-control" style="font-family:khmer os system;height:40px;padding-top:0px;padding-bottom:0px;">
                      
                      </select>
                    </div>
                  </div>
                  <input type="hidden" name="qty" id="qty" class="form-control">
                  <input type="hidden" name="multi" id="multi" class="form-control">
                  
                  <div class="row">
                    <div class="col-lg-6">
                      <label style="font-family:khmer os system;" for="price">តំលៃ/ពិន្ទុ</label>
                      <input type="text" class="form-control" name="price" id="price" style="height:40px;margin-bottom:5px;" autocomplete="off" required>
                    </div>
                    <div class="col-lg-6">
                      <label style="font-family:khmer os system;" for="cur">រូបិយ</label>
                      <select name="cur" id="cur" class="form-control" style="height:40px;">
                        <option value="R">R</option>
                        <option value="B">B</option>
                        <option value="$">$</option>
                      </select>
                    </div>
                  </div>
               
                

              </div>
            </div>
          
      </div>
      <div class="modal-footer">
        <button type="submit" id="btnsave_score" class="btn btn-info" style="width:120px;"> រក្សាទុក </button>
        <button type="button" id="btnclosemodal" class="btn btn-default" data-dismiss="modal">បិទ</button>
      </div>
      </form>
    </div>
  </div>