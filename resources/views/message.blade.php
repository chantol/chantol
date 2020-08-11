@if ($errors->any())
    <div class="alert alert-danger">
    	<button type="button" class="close" data-dismiss="alert">&times;</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(Session::has('success'))
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p>{{ Session::get('success') }}</p>
	</div>
@endif
@if(Session::has('errors'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p>{{ Session::get('errors') }}</p>
    </div>
@endif
@if(Session::has('exist_product_code'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p>{{ Session::get('exist_product_code') }}</p>
    </div>
@endif