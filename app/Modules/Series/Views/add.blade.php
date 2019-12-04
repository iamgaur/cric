@extends('Theme::layouts.baseLayout')
<style>

.modal-backdrop.in {
  display: none !important;
}
</style>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">{{ $title }}</h4>
                                <a class="linkClass" href="{{ route('series') }}">Back to list</a>
                            </div>
                            <div class="content">
                                <form  method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Series name"  value="{{ old('name', $series->name) }}" name="name" id="series_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select class="form-control" name="gender"> 
                                                    <option value="">Select Gender</option>
                                                    @foreach(config('constants.series_gender_type') as $key => $value)
                                                        <option {{ old('gender', $series->gender) == $key ? 'selected' : null }} value="{{ $key }}">{{ ucwords($value) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Start date</label>
                                                <input type="text" class="form-control" placeholder="Start date"  value="{{ old('series_start_date', $series->series_start_date) }}" name="series_start_date" id="start_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>End date</label>
                                                <input type="text" class="form-control" placeholder="End date"  value="{{ old('series_end_date', $series->series_end_date) }}" name="series_end_date" id="end_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" name="status" id="status">
                                                    <option {{ old('status', $series->status) === 1 ? 'selected' : null }} value="1">{{ config('constants.series_status.current') }}</option>
                                                    <option {{ old('status', $series->status) === 0 ? 'selected' : null }} value="0">{{ config('constants.series_status.past') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta title</label>
                                                <input type="text" class="form-control" placeholder="Meta title" value="{{ old('meta_title', $series->meta_title) }}" name="meta_title" id="meta_title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta description</label>
                                                <input type="text" class="form-control" placeholder="Meta description" value="{{ old('meta_description', $series->meta_description) }}" name="meta_description" id="meta_description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta keywords</label>
                                                <input type="text" class="form-control" placeholder="Meta keywords"  value="{{ old('meta_keywords', $series->meta_keywords) }}" name="meta_keywords" id="meta_keywords">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Format Type</label>
                                                <select class="form-control" multiple="multiple" name="format_type[]" id="format_type">
                                                  @foreach ($formatType as $key => $value)
                                                    <option {{ in_array($key, old('format_type', explode(',', $series->format_type))) ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About Series</label>
                                                <textarea id="editor" name="about_series_html">{{ old('about_series_html', $series->about_series_html) }}</textarea>
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
    @push('scripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
        <script>
            $(function() {
                $('#start_date').datetimepicker({
                    format: 'YYYY-MM-DD'
                });

                $('#end_date').datetimepicker({
                    format: 'YYYY-MM-DD'
                });

                $('#editor').summernote({
                  height: 500,
                });
                $('#format_type').select2();
            });
        </script>
    @endpush
