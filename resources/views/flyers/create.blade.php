@extends('layout')

@section('content')
	<h1>Selling your home?</h1>

	<hr>	

	<form method="POST" enctype="multipart/form-data" action="/flyers">
		@include('flyers.form')

		@include ('errors')

	</form>
@stop