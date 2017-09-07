@extends ('Layout.single')

<head>

	<link href="{{asset('/modules/hfcbase/alert.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<script type="text/javascript" src="{{asset('/modules/hfcbase/alert.js')}}"></script>

	<script src="{{asset('/modules/hfcbase/OpenLayers-2.13.1/OpenLayers.js')}}"></script>
	<script src="https://maps.google.com/maps/api/js?v=3.2&sensor=false"></script>

	@include ('hfcbase::Tree.topo-api')

</head>



@section('content_top')
	Topography - Modems
@stop

@section('content_left')

	@include ('hfcbase::Tree.search')

		<ul class="nav nav-pills pull-right">
		<?php
			$par = Route::getCurrentRoute()->parameters();
			$cur_row = \Input::has('row') ? \Input::get('row') : 'us_pwr';
			foreach (['us_pwr' => 'US Power', 'us_snr' => 'US SNR', 'ds_pwr' => 'DS Power', 'ds_snr' => 'DS SNR'] as $key => $val) {
				$par['row'] = $key;
				$class = ($cur_row === $key) ? 'active' : '';
				echo("<li role=\"presentation\" class=\"$class\">".link_to_route(Route::getCurrentRoute()->getName(), $val, $par).'</li>');
			}
		?>
		</ul>

	<div class="col-md-12" id="map" style="height: 80%;"></div>
	<input type="radio" name="type" value="none" id="noneToggle" onclick="toggleControl(this);" checked="checked" />
	<label for="noneToggle">navigate</label>
	<input type="radio" name="type" value="box" id="boxToggle" onclick="toggleControl(this);" />
	<label for="boxToggle">draw box</label>
	<input type="radio" name="type" value="polygon" id="polygonToggle" onclick="toggleControl(this);" />
	<label for="polygonToggle">draw polygon</label>
	<input type="radio" name="type" value="modify" id="modifyToggle" onclick="toggleControl(this);" />
	<label for="polygonToggle">modify</label>
@stop

