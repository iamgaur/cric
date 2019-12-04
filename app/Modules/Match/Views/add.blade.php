@extends('Theme::layouts.baseLayout')
<style>

.modal-backdrop.in {
  display: none !important;
}
</style>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">{{ $title }}</h4>
                                <a class="linkClass" href="{{ route('matches') }}">Back to list</a>
                            </div>
                            <div class="content">
                                <form  method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Series</label>
                                                <select class="form-control" name="series_id" id="series_id">
                                                    <option value="">Select Series</option>
                                                    @foreach ($fetchSeries as $series_id => $value)
                                                        <option {{ old('series_id', $match->series_id) == $series_id ? 'selected' : null }} value="{{ $series_id }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Match title" value="{{ old ('match_title', $match->match_title) }}" name="match_title" id="match_title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Result</label>
                                                <input type="text" class="form-control" placeholder="Result" value="{{ old ('result', $match->result) }}" name="result" id="result">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="text" class="form-control" placeholder="Match date" name="match_date" value="{{ old ('match_date', $match->match_date) }}" id="match_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="text" class="form-control" placeholder="Match end date" name="match_end_date" value="{{ old ('match_end_date', $match->match__end_date) }}" id="match_end_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Player of match</label>
                                                <input type="text" class="form-control" placeholder="Player of match" value="{{ old ('player_of_match', $match->player_of_match) }}" name="player_of_match" id="player_of_match">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input type="text" class="form-control" placeholder="Location" value="{{ old ('location', $match->location) }}" name="location" id="location">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Stadium</label>
                                                <input type="text" class="form-control" placeholder="Stadium" value="{{ old ('stadium', $match->stadium) }}" name="stadium" id="stadium">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <input type="text" class="form-control" placeholder="Day / Day & Night or Night" value="{{ old ('match_type', $match->match_type) }}" name="match_type" id="type">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta title</label>
                                                <input type="text" class="form-control" placeholder="Meta title" value="{{ old ('meta_title', $match->meta_title) }}" name="meta_title" id="meta_title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta description</label>
                                                <input type="text" class="form-control" placeholder="Meta description" value="{{ old ('meta_description', $match->meta_description) }}" name="meta_description" id="meta_description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta keywords</label>
                                                <input type="text" class="form-control" placeholder="Meta keywords" value="{{ old ('meta_keywords', $match->meta_keywords) }}" name="meta_keywords" id="meta_keywords">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>New match time</label>
                                                <input type="text" class="form-control" placeholder="New match time" value="{{ old ('new_match_time', $match->new_match_time) }}" name="new_match_time" id="match_title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Umpires</label>
                                                <input type="text" class="form-control" placeholder="Umpires" value="{{ old ('umpires', $match->umpires) }}" name="umpires" id="umpires">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Third Umpire</label>
                                                <input type="text" class="form-control" placeholder="Third Umpire" value="{{ old ('third_umpire', $match->third_umpire) }}" name="third_umpire" id="third_umpire">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Match Referee</label>
                                                <input type="text" class="form-control" placeholder="Match Referee" value="{{ old ('match_referee', $match->match_referee) }}" name="match_referee" id="match_referee">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Toss</label>
                                                <input type="text" class="form-control" placeholder="Toss" value="{{ old ('toss', $match->toss) }}" name="toss" id="toss">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About Match</label>
                                                <textarea id="editor" name="about_match_html">{{ old('about_match_html', $match->about_match_html) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    @foreach($group_fields as $heading => $group) 
                                        <div class="group-field">
                                            <div class="heading">
                                                <h3>{{ $heading }}</h3>
                                                <input type="hidden" value="{{ $group['heading'] }}" name="group[{{ $group['heading'] }}][heading]">
                                                <div class="sub-field">
                                                    @foreach($group['fields'] as $title => $field)
                                                        <div style="margin-bottom: 45px;" class="sub-field-title">
                                                            <label><strong>{{ $title }}</strong></label>
                                                            <input class="col-md-12" type="text" value="{{ $field }}" name="group[{{ $group['heading'] }}][fields][{{ $title }}]">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

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
        <script>
            $(function() {
                $('#match_date, #match_end_date').datetimepicker({
                    format: 'YYYY-MM-DD'
                });
                $('#editor').summernote({
                  height: 500,
                });
            });
        </script>
    @endpush
