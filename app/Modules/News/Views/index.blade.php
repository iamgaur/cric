@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">News</h4><a class="linkClass" href="{{ route('addNews') }}">Add news</a>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>ID</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr></thead>
                                    <tbody>
                                        @foreach ($fetchNews as $value)
                                            <tr>
                                                <td>{{ $value['id'] }}</td>
                                                <td>{{ $value['title'] }}</td>
                                                <td><a href="{{ route('editNews', ['slug' => $value['slug']]) }}">edit</a> |
                                                    <a href="{{ route('deleteNews', ['slug' => $value['slug']]) }}" onclick="if (!confirm('are you sure want to delete this news?')) return false;" >delete</a></td>
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