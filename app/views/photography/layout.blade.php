@extends('html')

@section('html-head')
	<title>Antonio Carlos Ribeiro - {{g('Photography')}}</title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type">
	<meta name="description" content="Antonio Carlos Ribeiro - Photography" />
	<meta name="keywords" content="javascript, dynamic, grid, layout, jquery plugin, fit zone"/>
	<link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/layouts/photography/css/style2.css') }}" />
	<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
	<script type='text/javascript' src='{{ asset('assets/layouts/photography/js/jquery.min.js') }}'></script>
	<script type="text/javascript" src="{{ asset('assets/vendor/bower/freewall/freewall.js') }}"></script>
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

	<script type='text/javascript' src="{{ asset('assets/vendor/bower/jquery/jquery.min.js') }}"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/shadowbox/3.0.3/shadowbox.css">
	<script type="text/javascript" src="https://cdn.jsdelivr.net/shadowbox/3.0.3/shadowbox.js"></script>
@stop

@section('html-body')
	<div class="header">
		<div class="translucid">
			<div class="menu">
				<div class="left">
					<h1><img class="photography-logo" src="{{ asset('assets/layouts/img/favicons') }}/favicon-32x32.png"> Antonio Carlos Ribeiro</h1>

					<ul class="filter-items alignLeft">
						<li class="filter-label active">{{g('All Photos')}}</li>

						@foreach($types as $type)
						<li>•</li><li class="filter-label" data-filter=".category-{{$type}}">{{g(ucwords($type))}}</li>
						@endforeach
					</ul>
				</div>

				<div class="right">
					<div class="icons">
						<a href="{{ URL::to('/') }}" title="{{ g('Go to main site') }}">
							<i class="fa fa-home icon"></i>
						</a>

						<a target="_blank" href="https://br.linkedin.com/in/iantonioribeiro/" title="Linkedin">
							<i class="fa fa-linkedin icon"></i>
						</a>

						<a target="_blank" href="http://github.com/antonioribeiro" title="Github">
							<i class="fa fa-github icon"></i>
						</a>

						<a target="_blank" href="http://twitter.com/iantonioribeiro" title="Twitter">
							<i class="fa fa-twitter icon"></i>
						</a>

						<a target="_blank" href="http://stackoverflow.com/users/1959747/antonio-carlos-ribeiro" title="StackOverflow">
							<i class="fa fa-stack-overflow icon"></i>
						</a>

						<a href="{{ $switchLanguageUrl }}" title="{{ $switchLanguageHint }}">
							<img class="icon" src="{{ asset('assets/custom/img/'.$switchLanguageFlag.'-bw.png') }}">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="layout">
		<div id="freewall" class="free-wall">
			@foreach($photos as $key => $photo)
				<div class="brick size{{$photo['size']}} category-all category-{{$photo['type']}}">
					<div class="img-container" data-original="{{$photo['photography']}}">
						<img class="photo fancybox" src="{{$photo['thumbnail']}}" />
						<div class="imageOverlay"><i class="fa fa-picture-o"></i></div>
					</div>
				</div>
			@endforeach
		</div>
	</div>

	<script type="text/javascript">
		Shadowbox.init({
			skipSetup: true,
			players: ["img"]
		});

		jQuery(document).ready(function()
		{
			jQuery('div.img-container').on('click', function()
			{
				Shadowbox.open({
					content: jQuery(this).attr('data-original'),
					player: 'img'
				});

				console.log('show!');
			});

			jQuery('div.img-container').on('touchstart', function()
			{
				showPicture = true;
			});

			jQuery('div.img-container').on('touchend', function()
			{
				if(showPicture)
				{
					Shadowbox.open({
						content: jQuery(this).attr('data-original'),
						player: 'img'
					});

					return false;
				}
			});

			jQuery('div.img-container').on('touchmove', function()
			{
				showPicture = false;
			});

			jQuery(window).on('mousemove', function()
			{
				jQuery('body').attr('rel', Math.random());
			});
		});

		jQuery(function() {
			var wall = new freewall("#freewall");

			wall.reset({
				selector: '.brick',
				animate: true,
				cellW: 163,
				cellH: 160,
				fixSize: 0,
				onResize: function() {
					wall.refresh();
				}
			});

			jQuery(".filter-label").click(function() {
				jQuery(".filter-label").removeClass("active");
				var filter = jQuery(this).addClass('active').data('filter');
				if (filter) {
					wall.filter(filter);
				} else {
					wall.unFilter();
				}
			});

			wall.fitWidth();
		});
	</script>
@stop
