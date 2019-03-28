@extends ('Layout.default')

@section('content')

	<div class="col-md-12">

		<h1 class="page-header">{{ $title }}</h1>

		{{--Quickstart--}}

		<div class="row">
			<div class="col-md-12">
				@include('ticketsystem::widgets.quickstart')
			</div>
		</div>
	</div>
	
@stop
