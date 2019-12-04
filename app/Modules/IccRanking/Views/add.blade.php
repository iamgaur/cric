@extends('Theme::layouts.baseLayout')
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">{{ $title }}</h4>
                        <a class="linkClass" href="{{ route('iccRanking') }}">Back to list</a>
                    </div>
                    <div class="content">
                        <form  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Select Icc Ranking type for:</label>
                                    <div class="form-group">
                                        @foreach(config('constants.ranking_type') as $key => $value)
                                            <label class="radio-inline">
                                                <input class="ranking-type" type="radio" value="{{ $value }}" name="ranking_type" {{ (old('ranking_type', $opted) == $value) ? 'checked' : null }}>{{ $key }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Select Gender:</label>
                                    <div class="form-group">
                                        @foreach(config('constants.gender') as $key => $value)
                                            <label class="radio-inline">
                                                <input class="gender-type" type="radio" value="{{ $key }}" name="gender" {{ (old('gender', $optedGender) == $key) ? 'checked' : null }}>{{ $value }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @foreach(config('constants.ranking_type')  as $key => $value)
                                <div class="row item_id {{ (old('ranking_type', $opted) != $value) ? 'hidden': null}}" id="{{ $value }}">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="{{ $key }}">Select {{ $key }}:</label>
                                            <select name="item_id[{{ $value }}]" class="form-control" id="{{ $key }}">
                                                <option value="">Select {{ $key }}</option>
                                                @foreach($rankingTypes[strtolower($key)] as $id => $name)
                                                    <option {{ old('item_id.'. $value, $iccRanking->item_id) == $id ? 'selected' : null }} value={{ $id }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                            @endforeach
                            <div class="row team category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>T20 RATING</label>
                                        <input type="number" class="form-control" placeholder="T20 Rating" value="{{ old('t20_rating', $iccRanking->t20_rating ) }}" name="t20_rating" id="t20_rating">
                                    </div>
                                </div>
                            </div>
                            <div class="row team category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ODI RATING</label>
                                        <input type="number" class="form-control" placeholder="ODI Rating" value="{{ old('odi_rating', $iccRanking->odi_rating ) }}" name="odi_rating" id="odi_rating">
                                    </div>
                                </div>
                            </div>
                            <div class="row team category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>TEST RATING</label>
                                        <input type="number" class="form-control" placeholder="TEST Rating" value="{{ old('test_rating', $iccRanking->test_rating ) }}" name="test_rating" id="test_ranking">
                                    </div>
                                </div>
                            </div>
                            <div class="row player category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>T20 BATING RATING</label>
                                        <input type="number" class="form-control" placeholder="T20 BATING RATING" value="{{ old('t20_batting_rating', $iccRanking->t20_batting_rating ) }}" name="t20_batting_rating" id="t20_batting_rating">
                                    </div>
                                </div>
                            </div>
                            <div class="row player category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>T20 BOWLING RATING</label>
                                        <input type="number" class="form-control" placeholder="T20 BOWLING RATING" name="t20_bowling_rating" value="{{ old('odi_bowling_rating', $iccRanking->t20_bowling_rating ) }}" id="t20_bowling_rating">
                                    </div>
                                </div>
                            </div>
                            <div class="row player category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>T20 ALL ROUNDER RATING</label>
                                        <input type="number" class="form-control" placeholder="T20 ALL ROUNDER RATING" value="{{ old('t20_all_rounder_rating', $iccRanking->t20_all_rounder_rating) }}" name="t20_all_rounder_rating" id="t20_all_rounder_rating">
                                    </div>
                                </div>
                            </div>
                             <div class="row player category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ODI BATING RATING</label>
                                        <input type="number" class="form-control" placeholder="ODI BATING RATING" value="{{ old('odi_batting_rating', $iccRanking->odi_batting_rating ) }}" name="odi_batting_rating" id="odi_batting_rating">
                                    </div>
                                </div>
                            </div>
                            <div class="row player category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ODI BOWLING RATING</label>
                                        <input type="number" class="form-control" placeholder="ODI BOWLING RATING" name="odi_bowling_rating" value="{{ old('odi_bowling_rating', $iccRanking->odi_bowling_rating ) }}" id="odi_bowling_ranking">
                                    </div>
                                </div>
                            </div>
                            <div class="row player category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ODI ALL ROUNDER RATING</label>
                                        <input type="number" class="form-control" placeholder="ODI ALL ROUNDER RATING" value="{{ old('odi_all_rounder_rating', $iccRanking->odi_all_rounder_rating) }}" name="odi_all_rounder_rating" id="odi_all_rounder_rating">
                                    </div>
                                </div>
                            </div>
                             <div class="row player category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>TEST BATING RATING</label>
                                        <input type="number" class="form-control" placeholder="TEST BATING RATING" value="{{ old('test_batting_rating', $iccRanking->test_batting_rating ) }}" name="test_batting_rating" id="test_batting_rtking">
                                    </div>
                                </div>
                            </div>
                            <div class="row player category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>TEST BOWLING RATING</label>
                                        <input type="number" class="form-control" placeholder="TEST BOWLING RATING" name="test_bowling_rating" value="{{ old('test_bowling_rating', $iccRanking->test_bowling_rating ) }}" id="test_bowling_rating">
                                    </div>
                                </div>
                            </div>
                            <div class="row player category">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>TEST ALL ROUNDER RATING</label>
                                        <input type="number" class="form-control" placeholder="TEST ALL ROUNDER RATING" value="{{ old('test_all_rounder_rating', $iccRanking->test_all_rounder_rating) }}" name="test_all_rounder_rating" id="test_all_rounder_rating">
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
    $(function () {
        var category = getCategory($('.ranking-type:checked').val());
        $('.category').addClass('hidden');
        $('.' + category).removeClass('hidden');
        $(document.body).on('click', '.ranking-type', function() {
            var category = getCategory($(this).val());
            $('.item_id, .category').addClass('hidden');
            $('#' + $(this).val() + ', .' + category).removeClass('hidden');
        });
    });

    function getCategory(swtichTo) {
        var category = 'empty';
        switch(swtichTo) {
               case '1':
                   category = 'team';
                   break;
               case '2':
                   category = 'player';
                   break;
        }
        return category;
    }
</script>
@endpush