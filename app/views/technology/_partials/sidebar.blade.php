<p><a href="{{ URL::route('technology') }}/bio">{{g('Bio')}}</a></p>

<p><a href="{{ URL::route('technology') }}/php">{{g('PHP & Laravel')}}</a></p>

<p><a href="{{ URL::route('technology') }}/projects">{{g('Projects')}}</a></p>

<hr>

<p><a href="{{ URL::route('technology') }}">{{g('Recent Articles')}}</a></p>

@include('technology._partials.postsMonths')