<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">Reports and Charts</div>
			<div class="panel-body">
				<div class="bs-example">
					<ul class="nav nav-pills">
						<li {{ Session::get('tracker.page') == 'main' ? 'class="active"' : '' }}>
							<a href="{{URL::route('admin.tracker.index')}}?page=main">Visits</a>
						</li>

						<li {{ Session::get('tracker.page') == 'summary' ? 'class="active"' : '' }}>
							<a href="{{URL::route('admin.tracker.index')}}?page=summary">Page Views Summary</a>
						</li>

						<li {{ Session::get('tracker.page') == 'users' ? 'class="active"' : '' }}>
							<a href="{{URL::route('admin.tracker.index')}}?page=users">Users</a>
						</li>

						<li {{ Session::get('tracker.page') == 'events' ? 'class="active"' : '' }}>
							<a href="{{URL::route('admin.tracker.index')}}?page=events">Events</a>
						</li>

						<li {{ Session::get('tracker.page') == 'errors' ? 'class="active"' : '' }}>
							<a href="{{URL::route('admin.tracker.index')}}?page=errors">Errors</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">Period</div>
			<div class="panel-body">
					<div class="bs-example">
						<ul class="nav nav-pills">
							<li {{ Session::get('tracker.days') == '1' ? 'class="active"' : '' }}>
								<a href="{{URL::route('admin.tracker.index')}}?days=1">1 day</a>
							</li>

							<li {{ Session::get('tracker.days') == '7' ? 'class="active"' : '' }}>
								<a href="{{URL::route('admin.tracker.index')}}?days=7">7 days</a>
							</li>

							<li {{ Session::get('tracker.days') == '30' ? 'class="active"' : '' }}>
								<a href="{{URL::route('admin.tracker.index')}}?days=30">30 days</a>
							</li>

							<li {{ Session::get('tracker.days') == '365' ? 'class="active"' : '' }}>
								<a href="{{URL::route('admin.tracker.index')}}?days=365">1 year</a>
							</li>
						</ul>
					</div>
			</div>
		</div>
	</div>
</div>

<br>
