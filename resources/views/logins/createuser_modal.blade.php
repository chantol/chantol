<!-- Modal -->

  <div class="modal fade" id="create_user_modal" role="dialog" style="">
    <div class="modal-dialog" style="width:500px;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="h4modal">Add User</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-danger print-error-msg" style="display:none">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <ul></ul>
                </div>
                <form action="" method="POST" id="frm_add_user" enctype="multipart/form-data" autocomplete="off">
                  {{ csrf_field() }}
                  
                      <label for="name">Name</label>
                      <input type="text" name="name" id="name" class="form-control" required>
                      <label for="loginname">Login Name</label>
                      <input type="text" name="username" id="username" class="form-control"  required>
                      <label for="email">Email</label>
                      <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                      <label for="role">Role</label>
                      <select name="role" id="role" class="form-control">
                        @foreach ($roles as $role)
                          <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                      </select>
                      <label for="password">Password</label>
                      <input type="password" id="password" class="form-control" required="" name="password">
                      <label for="password">Confirm Password</label>
                      <input type="password" id="password-confirm" class="form-control" required="" name="password_confirmation">
                      <label for="active">Active</label>
                      <select name="active" id="active" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Disactive</option>
                      </select>
                  
                </form>
              </div>
            </div>

        </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal" id="closemodalsave">Close</button>
              <button class="btn btn-primary" id="btnsubmit">Submit</button>
          </div>
      </div>
      
    </div>
  </div>
  