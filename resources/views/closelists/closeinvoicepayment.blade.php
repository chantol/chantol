@extends('layouts.master')
@section('pagetitle')
	Sale Close List Payment
@endsection
@section('css')
	<style>
		#fade {
    display: none;
    position:absolute;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: #ababab;
    z-index: 1001;
    -moz-opacity: 0.8;
    opacity: .70;
    filter: alpha(opacity=80);
    }

#modal {
    display: none;
    position: absolute;
    top: 50%;
    left: 45%;
    width: 80px;
    height: 80px;
    padding:5px 0px 0px;
    border: 3px solid #ababab;
    box-shadow:1px 1px 10px #ababab;
    border-radius:20px;
    background-color: transparent;
    z-index: 1002;
    text-align:center;
    overflow: auto;
    }
	.modal-body
    {
        background-color:#fff;
    }

    .modal-content
    {
        background-color: #fff;
        border-radius: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
       /* background-color: transparent;*/
    }

    .modal-footer
    {
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;
        -webkit-border-bottom-left-radius: 6px;
        -webkit-border-bottom-right-radius: 6px;
        -moz-border-radius-bottomleft: 6px;
        -moz-border-radius-bottomright: 6px;
    }

    .modal-header
    {
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        -webkit-border-top-left-radius: 6px;
        -webkit-border-top-right-radius: 6px;
        -moz-border-radius-topleft: 6px;
        -moz-border-radius-topright: 6px;
    }
    label.kh{
        font-family:khmer os system;
        margin-top:5px;
        color:black;
    }
    .rowclick{
        cursor: pointer;
    }
	</style>	

@endsection
@section('content')
   
    <h3 style="margin-top:-5px;margin-left:-10px;color:blue;">Payment List</h3>
    
    <div class="row">
        <div class="col-lg-3">
           <div class="row">
               <table class="table table-hover table-bordered">
                   <thead>
                        <tr>
                            <td>Start:</td>
                            <td style="padding:0px;">
                                <input type="text" id="sd1" class="form-control" style="height:40px;">
                            </td>
                        </tr>
                        <tr>
                            <td>End:</td>
                            <td style="padding:0px;">
                                <input type="text" id="sd2" class="form-control" style="height:40px;">
                            </td>
                        </tr>
                        <tr>
                            
                            {{-- <td style="padding:0px;"><input type="text" id="search" class="form-control" style="font-family:khmer os content;height:40px;border:none;"></td> --}}
                            <td style="padding:0px;" colspan=2>
                                <a href="" style="width:100%" class="btn btn-info searchcusbydate">Search</a>
                            </td>
                        </tr>
                        
                       <tr>
                           <td colspan=2 style="padding:0px;">
                              
                               <input type="text" id="tablesearch" onkeyup="autosearch()" placeholder="ស្វែងរកអតិថិជន" title="Type in a name" style="font-family:khmer os system;" class="form-control" autocomplete="off">
                           </td>
                       </tr>
                   </thead>
               </table>
                <div style="overflow:auto; margin-top:-20px;">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tblcustomer">
                        <thead>
                            <tr style="font-family:khmer os system"> 
                                <th class="text-center">លរ</th>
                                <th class="text-center">ឈ្មោះអតិថិជន</th>

                           </tr>
                        </thead>
                        
                       <tbody id="customer">
                            {{-- @foreach ($customers as $key => $cus)
                                <tr>
                                   <td style="width:auto;">{{ ++$key }}</td>
                                   <td><a href="#" class="cusname" style="height:40px;width:100%;text-align:left;font-family:khmer os content;padding-top:10px;" data-id="{{ $cus->id }}" data-cname="{{ $cus->name }}">{{ $cus->name }} <span class="badge badge-info pull-right">{{ $cus->cur }}</span></a></td>
                               </tr>
                            @endforeach --}}
                       </tbody>
                   </table>
                    </div>
                    
                </div>
               
           </div>
           
        </div>

         <!-- Image loader -->
        <div id="fade"></div>
        <div id="modal">
            <img id="loader" src="/logo/ajaxloading4.gif" />
        </div>

        <div class="col-lg-9">  
            <div class="row">   
                <div class="panel panel-default">
                    <div class="panel-heading">Close List Payment</div>

                    <div class="panel-body">
                        <form action="" id="frmsavecloselistpayment" method="POST">
                            <div class="row">
                                <div class="col-lg-2">
                                     <div class="row" style="margin-left:1px;">
                                        <label for="customer">Customer ID</label>
                                        <input type="text" class="form-control" name="cusid" id="cusid" style="height:40px;" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">  
                                    <div class="row" style="margin-left:1px;">
                                        <label for="customer">Customer Name</label>
                                        <input type="text" class="form-control" name="cusname" id="cusname" style="height:40px;font-family:khmer os system;" readonly>
                                    </div>
                                    <input type="hidden" id="currency">
                                </div>
                                
                                
                            </div>
                            <br>

                            {{-- -------------------------invoice Table----------------------- --}}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="" id="table_data">
                                        @include('closelists.s_invoice2')
                                    </div>
                                </div>
                             </div>
                        </form>
                        <br>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="" id="saledetail">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                 <label for="inv">Inv#: <span id="inv1" style="font-weight:bold;">0000</span></label> 
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="sup">Customer: <span id="sup1" style="font-weight:bold;">..........</span></label>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="tt">Total: <span id="total1" style="font-weight:bold;">0</span></label>
                                            </div>
                                        </div>
                                        @include('sales.s_invoice_detail')
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js') }}/numbertoword.js"></script>
    <script src="{{ asset('js') }}/numberinput.js"></script>
    <script type="text/javascript">
        function autosearch() {
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById("tablesearch");
          filter = input.value.toUpperCase();
          table = document.getElementById("tblcustomer");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }       
          }
        }
        $(document).ready(function(){

            var today=new Date();
            
                $('#sd1').datetimepicker({
                    timepicker:false,
                    //hours12:true,//false for 24 hour
                    //step:5,//increase 5 minut
                    //allowTimes:['01:00','01:15']
                    datepicker:true,
                    //value:'13-03-2020',
                    value:today,
                    //format:'H:i',
                    format:'d-m-yy',
                    autoclose:true,
                    todayBtn:true,
                    startDate:today,

                });
                $('#sd2').datetimepicker({
                    timepicker:false,
                    //hours12:true,//false for 24 hour
                    //step:5,//increase 5 minut
                    //allowTimes:['01:00','01:15']
                    datepicker:true,
                    //value:'13-03-2020',
                    value:today,
                    //format:'H:i',
                    format:'d-m-yy',
                    autoclose:true,
                    todayBtn:true,
                    startDate:today,

                });
                $('#dodate').datetimepicker({
                    timepicker:false,
                    //hours12:true,//false for 24 hour
                    //step:5,//increase 5 minut
                    //allowTimes:['01:00','01:15']
                    datepicker:true,
                    //value:'13-03-2020',
                    value:today,
                    //format:'H:i',
                    format:'d-m-yy',
                    autoclose:true,
                    todayBtn:true,
                    startDate:today,

                });
            $(document).on('click','.searchcusbydate',function(e){
                e.preventDefault();
                var url="{{ route('searchcustomercloselist') }}";
                var d1=$('#sd1').val();
                var d2=$('#sd2').val();
                
                $.get(url,{d1:d1,d2:d2},function(data){
                    //console.log(data)
                    $('#customer').empty().html(data);
                })
            })
            $(document).on('click','.cusname',function(e){
                var cid=$(this).data('id');
                var cname=$(this).data('cname');
                var cur=$(this).data('cur');
                $('#cusid').val(cid);
                $('#cusname').val(cname + '('+cur+')');
                $('#currency').val(cur);
                var url="{{ route('getsaleinvoice1') }}";
                var d1=$('#sd1').val();
                var d2=$('#sd2').val();
                
                $.get(url,{cid:cid,cur:cur,d1:d1,d2:d2},function(data){
                    $('#table_data').empty().html(data);
                    //console.log(data)
                    $('#dodate').datetimepicker({
                    timepicker:false,
                    datepicker:true,
                    value:new Date(),
                    format:'d-m-yy',
                    autoclose:true,
                    todayBtn:true,
                    startDate:new Date(),

                    });

                })
            })
            $(document).on('click','#btnsavepaid',function(e){
                e.preventDefault();
                var conf=confirm('Do you want to save paid?');
                if(conf==true){
                    var url="{{ route('savecloselistpaid') }}";
                    var fdata=$('#frmsavecloselistpayment').serialize();
                    $.post(url,fdata,function(data){
                          
                        if($.isEmptyObject(data.error)){
                            //alert('Paid List Completed')
                            getlastcloselist();
                            getpaiddetail();
                            $('#btnsavepaid').attr('disabled',true);
                        }else{
                            alert(data.error);
                        }
                        
                        console.log(data)
                    })
                }
            })
            function getlastcloselist() {
                var url="{{ route('getlastcloselist') }}";
                var d1=$('#sd1').val();
                var d2=$('#sd2').val();
                var cid=$('#cusid').val();
                var cur=$('#currency').val();
                $.get(url,{cid:cid,cur:cur,d1:d1,d2:d2},function(data){
                   $('#tbl_closelist').empty().html(data);
                })
            }
            function getpaiddetail() {
                var url="{{ route('getpaidlistdetail') }}";
                var clid=$('#closelistid').val();
                $.get(url,{clid:clid},function(data){
                    $('#table_data #tbl_paiddetail').empty().html(data);
                })
            }
            function getinvoiceclose() {
                var url="{{ route('getclosesaleinvoice') }}";
                var clid=$('#closelistid').val();
                $.get(url,{clid:clid},function(data){
                    $('#invoicelist').empty().html(data);
                })
            }
            $(document).on('click','.btndelpaid',function(e){
                e.preventDefault();
                var conf=confirm('Do you want to delete this payment?');
                if(conf==true){
                    var url="{{ route('deletepaidlist') }}";
                    var id=$(this).data('id');
                    var clid=$('#closelistid').val();
                    $.post(url,{id:id,clid:clid},function(data){
                        getpaiddetail();
                        getlastcloselist();
                        $('#btnsavepaid').attr('disabled',true);
                    })
                }
            })
            $(document).on('click','.btndellist',function(e){
                e.preventDefault();
                //var row=$(this).closest('tr');
                var conf=confirm('Do you want to delete this list?');
                if(conf==true){
                    var url="{{ route('deletecloselist') }}";
                    var id=$(this).data('id');
                    var cusid=$(this).data('cusid');
                    var cur=$(this).data('cur')
                    $.post(url,{id:id,cusid:cusid,cur:cur},function(data){
                        getpaiddetail();
                        getlastcloselist();
                    })
                }
                
            })
            function formatNumber(num)
            {
                num=parseFloat(num);
                var k=String(num).split('.');
                if(k.length==2){
                    var fnum=k[0].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                    var snum=k[1];
                    return fnum + '.' + snum;
                }else{
                    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                }
            }
            $(document).on('click','.rowclick',function(e){
                e.preventDefault();
                var row = $(this).closest('tr');
                var bal=row.find("td:eq(13)").text().replace(/,/g,'');
                var deposit=row.find("td:eq(12)").text().replace(/,/g,'');
                var total=row.find("td:eq(11)").text().replace(/,/g,'');
                var cur=row.find("td:eq(14)").text();
                $('#closelistid').val(row.find("td:eq(1)").text());
                $('#t_debt').val(formatNumber(total) + ' ' + cur);
                $('#t_deposit').val(formatNumber(deposit) + ' ' + cur);
                $('#t_bal').val(formatNumber(bal) + ' ' + cur);
                $('#receive').val(0);
                $('#balance').val(formatNumber(bal) + ' ' + cur);
                $('#icur').val(cur);
                $('#btnsavepaid').attr('disabled',false);
                $('#note').val('');
                getpaiddetail();
                getinvoiceclose();
            })
            //show invoice detail
            $(document).on('click','.showinvdetail',function(e){
                e.preventDefault();
                var invid_str='';
                var invid=$(this).data('id');
                var supname=$(this).data('supname');
                var cur=$(this).data('cur');
                var totalinv=$(this).data('totalinv');

                if(invid<1000){
                    var con_str='0000'.concat(invid);
                    invid_str=con_str.slice(con_str.length-4,con_str.length);
                }else{
                     invid_str=invid;
                }
                $('#inv1').text(invid_str);
                $('#sup1').text(supname);
                $('#total1').text(formatNumber(totalinv) + ' ' + cur);
                var url="{{ route('showsaledetail') }}";
                $.get(url,{id:invid},function(data){
                    //console.log(data)
                    $('#invoicelistdetail').empty().html(data);
                    
                });
            });

           
            $(document).on('input','#receive',function(){
                var c=$('#icur').val();
                var invbal=$('#t_bal').val().replace(/,/g,'').replace(c,'');
                var newbal=parseFloat(invbal)-parseFloat($(this).val());
                $('#balance').val(formatNumber(newbal)+' ' + c);
            })
            $(document).on('blur','#receive',function(){
                var rc=$(this).val().replace(/,/g,'');
                $('#receive').val(formatNumber(rc));
            })
            $(document).ajaxStart(function(){
              openModal();
            });
            $(document).ajaxComplete(function(){
              setTimeout(function()
                    {
                        closeModal();
                    },500);
            });
            function openModal() {
                document.getElementById('modal').style.display = 'block';
                document.getElementById('fade').style.display = 'block';
            }

            function closeModal() {
                document.getElementById('modal').style.display = 'none';
                document.getElementById('fade').style.display = 'none';
            }

            number('#old_debt',true);
            number('#receive',true);


        })
    </script>
@endsection