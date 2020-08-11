<!-- Modal -->

  <div class="modal fade" id="create_product_modal" role="dialog" style="">
    <div class="modal-dialog" id="mw">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="h4modal">Add Product</h4>
        </div>
        <div class="modal-body">
          
            <div class="row">

              <div class="col-lg-12">
                <div class="alert alert-danger print-error-msg" style="display:none">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <ul></ul>
                </div>
                <form action="" method="POST" id="frm_add_product" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  
                  <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">
                  <input type="hidden" name="old_image" id="old_image">
                  
                    <div class="col-lg-12">
                      <div class="row">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <b><i class="fa fa-apple"></i>Product</b>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-lg-8">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <label for="category" style="font-family:khmer os system;">ក្រុមទំនិញ</label>
                                    <div class="input-group">
                                      <select style="font-family:khmer os content;width:100%;" class="form-control" name="sel_category" id="sel_category"​ required>
                                        <option value=""></option>
                                        @foreach ($categories as $y)
                                          <option value="{{ $y->id }}">{{ $y->name }}</option>
                                        @endforeach
                                      </select>
                                      <div class="input-group-addon btn btn-default" id="add_category">
                                        <span class="fa fa-plus" ></span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-lg-12" style="margin-top:5px;">
                                    <label for="category" style="font-family:khmer os system;">ម៉ាកទំនិញ</label>
                                    <div class="input-group">
                                      <select style="font-family:khmer os content;width:100%" class="form-control" name="sel_brand" id="sel_brand"​ required>
                                        <option value=""></option>
                                        @foreach ($brands as $b)
                                          <option value="{{ $b->id }}">{{ $b->name }}</option>
                                        @endforeach
                                      </select>
                                      <div class="input-group-addon btn btn-default" id="add_brand">
                                        <span class="fa fa-plus" ></span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="row"> 
                                  <div class="col-lg-12" style="margin-top:5px;">
                                    <div class="form-group">
                                      <label for="productcode" style="font-family:khmer os system;">លេខកូដទំនិញ</label>
                                      <input type="text" name="productcode" id="productcode" class="form-control" style="height:40px;" placeholder="លេខកូដទំនិញ" value="{{ old('productcode') }}" required​ autocomplete="off">
                                    </div>
                                  </div>
                                  <div class="col-lg-12" style="margin-top:5px;">
                                    <div class="form-group">
                                      <label for="nationalcard" style="font-family:khmer os system;">ឈ្មោះទំនិញ</label>
                                      <input type="text" name="productname" id="productname" class="typeautosearch form-control"​ style="height:40px;" placeholder="ឈ្មោះទំនិញ" value="{{ old('productname') }}" required​ autocomplete="off">
                                    </div>
                                  </div>  
                                </div>
                                
                                <div class="row"> 
                                  <div class="col-lg-3">
                                    <div class="form-group">
                                      <label for="productcode" style="font-family:khmer os system;">ស្តុកនៅសល់(គិតរាយ)</label>
                                      <input type="text" name="stockqty" id="stockqty" class="form-control" style="height:40px;text-align:right;" value="{{ old('stockqty') }}" required autocomplete="off">
                                      
                                    </div>
                                  </div>
                                  <div class="col-lg-9">
                                    <div class="form-group">
                                      <label for="unit" style="font-family:khmer os system;">ឯកតារាយ</label>
                                      <div class="input-group">
                                        <select class="form-control" style="height:40px;font-family:khmer os system;" name="selunit" id="selunit"​ required>
                                          <option value=""></option>
                                          @foreach ($units as $u)
                                            <option value="{{ $u->name }}">{{ $u->name }}</option>
                                          @endforeach
                                        </select>
                                        <div class="input-group-addon btn btn-default" id="add_unit">
                                          <span class="fa fa-plus" ></span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>  
                                  
                                </div>
                                <div class="row">
                                  <div class="col-lg-3">
                                    <div class="form-group">
                                      <label for="costprice" style="font-family:khmer os system;">ថ្លៃដើមស្តុក(គិតរាយ)</label>
                                      <input type="text" name="unitprice" id="unitprice" class="form-control unitprice" style="height:40px;text-align:right;font-size:16px;" value="{{ old('unitprice') }}" required autocomplete="off">
                                      
                                    </div>
                                  </div>
                                  <div class="col-lg-3">
                                    <div class="form-group">
                                      <label for="cur" style="font-family:khmer os system;">គិតជាលុយ</label>
                                      {{-- <input type="text" class="form-control" name="cur1" id="cur1" value="{{ $stockcur }}" style="height:40px;" readonly> --}}
                                      <select name="cur1" id="cur1" class="form-control" style="height:40px;">
                                        <option value="R">R</option>
                                        <option value="B">B</option>
                                        <option value="$">$</option>
                                      </select>
                                    </div>
                                  </div>  
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                      <label for="costprice" style="font-family:khmer os system;">សរុបលុយក្នុងស្តុក</label>
                                      <input type="text" name="amount1" id="amount1" class="form-control" style="height:40px;text-align:right;"  value="{{ old('amount1') }}" required readonly>
                                      
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col lg-3" style="margin-top:30px;">
                                <div class="form-group form-group-login">
                                  <table style="margin:0 auto;">
                                    <thead>
                                      <tr class="info">
                                        <th class="student-id">PID:<input type="text" name="product_id" id="product_id" readonly style="text-align:center;"></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td class="photo">
                                          {!! Html::image('logo/NoPicture.jpg',null,['class'=>'student-photo','id'=>'showPhoto']) !!}
                                          {{-- <img src="{{ asset('logo/NoPicture.jpg') }}" alt="" class="student-photo" id="showPhoto"> --}}
                                          <input type="file" name="image" id="image" accept="image/x-png,image/png,image/jpg,image/jpeg,image/webp">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="text-align:center;background:#ddd;">
                                          <button type="button" name="browse_file" id="browse_file" class="btn btn-info btn-browse en" value="Browse"​ style="width:100%;color:blue;">Browse</button>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                            
                          </div>
                          
                        </div>
                        
                      </div>
                      
                    </div>
                    {{-- ------------------------- --}}

                    <div class="col-lg-12">
                      <div class="row">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <b><i class="fa fa-apple"></i>Product Barcode</b>
                          </div>
                          
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-lg-12 col-sm-12">
                                {{-- <div class="form-group"> --}}
                                <div class="table-responsive" style="overflow:auto;">
                                <table class="table table-bordered">

                                  <thead>
                                    <th style="width:60px;text-align:center;padding-bottom:15px;">No</th>
                                    <th style="width:200px;text-align:center;padding-bottom:15px;">Barcode</th>
                                    <th style="width:120px;text-align:center;padding-bottom:15px;">Unit</th>
                                    <th style="width:120px;text-align:center;padding-bottom:15px;">Price</th>
                                    <th style="width:80px;text-align:center;padding-bottom:15px;">Cur</th>
                                    <th style="width:120px;text-align:center;padding-bottom:15px;">Dealer</th>
                                    <th style="width:120px;text-align:center;padding-bottom:15px;">Member</th>
                                    <th style="width:120px;text-align:center;padding-bottom:15px;">VIP</th>
                                    <th style="width:120px;text-align:center;padding-bottom:15px;">SP-VIP</th>
                                    
                                    <th style="width:80px;text-align:center;padding-bottom:15px;">Multi</th>
                                    <th style="text-align:left;"><a href="#" class="btn btn-info addrow"  style="border-radius:15px;"><i class="fa fa-plus"></i></a></th>
                                  </thead>
                                  <tbody id="tbl_barcode">
                                    @foreach ($pbarcodes as $key => $value)
                                      <tr>
                                        <td class="no" style="width:60px;text-align:center;padding-top:15px;">
                                          {{ ++$key }}
                                        </td>
                                        <td>
                                          <input type="text" class="form-control barcode canenter" style="width:200px;height:40px;" name="barcode[]" required autocomplete="off">
                                        </td>
                                        <td>
                                          <select class="form-control unit" style="height:40px;width:120px;" name="unit[]" id="unit{{ $key }}" required>
                                            @foreach ($units as $u)
                                              <option value="{{ $u->name }}" {{ $u->name==$value->unit?'selected':'' }}>{{ $u->name }}</option>
                                            @endforeach
                                          </select>
                                        </td>
                                        <td><input type="text" class="form-control price canenter" name="price[]" required style="text-align:right;height:40px;font-size:16px;width:120px;" value="{{ $value->cur=='$'?number_format($value->price,2,'.',','):number_format($value->price) }}" autocomplete="off">
                                        </td>
                                        <td>
                                          <select name="cur[]" class="form-control" style="height:40px;width:80px;">
                                            <option value="R" {{ $value->cur=='R'?'selected':'' }}>R</option>
                                            <option value="B" {{ $value->cur=='B'?'selected':'' }}>B</option>
                                            <option value="$" {{ $value->cur=='$'?'selected':'' }}>$</option>

                                          </select>
                                        </td>
                                        
                                        <td><input type="text" class="form-control price canenter" name="dealer[]" required style="text-align:right;height:40px;font-size:16px;width:120px;" value="{{ $value->cur=='$'?number_format($value->dealer,2,'.',','):number_format($value->dealer) }}" autocomplete="off">
                                        </td>
                                        <td><input type="text" class="form-control price canenter" name="member[]" required style="text-align:right;height:40px;font-size:16px;width:120px;" value="{{ $value->cur=='$'?number_format($value->member,2,'.',','):number_format($value->member) }}" autocomplete="off">
                                        </td>
                                        <td><input type="text" class="form-control price canenter" name="vip[]" required style="text-align:right;height:40px;font-size:16px;width:120px;" value="{{ $value->cur=='$'?number_format($value->vip,2,'.',','):number_format($value->vip) }}" autocomplete="off">
                                        </td>
                                        <td><input type="text" class="form-control price canenter" name="suppervip[]" required style="text-align:right;height:40px;font-size:16px;width:120px;" value="{{ $value->cur=='$'?number_format($value->suppervip,2,'.',','):number_format($value->suppervip) }}" autocomplete="off">
                                        </td>

                                        <td>
                                          <input type="text" class="form-control multi canenter" style="height:40px;width:80px;" name="multi[]" value="{{ $value->multiple }}" required autocomplete="off">
                                        </td>
                                        <td>
                                          <a href="#" class="btn btn-danger remove" style="border-radius:15px;margin-top:5px;"><i class="fa fa-minus"></i></a>
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                               {{--  </div> --}}
                              </div>
                            </div>
                          </div>
                         
                          <div class="panel-footer" style="background:white;height:212px;">
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label for="description">Description</label>
                                  <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ old('description') }}</textarea>
                                </div>
                              </div>  
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-save pull-right" style="width:150px;"><i class="fa fa-save"></i> &nbsp;រក្សាទុក</button>
                            <button type="button" class="btn btn-success btn-new pull-right"​ style="margin-right:30px;" ><i class="fa fa-file"></i>&nbsp;សំអាត</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            
                            
                          </div>
                        </div>
                      </div>
                    </div>  
                </form>
              </div>
            </div>

        </div>
        
      </div>
      
    </div>
  </div>
  