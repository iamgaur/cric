@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Series Squad</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                         <tr>
                                            <th>Series Name</th>
                                            <th>Series Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listings as $value)
                                            <tr>
                                                <td>{{ $value['name'] }}</td>
                                                <td>{{ $value['type'] }}</td>
                                                <td>
                                                    <a href="{{ route('editSeriesSquad', ['slug' => $value['slug']]) }}">edit</a>
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