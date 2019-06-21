@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Teams</h4><a class="linkClass" href="{{ route('addTeam') }}">Add new team</a>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>ID</th>
                                            <th>Name</th>
                                            <th>Short name</th>
                                            <th>Country</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr></thead>
                                    <tbody>
                                       @foreach ($fetchTeam as $value)

                                            <tr>
                                              <td>{{ $value['id'] }}</td>
                                              <td>{{ $value['name'] }}</td>
                                              <td>{{ $value['short_name'] }}</td>
                                              <td>{{ $value['country']['name'] }}</td>
                                              <td>{{ config('constants.team_type.' . $value['team_type']) }}</td>
                                              <td><a href="edit_team.php?edit_id=' . $value['id'] . '">edit</a> | delete</td>
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