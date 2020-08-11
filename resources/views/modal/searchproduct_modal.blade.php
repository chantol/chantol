

  <!-- Modal -->
  <div class="modal fade" id="ProductSearchModal" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1066px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Search Product</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-lg-3">
                  <div class="row" style="margin-left:5px;margin-right:5px;">
                     <table class="table table-hover table-bordered">
                         <thead>
                             <tr style="text-align:center;"> 
                                  <td>No</td>
                                  <td>Category</td>
                             </tr>
                             <tr>
                              <td>Search:</td>
                              <td style="padding:0px;"><input type="text" id="searchcat" class="form-control" style="font-family:khmer os content;height:40px;border:none;"></td>
                              </tr>
                         </thead>
                         <tbody id="categoryinmodal">
                          @foreach ($cats as $key => $cat)
                              <tr>
                                 <td style="width:auto;">{{ ++$key }}</td>
                                 <td style="padding:0px;"><a href="#" class="catname btn btn-default" style="height:40px;width:100%;text-align:left;font-family:khmer os content;padding-top:10px;" data-id="{{ $cat->id }}">{{ $cat->name }}</a></td>
                             </tr>
                          @endforeach
                             
                             
                         </tbody>
                     </table>
                 </div>
              </div>
              <div class="col-lg-9">
                  <div class="row" style="margin-right:5px;">
                    <input type="text" class="form-control" name="search" id="search" placeholder="search..." style="font-family:'khmer os system';">
                  </div>
                  <div class="row" style="margin-top:2px;margin-right:5px;">
                    <table class="table table-hover table-bordered" style="border-collapse:collapse;">
                        <thead>
                          <tr>
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">PID</th>
                            <th style="text-align:center;">Name</th>
                            <th style="text-align:center;">Unit</th>
                            
                          </tr>
                        </thead>
                        <tbody id="product_search_table">
                         
                        </tbody>
                    </table>
                  </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

