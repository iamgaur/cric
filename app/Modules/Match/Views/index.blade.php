@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Matches</h4><a class="linkClass" href="{{ route('addMatch') }}">Add new match</a>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>Match ID</th>
                                            <th>Series ID</th>
                                            <th>Between</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr></thead>
                                    <tbody>
                                        
                                        @foreach ($fetchMatches as $value)
                                            <tr>
                                                <td>{{ $value['id'] }}</td>
                                                <td>{{ $value['series']['name'] }}</td>
                                                <td>{{ $value['match_title'] }}</td>
                                                <td>{{ date('Y-m-d', strtotime($value['match_date'])) }}</td>
                                                <td><a href="{{ route('editMatch', ['slug' => $value['slug']]) }}">edit</a> |
                                                    <a href="{{ route('deleteMatch', ['slug' => $value['slug']]) }}" onclick="if (!confirm('are you sure want to delete this match?')) return false;" >delete</a></td>
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