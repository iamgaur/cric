@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Match Team Squad</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                         <tr>
                                            <th>Match ID</th>
                                            <th>First Team</th>
                                            <th>Second Team</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fetchMatchSquads as $value)
                                            <tr>
                                                <td>{{ $value['match_id'] }}</td>
                                                <td>{{ $value['firstTeam_name'] }}</td>
                                                <td>{{ $value['secondTeam_name'] }}</td>
                                                <td>
                                                    <a href="{{ route('editMatchSquad', ['slug' => $value['slug']]) }}">edit</a> |
                                                    <a href="{{ route('deleteMatchSquad', ['slug' => $value['slug']]) }}" onclick="if (!confirm('are you sure want to delete this match?')) return false;" >delete</a>
                                                </td>
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