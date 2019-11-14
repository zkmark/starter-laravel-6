@if(Session::has('error') )
<div class="alert alert-danger">
	{{Session::get('error')}}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif