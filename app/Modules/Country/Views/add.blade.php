@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">{{ $title }}</h4>
                                <a class="linkClass" href="{{ route('countries') }}">Back to list</a>
                            </div>
                            <div class="content">
                                <form method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" value="{{ old('name', $country->name) }}" placeholder="Country name" name="name" id="country">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta title</label>
                                                <input type="text" class="form-control" placeholder="Meta title" value="{{ old('meta_title', $country->meta_title ) }}" name="meta_title" id="meta_title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta description</label>
                                                <input type="text" class="form-control" placeholder="Meta description" name="meta_description" value="{{ old('meta_description', $country->meta_description ) }}" id="meta_description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta keywords</label>
                                                <input type="text" class="form-control" placeholder="Meta keywords" value="{{ old('meta_keywords', $country->meta_keywords) }}" name="meta_keywords" id="meta_keywords">
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