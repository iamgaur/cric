@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Teams</h4><a class="linkClass" href="{{ route('addTeam') }}">Add new team</a> &nbsp | &nbsp
                                <a class="linkClass" href="{{ route('getType') }}">Add new type</a>
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
                                              <td>{{ ($teamType[$value['team_type']]) }}</td>
                                              <td><a href="{{ route('editTeam', ['slug' => $value['slug']]) }}">edit</a> |
                                                  <a href="{{ route('deleteTeam', ['slug' => $value['slug']]) }}" onclick="if (!confirm('are you sure want to delete team?')) return false;" >delete</a></td>
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
