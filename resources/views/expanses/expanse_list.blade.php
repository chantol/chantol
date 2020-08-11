@php
	$ivdate='';
	$tskhr=0;
	$tsusd=0;
	$tsbat=0;
	
	$sub_usd=0;
	$sub_khr=0;
	$sub_bat=0;
	function phpformatnumber($num){
		$dc=0;
		$p=strpos((float)$num,'.');
		if($p>0){
			$fp=substr($num,$p,strlen($num)-$p);
			$dc=strlen((float)$fp)-2;
			
		}
		if($dc>4){
			$dc=4;
		}
		return number_format($num,$dc,'.',',');
	}
@endphp
@foreach ($expanses as $key => $ep)
	@if ($ivdate<>'')
		@if ($ivdate<>$ep->dd)
			
			<tr style="font-family:khmer os system;background-color:#ddd;">
				<td colspan=5>សរុបថ្ងៃទី:{{ date('d-m-Y',strtotime($ivdate)) }}</td>
				<td colspan=6>
					<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_usd,'$') }}$</span> 
				
					<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_bat,'B') }}B</span> 
				
					<span class="label label-info" style="font-size:18px;font-family:Arial;width:100%;">{{ phpformatnumber($sub_khr,'R') }}R</span> 
				
			</tr>
			
		@endif
	@endif
	@if ($ivdate<>$ep->dd)
		<tr style="color:blue;">
			<td colspan=10>{{ date('d-m-Y',strtotime($ep->dd)) }}</td>
		</tr>
		@php
			$ivdate=$ep->dd;
			$sub_khr=0;
			$sub_usd=0;
			$sub_bat=0;
		@endphp
	@endif
	@php
		if($ep->cur=='R'){
			//$tskhr += $ep->qty * $ep->price;
			$sub_khr +=$ep->qty * $ep->price;
		}elseif($ep->cur=='B'){
			//$tsbat +=$ep->qty * $ep->price;
			$sub_bat +=$ep->qty * $ep->price;
		}elseif($ep->cur=='$'){
			//$tsusd +=$ep->qty * $ep->price;
			$sub_usd +=$ep->qty * $ep->price;
		}
	@endphp		
	<tr> 
		<td>{{ ++$key }}</td>
		<td>{{ date('d-m-Y',strtotime($ep->dd)) }}</td>
		<td>{{ $ep->user->name }}</td>
		<td>{{ $ep->type }}</td>
		<td>{{ $ep->name }}</td>
		<td style="text-align:center;">{{ $ep->qty . $ep->unit }}</td>
		<td style="text-align:right;">{{ phpformatnumber($ep->price) . $ep->cur }}</td>
		<td style="text-align:right;">{{ phpformatnumber($ep->price * $ep->qty) . $ep->cur }}</td>
		<td>{{ $ep->note }}</td>
		<td>
			<a href="#" class="btn btn-warning btn-sm btn-edit" data-id="{{ $ep->id }}">Edit</a>
			<a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{{ $ep->id }}">Del</a>
		</td>
	</tr>

@endforeach
<tr style="font-family:khmer os system;background-color:#ddd;">
	<td colspan=5>សរុបថ្ងៃទី:{{ date('d-m-Y',strtotime($ivdate)) }}</td>
	<td colspan=6>
		<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_usd,'$') }}$</span> 
	
		<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_bat,'B') }}B</span>
	
		<span class="label label-info" style="font-size:18px;font-family:Arial;">{{ phpformatnumber($sub_khr,'R') }}R</span> 
	
</tr>
@php
	$khr=0;
	$usd=0;
	$thb=0;
@endphp
@foreach ($total as $t)
	@php
		if($t->cur=="R"){
			$khr =phpformatnumber($t->tamount) . $t->cur; 
		}
		if($t->cur=="B"){
			$thb =phpformatnumber($t->tamount) . $t->cur; 
		}
		if($t->cur=="$"){
			$usd =phpformatnumber($t->tamount) . $t->cur; 
		}
	@endphp
	
@endforeach
<tr style="background-color:yellow;">
	
	<td colspan=5>សរុបចំណាយ គិតពី: {{ date('d-m-Y',strtotime($d1)) }} ដល់: {{ date('d-m-Y',strtotime($d2)) }}</td>
	
	<td colspan=2 style="font-weight:bold;">{{ $usd }}</td>
	<td style="font-weight:bold;">{{ $thb }}</td>
	<td colspan=2 style="font-weight:bold;">{{ $khr }}</td>
</tr>