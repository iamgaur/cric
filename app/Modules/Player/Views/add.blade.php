@extends('Theme::layouts.baseLayout')
    <style>
        .pl-0 {
            padding-left: 0 !important;
        }
        .pr-0 {
            padding-right: 0 !important;
        }
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
                            <a class="linkClass" href=" {{ route('players') }}">Back to list</a>
                        </div>
                        <div class="content">
                            <form method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            @php
                                               $national_team = array(
                                                    'team_id' => null,
                                                    'time_from' => null,
                                                    'time_to' => null
                                                );
                                                $j = 1;
                                                $club[1] = array(
                                                                'team_id' => null,
                                                                'time_from' => null,
                                                                'time_to' => null,
                                                            );
                                             
                                            @endphp
                                            @foreach($playerTeams as $playerTeam) 
                                                @php
                                                    if ($playerTeam['team_type'] == 1) {
                                                        $national_team = array(
                                                            'team_id' => $playerTeam['team_id'],
                                                            'time_from' => $playerTeam['time_from'],
                                                            'time_to' => $playerTeam['time_to']
                                                        );
                                                    } else {
                                                        $club[$j] = array(
                                                            'team_id' => $playerTeam['team_id'],
                                                            'time_from' => $playerTeam['time_from'],
                                                            'time_to' => $playerTeam['time_to'],
                                                        );
                                                        $j++;
                                                    }
                                                @endphp
                                            @endforeach
                                           
                                            <label>National Team</label>
                                            <select name="team_country[team][0][team_id]" id="team_country">
                                                <option value="">Select National Team</option>
                                                @if (!empty($nationalTeamList))
                                               
                                                    @foreach ($nationalTeamList as $data)
                                                        <option {{old('team_country.team.0.team_id', $national_team['team_id']) == $data['id'] ? 'selected' : null }} value="{{ $data['id'] }}">{{ $data['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input id="action_id" value="{{old('team_country.team.0.start_date', $national_team['time_from']) }}" name="team_country[team][0][start_date]" type="text" placeholder="Start Date" required class="form-control input-md pickerDate">
                                            <br />
                                            <input id="action_id" value="{{old('team_country.team.0.end_date', $national_team['time_to']) }}" name="team_country[team][0][end_date]" type="text" placeholder="End Date"  class="form-control input-md pickerDate">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="">
                                                <div id="field">
                                                    @for($i = 1; $i <= count($club); $i++)
                                                    <div class="club-listing" id="field{{ $i }}">
                                                        <div class="form-group">
                                                            <label>Club</label>
                                                            <select name="team_country[team][{{ $i }}][team_id]" class="team_country_club">
                                                                <option value="">Select Club</option>
                                                                @if (!($clubTeamList->isEmpty()))
                                                                    @foreach ($clubTeamList as $data)
                                                                        <option {{ old( 'team_country.team.' . $i . '.team_id', $club[$i]['team_id']) == $data['id'] ? 'selected' : null }} value="{{ $data['id'] }}">{{ $data['name'] }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <!-- Text input-->
                                                        <div class="form-group">
                                                            <div class="">
                                                                <input value="{{ old('team_country.team.1.start_date', $club[$i]['time_from']) }}" name="team_country[team][{{ $i }}][start_date]" type="text" placeholder="Start Date" class="form-control input-md pickerDate">
                                                            </div>
                                                        </div>
                                                        <!-- Text input-->
                                                        <div class="form-group">
                                                            <div class="">
                                                                <input  value="{{ old('team_country.team.1.start_date', $club[$i]['time_to']) }}" name="team_country[team][{{ $i }}][end_date]" type="text" placeholder="End Date" class="form-control input-md pickerDate">
                                                            </div>
                                                        </div>
                                                        <!--Button-->
                                                        <div class="form-group">
                                                            <div class="">
                                                                <button id="add-more" name="add-more" class="btn btn-primary">Add More</button>
                                                                <button class="btn btn-danger remove-me {{ $i > 1 ? null : 'hidden' }}">Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" value="{{ old('player_name', $player->player_name) }}" class="form-control" placeholder="Player name" name="player_name" id="player_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Born</label>
                                            <input type="text" value="{{ old('player_born', $player->player_born) }}" class="form-control pickerDate" placeholder="Date of birth" name="player_born" id="player_dob">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Also known as</label>
                                            <input type="text" value="{{ old('player_nickname', $player->player_nickname) }}" class="form-control" placeholder="Also known as" name="player_nickname" id="player_nickname">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Playing role</label>
                                            <input type="text" value="{{ old('player_playing_role', $player->player_playing_role) }}" class="form-control" placeholder="Playing role" name="player_playing_role" id="player_playing_role">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Batting style</label>
                                            <input type="text"  value="{{ old('player_playing_batting', $player->player_playing_batting) }}" class="form-control" placeholder="Batting style" name="player_playing_batting" id="player_batting_style">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Bowling style</label>
                                            <input type="text" value="{{ old('player_playing_bowling', $player->player_playing_bowling) }}" class="form-control" placeholder="Bowling style" name="player_playing_bowling" id="player_bowling_style">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Fielding position</label>
                                            <input type="text"  value="{{ old('player_fielding_position', $player->player_fielding_position) }}" class="form-control" placeholder="Fielding position" name="player_fielding_position" id="player_fielding_position">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Bio</label>
                                            <textarea rows="5"  name="player_bio" class="form-control" placeholder="Here can be your description" value="Mike" id="editor">{{ old('player_bio', $player->player_bio) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Meta title</label>
                                            <input type="text"  value="{{ old('meta_title', $player->meta_title) }}" class="form-control" placeholder="Meta title" name="meta_title" id="meta_title">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Meta description</label>
                                            <input type="text"  value="{{ old('meta_description', $player->meta_description) }}" class="form-control" placeholder="Meta description" name="meta_description" id="meta_description">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Meta keywords</label>
                                            <input type="text"  value="{{ old('meta_keywords', $player->meta_keywords) }}" class="form-control" placeholder="Meta keywords" name="meta_keywords" id="meta_keywords">
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
        <script type="text/javascript">  
            $(document).ready(function () {
                $(document.body).on('click', '#add-more',function(e){
                    e.preventDefault();
                    var current = $('.club-listing').length;
                    var next = (parseInt(current)+1);
                    var field = $('#field1').clone();
                    field.prop('id', 'field' + next);

                    field.find('[name="team_country[team][1][team_id]"]').val('');
                    field.find('[name="team_country[team][1][team_id]"]').attr('name', "team_country[team]["+ next +"][team_id]");
                    field.find('[name="team_country[team][1][start_date]"]').val('');
                    field.find('[name="team_country[team][1][start_date]"]').attr('name', "team_country[team]["+ next +"][start_date]");
                    field.find('[name="team_country[team][1][end_date]"]').val('');
                    field.find('[name="team_country[team][1][end_date]"]').attr('name', "team_country[team]["+ next +"][end_date]");
                    field.find('.remove-me').removeClass('hidden');
                    field.appendTo('#field');
                    $('.pickerDate').data('DateTimePicker').destroy();
                    $('.club-listing').each(function() {
                        $('.pickerDate').datetimepicker({
                            widgetParent: $(this),
                            format: 'YYYY-MM-DD'
                        }); 
                    });
                });
                $(document.body).on('click', '.remove-me', function(e){
                    e.preventDefault();
                    $(this).parents('.club-listing').remove();
                });
                $('.pickerDate').datetimepicker({
                    format: 'YYYY-MM-DD'
                }); 
                $('#editor').summernote({
                  height: 500,
                });
            });
        </script>
    @endpush
