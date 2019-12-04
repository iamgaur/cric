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
                            @if(count($teamType))
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>ID</th>
                                            <th>Type Name</th>
                                        </tr></thead>
                                    <tbody>
                                       @foreach ($teamType as $key => $value)

                                            <tr>
                                              <td>{{ $key }}</td>
                                              <td>{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                            <div class="content">
                                <form method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Team Type name" name="name">
                                            </div>
                                        </div>
                                    </div>

                                    <input type="submit"  class="btn btn-info btn-fill pull-right" />
                                    <div class="clearfix"></div>
                                </form>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
