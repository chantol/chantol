@foreach ($customers as $key => $cus)
    <tr>
       <td style="width:auto;padding-bottom:0px;text-align:center;">{{ ++$key }}</td>
	      <td style="padding:0px;">
	       	<a href="#" class="btn btn-default cusname" style="width:100%;text-align:left;font-family:khmer os content;" data-id="{{ $cus->supplier_id }}" data-cname="{{ $cus->supplier->name }}" data-cur="{{ $cus->cur }}">{{ $cus->supplier->name }}
				<span class="badge badge-info pull-right">{{ $cus->cur }}</span>
	        </a>
	   	  </td>
   </tr>
@endforeach
                       