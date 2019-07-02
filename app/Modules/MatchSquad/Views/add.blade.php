@extends('Theme::layouts.baseLayout')
    @section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="header">
                            <h4 class="title">Add Players for This Match</h4>
                            <a class="linkClass" href="{{ route('matchSquads') }}">Back to list</a>
                        </div>
                        <div class="content">
                            <form method="post">
                                @csrf
                                <input type="hidden" value="{{ $matchSquad->match_id }}" name="match_id">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Match ID : {{ $matchSquad->match_id }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ $matchSquad->first_team_name }}</label>
                                            <!--<input type="text" class="form-control teamA" data-src="teamA" data-team="" placeholder="Match ID" name="playerID" id="match_id">-->
                                            <div id="teamA">
                                                <ul  class="list-group" >
                                                    @foreach ($firstTeamPlayers as $data)
                                                        <li class="teamlisting list-group-item" id="player1">
                                                            <input  type="checkbox" name="teamA[]" value="{{ $data->pid }}" {{ isset($firstTeamSelectedPlayers[$data->pid]) ? 'checked' : '' }}>
                                                            {{ $data->player_name }}
                                                        </li>
                                                    @endforeach
                                                </ul>	
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ $matchSquad->second_team_name}}</label>
                                            <!--<input type="text" class="form-control teamB" placeholder="Match ID" data-src="teamB" data-team="" name="playerID" id="match_id">-->
                                            <div id="teamB">
                                                <ul class="list-group">
                                                    @foreach ($secondTeamPlayers as $data)
                                                        <li class="teamlisting list-group-item" id="player2">
                                                            <input type="checkbox" name="teamB[]" value="{{ $data->pid }}" {{ isset($secondTeamSelectedPlayers[$data->pid]) ? 'checked' : '' }}>
                                                            {{ $data->player_name }}
                                                        </li>
                                                    @endforeach
                                                </ul>	
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-info btn-fill pull-right" />
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @push('scripts')
        <script>
            $(function() {
                $('#match_date').datetimepicker({
                    format: 'YYYY-MM-DD'
                });
            });
        </script>
    @endpush