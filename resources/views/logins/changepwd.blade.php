<!-- Modal -->
<div id="changepwd_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      <div class="modal-body">
          <form action="" id="frmchangepwd">
            <input type="hidden" name="user_id" id="user_id">
            <label for="newpwd">New Password</label>
            <input type="password" name="newpassword" id="newpassword" class="form-control">
            <label for="confnewpwd">Confirm Password</label>
            <input type="password" name="newpassword-confirm" id="newpassword-confirm" class="form-control">
          </form>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="btncancelresetpwd">Close</button>
        <button type="button" class="btn btn-primary" id="btnresetpwd">Save new password</button>
      </div>
    </div>

  </div>
</div>