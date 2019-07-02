@extends('Theme::layouts.baseLayout')
    @section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Players</h4><a class="linkClass" href="{{ route('addPlayer') }}">Add new player</a>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr><th>ID</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr></thead>
                                <tbody>
                                    @foreach ($fetchPlayer as $value)
                                        <tr>
                                            <td>{{ $value['pid'] }}</td>
                                            <td>{{ $value['player_name'] }}</td>
                                            <td><a href="{{ route('editPlayer', ['p_slug' => $value['p_slug'], 'c_slug' => $value['c_slug'] ]) }}">edit</a> |
                                                <a href="{{ route('deletePlayer', ['id' => $value['pid']]) }}" onclick="if (!confirm('are you sure want to delete this player?')) return false;" >delete</a>
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