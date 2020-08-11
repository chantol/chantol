@extends('layouts.master')
@section('css')
    <style>
        .cred{
            color:red;
        }
    </style>
@endsection
@section('content')

    <ul class="nav nav-pills">
      <li style="padding-bottom:10px;"><a href="#" class=""  id="btnadduser" style="font-family:arial;font-size:16px;"><i class="fa fa-user-plus"></i> Add User</a></li>
      
    </ul>

    
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Name</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbl_user">
            @foreach ($users as $key => $user)
                <tr  class={{ $user->active == 0 ? 'cred' : '' }}>
                    <td>{{ ++$key }}</td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        {{ $user->username }}
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>{{ $user->active }}</td>
                    <td>
                        <a href="" class="btn btn-info btn-sm changepwd" data-id="{{ $user->id }}" style="font-weight:bold;">Change PWD</a>
                        <a href="" class="btn btn-warning btn-sm user-edit" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-username="{{ $user->username }}" data-email="{{ $user->email }}" data-role="{{ $user->role_id }}" data-active="{{ $user->active }}" style="font-weight:bold;color:blue;">Edit</a>
                        <a href="" class="btn btn-danger btn-sm user-delete" data-id="{{ $user->id }}" style="font-weight:bold;">Remove</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    
</div>
    @include('logins.createuser_modal')
    @include('logins.edituser_modal')
    @include('logins.changepwd')
@endsection
 
@section('script')
    <script>
        $(document).ready(function(){

            $(document).on('click','#btnadduser',function(e){
                e.preventDefault();
                $('#create_user_modal').modal({
                                backdrop: 'static',
                                keyboard: true, 
                                show: true
                                }); 

                $('#h4modal').text('Add New User');

            })
            $(document).on('click','#btnsubmit',function(e){
                var data=$('#frm_add_user').serialize();
                var url="{{ route('saveuser') }}";
                $.post(url,data,function(data){
                     if($.isEmptyObject(data.error)){
                            $('#frm_add_user').trigger('reset');
                            refresh();
                      }else{
                        alert(data.error)
                      }
                })
            })
            $(document).on('click','#btnupdate',function(e){
                var data=$('#frm_edit_user').serialize();
                var url="{{ route('updateuser') }}";
                $.post(url,data,function(data){
                        //alert(data.sms)
                        $('#closemodal').click();
                        refresh();
                })
            })
            $(document).on('click','.changepwd',function(e){
                e.preventDefault();
                $('#user_id').val($(this).data('id'));
                $('#newpassword').val('');
                $('#newpassword-confirm').val('');
                $('#changepwd_modal').modal('show');
            })
            $(document).on('click','#btnresetpwd',function(e){
                var url="{{ route('resetpwd') }}";
                var data=$('#frmchangepwd').serialize();
                $.post(url,data,function(data){
                    console.log(data)
                    if($.isEmptyObject(data.error)){
                        //alert(data.sms)
                        $('#btncancelresetpwd').click();
                    }else{
                        alert(data.error)
                    }
                    
                })
            })

            $(document).on('click','.user-delete',function(e){
                e.preventDefault();
                var c=confirm('do you want to remove this user?');
                if(c==true){
                    var userid=$(this).data('id');
                    var url="{{ route('deleteuser') }}";
                    $.post(url,{userid:userid},function(data){
                        refresh();
                    })
                }
                
            })
            $(document).on('click','.user-edit',function(e){
                 e.preventDefault();
                $('#edit_user_modal').modal({
                                backdrop: 'static',
                                keyboard: true, 
                                show: true
                                }); 
                $('#userid').val($(this).data('id'))
                $('#u-name').val($(this).data('name'));
                $('#u-username').val($(this).data('username'));
                $('#u-email').val($(this).data('email'));
                $('#u-role').val($(this).data('role'));
                $('#u-active').val($(this).data('active'));
            })
            function refresh() {
                var url="{{ route('refreshuser') }}";
                $.get(url,{a:'a'},function(data){
                    $('#tbl_user').empty().html(data);
                })
            }
            //-----------------------------
        })
        
    </script>
@endsection