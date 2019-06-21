@extends('Theme::layouts.baseLayout')
    @section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">{{ $title }}</h4>
                            <a class="linkClass" href=" {{ route('teams') }}">Back to list</a>
                        </div>
                        <div class="content">
                            <form method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Team name" value="{{ old('name', $team->name) }}" name="name" id="team_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Short name</label>
                                            <input type="text" class="form-control" placeholder="Short name" value="{{ old('short_name', $team->short_name) }}" name="short_name" id="short_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <select class="form-control" name="team_country" id="team_country">
                                                @foreach ($countries as $country_id => $name)
                                                   <option {{ old('team_country', $team->short_name) == $country_id ? 'selected' : null }} value="{{ $country_id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select class="form-control" name="team_type" id="team_type">
                                                <option {{ old('team_type', $team->team_type) == 1 ? 'selected' : null }} value="1">{{ config('constants.team_type.1') }}</option>
                                                <option {{ old('team_type', $team->team_type) == 2 ? 'selected' : null }} value="2">{{ config('constants.team_type.2') }}</option>
                                                <option {{ old('team_type', $team->team_type) == 3 ? 'selected' : null }} value="3">{{ config('constants.team_type.3') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Meta title</label>
                                            <input type="text" class="form-control" placeholder="Meta title" name="meta_title" value="{{ old('meta_title', $team->meta_title) }}" id="meta_title">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Meta description</label>
                                            <input type="text" class="form-control" placeholder="Meta description" name="meta_description" value="{{ old('meta_description', $team->meta_description) }}" id="meta_description">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Meta keywords</label>
                                            <input type="text" class="form-control" placeholder="Meta keywords" name="meta_keywords" value="{{ old('meta_keywords', $team->meta_keywords) }}" id="meta_keywords">
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