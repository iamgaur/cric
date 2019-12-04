@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Series</h4><a class="linkClass" href="{{ route('addSeries') }}">Add new series</a>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>ID</th>
                                            <th>Name</th>
                                            <th>Start date</th>
                                            <th>End date</th>
                                            <th>Action</th>
                                        </tr></thead>
                                    <tbody>
                                        @foreach ($fetchSeries as $value)
                                            <tr>
                                                <td>{{ $value['id'] }}</td>
                                                <td>{{ $value['name'] }}</td>
                                                <td>{{ date('Y-m-d', strtotime($value['series_start_date'])) }}</td>
                                                <td>{{ date('Y-m-d', strtotime($value['series_end_date'])) }}</td>
                                                <td><a href="{{ route('editSeries', ['slug' => $value['slug'] ]) }}">edit</a> |
                                                  <a href="{{ route('pointTable', ['slug' => $value['slug'] ]) }}">Add Points</a> |
                                                     <a href="{{ route('deleteSeries', ['slug' => $value['slug']]) }}" onclick="if (!confirm('are you sure want to delete this series?')) return false;" >delete</a></td>
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
