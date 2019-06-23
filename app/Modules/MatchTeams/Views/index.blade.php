@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Match with teams</h4><a class="linkClass" href="{{ route('addMatchTeams') }}">Add new match teams</a>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>Match ID</th>
                                            <th>First Team</th>
                                            <th>Second Team</th>
                                            <th>Action</th>
                                        </tr></thead>
                                    <tbody>
                                        @foreach ($fetchMatchTeams as $value)
                                            <tr>
                                                <td>{{ $value['match_id'] }}</td>
                                                <td>{{ $teamList[$value['first_team']] }}</td>
                                                <td>{{ $teamList[$value['second_team']] }}</td>
                                                <td><a href="{{ route('editMatchTeams', ['id' => $value['id']]) }}">edit</a> |
                                                    <a href="{{ route('deleteMatchTeams', ['id' => $value['id']]) }}" onclick="if (!confirm('are you sure want to delete this team match?')) return false;" >delete</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection