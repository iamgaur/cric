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
	<li class="{{ in_array($currentRouteName, ['countries', 'addCountry', 'editCountry']) ? 'active' : ''}}">
		<a href="{{ route('countries') }}">
			<p>Country</p>
		</a>
	</li>
	<li class="{{ in_array($currentRouteName, ['teams', 'addTeam','editTeam']) ? 'active' : ''}}">
		<a href="{{ route('teams') }}">
			<p>Team</p>
		</a>
	</li>
	<li class="{{ in_array($currentRouteName, ['series', 'addSeries', 'editSeries']) ? 'active' : ''}}">
		<a href="{{ route('series') }}">
			<p>Series</p>
		</a>
	</li>
	<li class="{{ in_array($currentRouteName, ['seriesSquads', 'addSeries', 'editSeries']) ? 'active' : ''}}">
		<a href="{{ route('seriesSquads') }}">
			<p>Series Squads</p>
		</a>
	</li>
	<li class="{{ in_array($currentRouteName, ['matches', 'addMatch', 'editMatch']) ? 'active' : ''}}">
		<a href="{{ route('matches') }}">
			<p>Match</p>
		</a>
	</li>
        <li class="{{ in_array($currentRouteName, ['matchTeams', 'addMatchTeams', 'editMatchTeams']) ? 'active' : ''}}">
            <a href="{{ route('matchTeams') }}">
                <p>Match -- Teams</p>
            </a>
        </li>
        <li class="{{ in_array($currentRouteName, ['matchSquads', 'editMatchSquad']) ? 'active' : ''}}">
            <a href="{{route('matchSquads')}}">
                <p>Match -- Squad</p>
            </a>
        </li>
	<li class="{{ in_array($currentRouteName, ['players', 'addPlayer', 'editPlayer']) ? 'active' : ''}}">
		<a href="{{ route('players') }}">
			<p>Player</p>
		</a>
	</li>
	<li class="{{ in_array($currentRouteName, ['iccRanking', 'addIccRanking', 'editIccRanking']) ? 'active' : ''}}">
		<a href="{{ route('iccRanking') }}">
			<p>Icc Ranking</p>
		</a>
	</li>
	<li class="{{ in_array($currentRouteName, ['news', 'addNews', 'editNews']) ? 'active' : ''}}">
		<a href="{{ route('news') }}">
			<p>News</p>
		</a>
	</li>
	<li class="{{ in_array($currentRouteName, ['gallery', 'addGallery', 'editGallery']) ? 'active' : ''}}">
		<a href="{{ route('gallery') }}">
			<p>Gallery</p>
		</a>
	</li>
	<li class="{{ ($currentRouteName == 'logout') ? 'active' : ''}}">
		<a href="{{ route('logout') }}">
			<p>Logout</p>
		</a>
	</li>

</ul>