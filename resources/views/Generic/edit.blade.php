@extends ('Layout.split')

@if (!isset($own_top))
	@section('content_top')

		{{ $link_header }}

	@stop
@endif


@section('content_left')

	{{ Form::model($view_var, array('route' => array($form_update, $view_var->id), 'method' => 'put', 'files' => true)) }}

		@include($form_path, $view_var)

	{{ Form::close() }}

@stop

<?php $api = App\Http\Controllers\BaseViewController::get_view_has_many_api_version($relations) ?>

@section('content_right')

	@foreach($relations as $view => $relation)

		<?php if (!isset($i)) $i = 0; else $i++; ?>

		<!-- The section content for the new Panel -->
		@section("content_$i")

			<!-- old API: directly load relation view. NOTE: old API new class var was view -->
			@if ($api == 1)
				@include('Generic.relation', [$relation, 'class' => $view, 'key' => strtolower($view_var->table).'_id'])
			@endif

			<!-- new API: parse data -->
			@if ($api == 2)
				@if (is_array($relation))

					<!-- include pure HTML -->
					@if (isset($relation['html']))
						{{$relation['html']}}
					@endif

					<!-- include a view -->
					@if (isset($relation['view']))
						@include ($relation['view'])
					@endif

					<!-- include a relational class/object/table, like Contract->Modem -->
					@if (isset($relation['class']) && isset($relation['relation']))
						@include('Generic.relation', ['relation' => $relation['relation'], 'class' => $relation['class'], 'key' => strtolower($view_var->table).'_id'])
					@endif

				@endif
			@endif

		@stop


		<!-- The Bootstap Panel to include -->
		@include ('bootstrap.panel', array ('content' => "content_$i",
											'view_header' => \App\Http\Controllers\BaseViewController::translate("Assigned").' '.\App\Http\Controllers\BaseViewController::translate($view),
											'md' => 3))

	@endforeach

@stop

