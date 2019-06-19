@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Countries</h4><a class="linkClass" href="{{route('addCountry')}}">Add new country</a>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>ID</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr></thead>
                                    <tbody>
                                        @foreach ($fetchCountry as $value)
                                            <tr>
                                                <td>{{ $value['id'] }}</td>
                                                <td>{{ $value['name'] }}</td>
                                                <td><a href="{{ route('editCountry', ['name' => $value['name'], 'id' => $value['id']]) }}">edit</a> |
                                                    <a href="{{ route('deleteCountry', ['id' => $value['id']]) }}" onclick="if (!confirm('are you sure want to delete country?')) return false;" >delete</a></td>
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