@extends('admin.layout')

@section('pageHeader')
	<div class="row">
		<div class="col-lg-12">
		<h1>Translate</h1>
			<ol class="breadcrumb">
				<li><a href="index.html"><i class="icon-dashboard"></i> Languages</a></li>
				<li><a href="index.html"><i class="icon-dashboard"></i> Statistics</a></li>
			</ol>
		</div>
	</div>
@stop

@section('content')

	<div class="row">
		<div class="col-lg-10 col-md-offset-1">
			<form role="form" action="{{ $formAction }}" method="POST">
				<div class="form-group">
					<label>Key</label>
					<input class="form-control" value="{{ $primaryMessage->key }}" disabled>
				</div>

				<div class="form-group">
					<label>{{ $localePrimary->regional_name }}</label>
					<textarea class="form-control" rows="6" disabled>{{ $primaryMessage->message }}</textarea>
				</div>

				<div class="form-group">
					<label>{{ $localeSecondary->regional_name }}</label>
					<textarea class="form-control" name="message" rows="6">{{ $secondaryMessage ? $secondaryMessage->message : '' }}</textarea>
					<p class="help-block">This is where your translation goes.</p>
				</div>

				<button type="submit" class="btn btn-danger">Save translation</button>
				<button type="submit" class="btn btn-success">Next untranslated</button>
			</form>
		</div>
	</div>

@stop