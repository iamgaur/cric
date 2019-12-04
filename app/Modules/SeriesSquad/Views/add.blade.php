@extends('Theme::layouts.baseLayout')
<style>
    .float-right-with-pointer {
        float:right;
        cursor: pointer;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    @section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="header">
                            <h4 class="title">{{$title}}</h4>
                            <a class="linkClass" href="{{ route('seriesSquads') }}">Back to list</a>
                        </div>
                        <div class="content">
                            <form method="post">
                                @csrf
                                <input type="hidden" value="{{ $seriesSquad['slug'] }}" name="series_squad_slug">
                                @if (empty($seriesSquad['json']))
                                    <fieldset  class="series-squad-info">
                                        <legend><span class="number">Group 1</span>
                                            <span class="pe-7s-plus add-more float-right-with-pointer"></span>
                                            <span class="pe-7s-less delete-this float-right-with-pointer"></span>
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Team</label>
                                                    <select name="series_squad[0][team]" class="series_squad_team  w-full">
                                                        <option value="">Select Team</option>
                                                        @foreach ($fetchTeam as $team)
                                                            <option {{old('series_squad.0.team') == $team['id'] ? 'selected' : null }} value="{{ $team['id'] }}">{{ $team['name'] }}</option>
                                                        @endforeach               
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row player">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Players</label>
                                                    <select class="w-full series_squad_players" multiple="multiple" name="series_squad[0][players][]" >
                                                        @foreach ($fetchPlayers as $key => $value)
                                                            <option {{ old('series_squad.'. 0 .'.players') }} value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row captain">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Captain</label>
                                                    <select class="w-full series_squad_captain" name="series_squad[0][captain]" >
                                                        @foreach ($fetchPlayers as $key => $value)
                                                            <option {{ old('series_squad.'. 0 .'.captain') }} value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row keeper">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>WicketKeeper</label>
                                                    <select class="series_squad_keeper w-full" name="series_squad[0][keeper]" >
                                                        @foreach ($fetchPlayers as $key => $value)
                                                            <option {{ old('series_squad.'. 0 .'.keeper') }} value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                @else
                                    @php $i = 0; @endphp
                                    @foreach($seriesSquad['entries'] as $entry)
                                    <fieldset class="series-squad-info">  
                                        <legend><span class="number">Group {{$i + 1}}</span>
                                            <span class="pe-7s-plus add-more float-right-with-pointer"></span>
                                            <span class="pe-7s-less delete-this float-right-with-pointer"></span>
                                        </legend>
                                        <div class="row  team">
                                            <div class="col-md-12 w-full">
                                                <div class="form-group">
                                                    <label>Team</label>
                                                    <select name="series_squad[{{$i}}][team]" class="w-full  series_squad_team">
                                                        <option value="">Select Team</option>
                                                        @foreach ($fetchTeam as $team)
                                                            <option {{old('series_squad.'. $i. '.team', $entry['team']) == $team['id'] ? 'selected' : null }} value="{{ $team['id'] }}">{{ $team['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row player">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Players</label>
                                                    <select class="series_squad_players w-full" multiple="multiple" name="series_squad[{{$i}}][players][]" >
                                                        @foreach ($fetchPlayers as $key => $value)
                                                            <option {{ in_array($key, old('series_squad.'. $i .'.players' ,  $entry['players'] )) ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row captain">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Captain</label>
                                                    <select class="series_squad_captain w-full" name="series_squad[{{$i}}][captain]" >
                                                        @foreach ($fetchPlayers as $key => $value)
                                                            <option {{ old('series_squad.'. $i .'.captain' ,  (isset($entry['captain']) ? $entry['captain'] : null) ) == $key ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row keeper">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>WicketKeeper</label>
                                                    <select class="series_squad_keeper w-full" name="series_squad[{{$i}}][keeper]" >
                                                        @foreach ($fetchPlayers as $key => $value)
                                                            <option {{ old('series_squad.'. $i .'.keeper' ,  (isset($entry['keeper']) ? $entry['keeper'] : null) ) == $key ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    @php $i++; @endphp
                                    @endforeach
                                @endif
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
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
        <script>
            $(function() {
                $('.series_squad_players').select2();
                $(document.body).on('click', '.add-more', function () {
                    $('.series_squad_players').select2("destroy");
                    $('.series_squad_players').removeAttr('data-select2-id');
                    var next = $('.series-squad-info').length + 1;
                    var cloning = $('.series-squad-info').first().clone();

                    cloning.find('legend .number').html('Group ' + next);
                    cloning.find('.series_squad_team').attr('name', 'series_squad['+ next +'][team]');
                    cloning.find('.series_squad_players').attr('name', 'series_squad['+ next +'][players][]');
                    cloning.find('.series_squad_captain').attr('name', 'series_squad['+ next +'][captain]');
                    cloning.find('.series_squad_keeper').attr('name', 'series_squad['+ next +'][keeper]');
                    cloning.insertAfter($('.series-squad-info').last());
                    $('.series_squad_players').select2()
                });
                $(document.body).on('click', '.delete-this', function () {
                    $(this).closest('.series-squad-info').remove();
                });
            });
            
        </script>
    @endpush