@extends('layouts.app')

@section('content')
<div class="container-fluid container-err">
	<div class="row row-err">
		<div class="col-md-4 home-ico">
			<span class="glyphicon glyphicon-home home-ico" aria-hidden="true"></span>
		</div>
	</div>
	<div class="row row-err">
		<div class="col-md-4 er-txt-p">
			<h1 class="er-txt">Страница не найдена</h1>
		</div>
	</div>
	<div class="row row-err">
		<div class="col-md-4 er-txt-404-p">
			<p class="er-txt-404">Страница устарела, была удалена или не существовала вовсе</p>
		</div>
	</div>
	<div class="row row-err">
		<div class="col-md-4">
			<a href="{{ url('/') }}" class="btn btn-default btn-lg home-link">
			  	 Вернуться на главную
			</a>
		</div>
	</div>
</div>
@endsection