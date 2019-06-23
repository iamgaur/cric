@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">{{ $title }}</h4>
                                <a class="linkClass" href="{{ route('matchTeams') }}">Back to list</a>
                            </div>
                            <div class="content">
                                <form method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Match ID</label>
                                                <input type="text" class="form-control" placeholder="Match ID" value="{{ old('match_id', $matchTeams->match_id) }}" name="match_id" id="match_id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>First Team</label>
                                                <select class="form-control" name="first_team" id="first_team">
                                                    <option>Select First Team</option>
                                                        @foreach ($teamList as $id => $name)
                                                            <option {{ old('first_team', $matchTeams->first_team) == $id ? 'selected': null }}  value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Second Team</label>
                                                <select class="form-control" name="second_team" id="second_team">
                                                    <option>Select Second Team</option>
                                                        @foreach ($teamList as $id => $name) 
                                                            <option {{ old('second_team', $matchTeams->second_team) == $id ? 'selected': null }} value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-info btn-fill pull-right" />
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
