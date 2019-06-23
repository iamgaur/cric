@extends('Theme::layouts.baseLayout')
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
        <script>
            $(function() {
                $('#start_date').datetimepicker({
                    format: 'YYYY-MM-DD'
                });
                $("#start_date").on("dp.change", function(e) {
                    var dt = new Date(e.date);
                    dt.setDate(dt.getDate() + 1);
                    $("#end_date").data("DateTimePicker").minDate(dt);
                });
                $("#end_date").on("dp.change", function(e) {
                    var dt = new Date(e.date);
                    
                    dt.setDate(dt.getDate() - 1);
                    $("#start_date").data("DateTimePicker").maxDate(dt);
                });
                $('#end_date').datetimepicker({
                    format: 'YYYY-MM-DD'
                });
            });
        </script>
    @endpush