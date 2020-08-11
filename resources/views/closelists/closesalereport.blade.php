@extends('layouts.master')
@section('pagetitle')
	Colse Sale Report
@endsection
@section('css')
	<style type="text/css" >
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
    
    .rowclick{
        cursor: pointer;
    }
    @page { /*size: landscape; */
                    size:A4;
                  /*size: 7in 9.25in;*/
                  margin: 10mm 5mm 10mm 5mm;
          }
    div.chapter, div.appendix {
    page-break-after: always;
    }
    label{
        font-family:khmer os system;
        margin-bottom:5px;
        margin-top:5px;
        color:black;
    }
</style>	

@endsection
@section('content')
    <h3 style="margin-top:-5px;color:red;">Close Sale Report</h3>
    <hr>
    <div class="row">
        <div class="col-lg-3">
           <label for="choose">ជ្រើសរើសការងារ</label>
           <select name="selreport" id="selreport" class="form-control" style="font-family:khmer os system;height:40px;">
               <option value="1">របាយការណ៌បិទបញ្ជី</option>
               <option value="2">របាយការណ៌បង់ប្រាក់</option>
           </select>
           <div id="fillsearch">
                <label for="date">គិតពី</label>
                <div class="input-group">
                    <input type="text" id="sd1" class="form-control" style="height:40px;">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
                <label for="date">ដល់</label>
                <div class="input-group">
                    <input type="text" id="sd2" class="form-control" style="height:40px;">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
                <button type="button" class="btn btn-info" id="btnsearch1" style="width:100%;margin-top:10px;">Show Report</button>    
                <button type="button" class="btn btn-info" id="btnsearchpaiddetail" style="width:100%;margin-top:1px;">Show Detail</button>            
            </div>
            <div id="fillsearch1">
                                
            </div>
        </div>
        <div class="col-lg-9" id="colview">
            
        </div>

    </div>
@endsection
@section('script')
    <script src="{{ asset('js') }}/numbertoword.js"></script>
    <script src="{{ asset('js') }}/numberinput.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

             $('#sd1').datetimepicker({
                    timepicker:false,
                    datepicker:true,
                    value:new Date(),
                    format:'d-m-yy',
                    autoclose:true,
                    todayBtn:true,
                    startDate:new Date(),
                });
            
               
                $('#sd2').datetimepicker({
                    timepicker:false,
                    datepicker:true,
                    value:new Date(),
                    format:'d-m-yy',
                    autoclose:true,
                    todayBtn:true,
                    startDate:new Date(),

                });
                $('#dodate').datetimepicker({
                    timepicker:false,
                    datepicker:true,
                    value:new Date(),
                    format:'d-m-yy',
                    autoclose:true,
                    todayBtn:true,
                    startDate:new Date(),

                });

                $(document).on('change','#selreport',function(){
                    var selval=$(this).val();
                    var el='<label for="select">Check Close Report:</label>';
                    if(selval==1){
                        el='<label for="date">គិតពី</label>'+
                            '<div class="input-group">'+
                                '<input type="text" id="sd1" class="form-control" style="height:40px;">'+
                                '<div class="input-group-addon">'+
                                    '<span class="fa fa-calendar"></span>'+
                                '</div>'+
                            '</div>'+
                            '<label for="date">ដល់</label>'+
                            '<div class="input-group">'+
                                '<input type="text" id="sd2" class="form-control" style="height:40px;">'+
                                '<div class="input-group-addon">'+
                                    '<span class="fa fa-calendar"></span>'+
                                '</div>'+
                            '</div>'+
                            '<button type="button" class="btn btn-info" id="btnsearch1" style="width:100%;margin-top:10px;">Show Report</button>'+
                            '<button type="button" class="btn btn-info" id="btnsearchpaiddetail" style="width:100%;margin-top:1px;">Show Detail</button>';
                                $('#fillsearch').html(el);
                                $('#fillsearch1').empty();
                                $('#sd1').datetimepicker({
                                timepicker:false,
                                datepicker:true,
                                value:new Date(),
                                format:'d-m-yy',
                                autoclose:true,
                                todayBtn:true,
                                startDate:new Date(),
                                });
                                $('#sd2').datetimepicker({
                                timepicker:false,
                                datepicker:true,
                                value:new Date(),
                                format:'d-m-yy',
                                autoclose:true,
                                todayBtn:true,
                                startDate:new Date(),
                                });
                    }else if(selval==2){
                        el='<label for="selecttype">ថ្ងៃបង់ប្រាក់</label>'+
                            '<select class="form-control" name="filterby" id="filterby" style="font-family:khmer os system;height:40px;">'+
                            '<option value="1">សំរាប់ថ្ងៃទី</option>'+
                            '<option value="2">ចន្លោះថ្ងៃទី</option>'+
                            '<option value="3">តូចជាងឬស្មើ</option>'+
                            '<option value="4">ធំជាងឬស្មើ</option>'+
                             
                            '</select>';
                            $('#fillsearch').html(el);
                            el1='<label for="date">កាលបរិច្ឆេទ</label>'+
                            '<div class="input-group">'+
                                '<input type="text" id="sd3" class="form-control" style="height:40px;">'+
                                '<div class="input-group-addon">'+
                                    '<span class="fa fa-calendar"></span>'+
                                '</div>'+
                            '</div>'+
                            '<button type="button" class="btn btn-info" id="btnsearch2" style="width:100%;margin-top:10px;">Show Report</button>'+
                            '<button type="button" class="btn btn-info" id="btnsearchpaiddetail2" style="width:100%;margin-top:1px;">Show Detail</button>';
                             $('#fillsearch1').html(el1);
                               $('#sd3').datetimepicker({
                                timepicker:false,
                                datepicker:true,
                                value:new Date(),
                                format:'d-m-yy',
                                autoclose:true,
                                todayBtn:true,
                                startDate:new Date(),
                                });
                    }
                })
                
                $(document).on('change','#filterby',function(){
                    var val=$(this).val();
                    if(val==1){
                        el1='<label for="date">កាលបរិច្ឆេទ</label>'+
                            '<div class="input-group">'+
                                '<input type="text" id="sd3" class="form-control" style="height:40px;">'+
                                '<div class="input-group-addon">'+
                                    '<span class="fa fa-calendar"></span>'+
                                '</div>'+
                            '</div>'+
                            '<button type="button" class="btn btn-info" id="btnsearch2" style="width:100%;margin-top:20px;">Show</button>';
                             $('#fillsearch1').html(el1);
                               $('#sd3').datetimepicker({
                                timepicker:false,
                                datepicker:true,
                                value:new Date(),
                                format:'d-m-yy',
                                autoclose:true,
                                todayBtn:true,
                                startDate:new Date(),
                                });
                    }else if(val==3 || val==4){
                        el1='<label for="date">កាលបរិច្ឆេទ</label>'+
                            '<div class="input-group">'+
                                '<input type="text" id="sd3" class="form-control" style="height:40px;">'+
                                '<div class="input-group-addon">'+
                                    '<span class="fa fa-calendar"></span>'+
                                '</div>'+
                            '</div>'+
                            '<button type="button" class="btn btn-info" id="btnsearch2" style="width:100%;margin-top:20px;">Show</button>';
                             $('#fillsearch1').html(el1);
                               $('#sd3').datetimepicker({
                                timepicker:false,
                                datepicker:true,
                                value:new Date(),
                                format:'d-m-yy',
                                autoclose:true,
                                todayBtn:true,
                                startDate:new Date(),
                                });
                    }else if(val==2){
                        el1='<label for="date">គិតពី</label>'+
                            '<div class="input-group">'+
                                '<input type="text" id="sd3" class="form-control" style="height:40px;">'+
                                '<div class="input-group-addon">'+
                                    '<span class="fa fa-calendar"></span>'+
                                '</div>'+
                            '</div>'+
                            '<div class="input-group">'+
                                '<input type="text" id="sd4" class="form-control" style="height:40px;">'+
                                '<div class="input-group-addon">'+
                                    '<span class="fa fa-calendar"></span>'+
                                '</div>'+
                            '</div>'+
                            '<button type="button" class="btn btn-info" id="btnsearch2" style="width:100%;margin-top:20px;">Show</button>';
                             $('#fillsearch1').html(el1);
                               $('#sd3').datetimepicker({
                                timepicker:false,
                                datepicker:true,
                                value:new Date(),
                                format:'d-m-yy',
                                autoclose:true,
                                todayBtn:true,
                                startDate:new Date(),
                                });
                               $('#sd4').datetimepicker({
                                timepicker:false,
                                datepicker:true,
                                value:new Date(),
                                format:'d-m-yy',
                                autoclose:true,
                                todayBtn:true,
                                startDate:new Date(),
                                });
                    }
                })
            $(document).on('click','#btnsearch1',function(e){
                e.preventDefault();
                var url="{{ route('closelists.showreport') }}";
                var d1=$('#sd1').val();
                var d2=$('#sd2').val();
                $.get(url,{d1:d1,d2:d2},function(data){
                    if($.isEmptyObject(data.error)){
                         $('#colview').empty().html(data);
                    }else{
                        $('#colview').empty();
                        alert(data.error)
                    }
                   
                })
            })
            $(document).on('click','#btnsearch2',function(e){
                e.preventDefault();
                var url="{{ route('closelists.showreportpay') }}";
                
                var paydate=$('#sd3').val();

                $.get(url,{paydate:paydate},function(data){
                    //console.log(data)
                    if($.isEmptyObject(data.error)){
                         $('#colview').empty().html(data);
                    }else{
                        $('#colview').empty();
                        alert(data.error)
                    }
                   
                })
            })
            $(document).on('click','#btnsearchpaiddetail',function(e){
                e.preventDefault();
                var url="{{ route('closelists.showreport') }}";
                var d1=$('#sd1').val();
                var d2=$('#sd2').val();
                $.get(url,{d1:d1,d2:d2,dt:1},function(data){
                    if($.isEmptyObject(data.error)){
                         $('#colview').empty().html(data);
                    }else{
                        $('#colview').empty();
                        alert(data.error)
                    }
                   
                }) 
            })
         $(document).on('click','#btnsearchpaiddetail2',function(e){
                e.preventDefault();
                var url="{{ route('closelists.showreportpay1') }}";
                
                var paydate=$('#sd3').val();

                $.get(url,{paydate:paydate},function(data){
                    //console.log(data)
                    if($.isEmptyObject(data.error)){
                         $('#colview').empty().html(data);
                    }else{
                        $('#colview').empty();
                        alert(data.error)
                    }
                   
                })
            })
        $(document).on('click','#btnprint',function(){
            printContent('printarea');
        })
            function printContent(el)
        {
              var restorpage=document.body.innerHTML;
              var printloc=document.getElementById(el).innerHTML;
              document.body.innerHTML=printloc;
              window.print();
              document.body.innerHTML=restorpage;
             
              var today=new Date();
              $('#sd1').datetimepicker({
                    timepicker:false,
                    datepicker:true,
                    value:today,
                    //format:'H:i',
                    format:'d-m-yy',
                    autoclose:true,
                    todayBtn:true,
                    startDate:today,

                });
                $('#sd2').datetimepicker({
                    timepicker:false,
                    datepicker:true,
                    //value:'13-03-2020',
                    value:today,
                    //format:'H:i',
                    format:'d-m-yy',
                    autoclose:true,
                    todayBtn:true,
                    startDate:today,

                });
        }
        })

    </script>
@endsection