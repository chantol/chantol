 <!-- Modal -->

 </style>
  <div class="modal fade" id="addexpanse_modal" role="dialog" style="z-index:1300; ">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="background-color:#fff;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="mtitle">Add Expanse</h4>
        </div>
        <div class="modal-body">
          <form action="" id="frmexpanse">
            <div class="container">
                  <input type="hidden" id="record_id" name="record_id">
                  <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                  <div class="row">
                      <div class="col-lg-6">
                        <label style="font-family:khmer os system" for="date">កាលបរិច្ឆេទ</label>
                        <div class="input-group">
                          <input type="text" name="expdate" id="expdate" class="form-control" style="height:40px;">
                          <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <label​​ style="font-family:khmer os system;" for="exptype">ប្រភេទចំណាយ</label>
                        <input type="text" class="form-control" name="type" id="type" list="typelist" style="font-family:khmer os system;height:40px;margin-top:5px;" autocomplete="off" />
                        <datalist id="typelist">
                            @foreach ($types as $t)
                              <option value="{{ $t->type }}">{{ $t->type }}</option>
                            @endforeach
                        </datalist>
                      </div>
                  </div>
                  

                  <label style="font-family:khmer os system" for="name">បរិយាយ</label>
                  <input type="text" name="name" id="name" class="form-control"  list="namelist" style="font-family:khmer os system;height:40px;" autocomplete="off">
                  <datalist id="namelist">
                     @foreach ($names as $n)
                        <option value="{{ $n->name }}">{{ $n->name }}</option>
                      @endforeach
                  </datalist>
                  <div class="row">
                    <div class="col-lg-6">
                        <label style="font-family:khmer os system" for="qty">ចំនួន</label>
                        <input type="text" class="form-control" name="qty" id="qty" style="font-size:18px;height:40px;" autocomplete="off">
                    </div>
                    <div class="col-lg-6">
                      <label style="font-family:khmer os system" for="unit">ឯកតា</label>
                      <input type="text" class="form-control" name="unit" id="unit" list="unitname" style="font-family:khmer os system;height:40px;" autocomplete="off"/>
                      <datalist id="unitname">
                           
                          @foreach ($units as $u)
                            <option value="{{ $u->unit }}">{{ $u->unit }}</option>
                          @endforeach
                      </datalist>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-4">
                      <label style="font-family:khmer os system" for="price">តំលៃ</label>
                      <input type="text" class="form-control" name="price" id="price" style="font-size:18px;height:40px;" autocomplete="off">
                    </div>
                    <div class="col-lg-2">
                      <label style="font-family:khmer os system" for="cur">រូបិយ</label>
                      <select name="cur" id="cur" class="form-control" style="height:40px;">
                        <option value="R">R</option>
                        <option value="B">B</option>
                        <option value="$">$</option>
                      </select>
                    </div>
                    <div class="col-lg-6">
                      <label style="font-family:khmer os system" for="amount">សរុបទឹកប្រាក់</label>
                      <input type="text" class="form-control" name="amount" id="amount" style="font-size:18px;height:40px;" autocomplete="off">
                    </div>
                  </div>
                  
                  <label​​ style="font-family:khmer os system" for="note">កំណត់សំគាល់</label>
                  <textarea name="note" id="note" cols="30" rows="3" class="form-control" style="resize:none;"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn_save_expanse">រក្សាទុក</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">បិទ</button>
        </div>
      </div>
      
    </div>
  </div>
  