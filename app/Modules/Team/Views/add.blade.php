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
                            <form method="post" enctype="multipart/form-data">
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
                                            <select class="form-control" name="country_id" id="team_country">
                                                @foreach ($countries as $country_id => $name)
                                                   <option {{ old('country_id', $team->country_id) == $country_id ? 'selected' : null }} value="{{ $country_id }}">{{ $name }}</option>
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
                                              @foreach($teamType as $type_id => $type_value)
                                              <option {{ old('country_id', $team->team_type) == $type_id ? 'selected' : null }} value="{{ $type_id }}">{{ $type_value }}</option>
                                              @endforeach

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

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                          <input type="file" id="file1" class="form-control" value="{{ old('image', $team->image) }}" name="image" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Alt Tag</label>
                                            <input type="text" class="form-control" value="{{ old('alt_tag', $team->alt_tag) }}" placeholder="Image Alt Tag" name="alt_tag" id="alt_tag">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Image Title</label>
                                            <input type="text" class="form-control" value="{{ old('image_title', $team->image_title) }}" placeholder="Image Alt Tag" name="image_title" id="image_title">
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
