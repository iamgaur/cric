@php
    $currentRouteName = strlen(Route::currentRouteName()) ? Route::currentRouteName() : null;
@endphp

<ul class="nav">
	<li class="{{ ($currentRouteName == 'dashboard') ? 'active' : ''}}">
		<a href="{{ route('dashboard') }}">
			<i class="pe-7s-graph"></i>
			<p>Dashboard</p>
		</a>
	</li>
	<li class="{{ ($currentRouteName == 'countries') ? 'active' : ''}}">
		<a href="{{ route('countries') }}">
			<p>Country</p>
		</a>
	</li>
	<li class="{{ ($currentRouteName == 'teams') ? 'active' : ''}}">
		<a href="{{ route('teams') }}">
			<p>Team</p>
		</a>
	</li>
	<li class="{{ ($currentRouteName == 'series') ? 'active' : ''}}">
		<a href="#">
			<p>Series</p>
		</a>
	</li>
	<li class="{{ ($currentRouteName == 'match') ? 'active' : ''}}">
		<a href="#">
			<p>Match</p>
		</a>
	</li>
        <li class="{{ ($currentRouteName == 'matchteams') ? 'active' : ''}}">
            <a href="#">
                <p>Match -- Teams</p>
            </a>
        </li>
        <li class="{{ ($currentRouteName == 'matchsquad') ? 'active' : ''}}">
            <a href="#">
                <p>Match -- Squad</p>
            </a>
        </li>
	<li class="{{ ($currentRouteName == 'player') ? 'active' : ''}}">
		<a href="#">
			<p>Player</p>
		</a>
	</li>
	<li class="{{ ($currentRouteName == 'news') ? 'active' : ''}}">
		<a href="#">
			<p>News</p>
		</a>
	</li>
	<li class="{{ ($currentRouteName == 'gallery') ? 'active' : ''}}">
		<a href="#">
			<p>Gallery</p>
		</a>
	</li>
	<li class="{{ ($currentRouteName == 'logout') ? 'active' : ''}}">
		<a href="#">
			<p>Logout</p>
		</a>
	</li>

</ul>