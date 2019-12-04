@extends('Theme::layouts.baseLayout')
    @section('content') 
    <style>
        #radioBtn .notActive{
            color: #3276b1;
            background-color: #fff;
        }
    </style>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">ICC Rankings</h4><a class="linkClass" href="{{ route('addIccRanking') }}">Add new ICC Ranking</a>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-12">
                        <label class="radio-inline"><input type="radio" name="gender_type" value="man" checked>Men</label>
                        <label class="radio-inline"><input type="radio" name="gender_type" value="woman" >Women</label>
                    </div>
                </div>
                @php $secondhidden = ''; @endphp
                @foreach(config('constants.gender') as $gender)
                <div class="{{$gender .' '. $secondhidden }} ">
                    <div class="row">
                        @php $secondhidden = 'hidden'; @endphp
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">{{ $gender == 'man' ? 'Men\'s': 'Women\'s' }} Team</h4>
                                </div>

                                <div id="exTab1" class="container">	
                                    <ul  class="nav nav-pills">
                                        <li class="active col-md-3">
                                            <a  href="#t20_rating_{{$gender}}" data-toggle="tab">T20</a>
                                        </li>
                                        <li class="col-md-3"><a href="#odi_rating_{{$gender}}" data-toggle="tab">ODI</a>
                                        </li>
                                        <li class="col-md-3"><a href="#test_rating_{{$gender}}" data-toggle="tab">Test</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content clearfix">
                                        @php $firstActive = 'active'; @endphp
                                        @foreach($fetchIccRankings[$gender]['team'] as $key => $category)
                                        <div class="tab-pane {{ $firstActive }}" id="{{ $key. '_' . $gender }}">
                                            <div class="content table-responsive table-full-width " id="nav-team-t20" role="tabpanel" aria-labelledby="nav-team-t20">
                                                <table class="table table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Icc Ranking position</th>
                                                            <th>Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $i = 1; @endphp
                                                        @foreach ($category as $value)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $allTeam[$value['item_id']] }}</td>
                                                            <td><a href="{{ route('editIccRanking', ['id' => $value['id']]) }}">edit</a> |
                                                                <a href="{{ route('deleteIccRanking', ['id' => $value['id']]) }}" onclick="if (!confirm('are you sure want to delete this Ranking?')) return false;" >delete</a></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @php $firstActive = null; @endphp
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">{{ $gender == 'man' ? 'Men\'s': 'Women\'s' }} Players</h4>
                                </div>

                                <div id="exTab2" class="container">	
                                        <ul  class="nav nav-pills">
                                            <li class="active col-md-3">
                                                <a  href="#t20_player_{{$gender}}" data-toggle="tab">T20</a>
                                            </li>
                                            <li class="col-md-3"><a href="#odi_player_{{$gender}}" data-toggle="tab">ODI</a>
                                            </li>
                                            <li class="col-md-3"><a href="#test_player_{{$gender}}" data-toggle="tab">Test</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content clearfix">
                                            @php $firstActive = 'active'; @endphp
                                            @foreach($fetchIccRankings[$gender]['player'] as $key => $category)
                                                <div class="tab-pane {{ $firstActive }}" id="{{ $key . '_' . $gender }}">
                                                    <ul  class="nav nav-pills">
                                                        <li class="active col-md-3">
                                                            <a  href="#{{$gender.$key}}batting_rating" data-toggle="tab">Batting</a>
                                                        </li>
                                                        <li class="col-md-3"><a href="#{{$gender.$key}}bowling_rating" data-toggle="tab">Bowling</a>
                                                        </li>
                                                        <li class="col-md-3"><a href="#{{$gender.$key}}all_rounder_rating" data-toggle="tab">All Rounder</a>
                                                        </li>
                                                    </ul>

                                                    <div class="tab-content clearfix">
                                                        @php $firstSubActive = 'active'; @endphp
                                                        @foreach($category as $keyCategory => $subCategory)
                                                            <div class="tab-pane {{ $firstSubActive }}" id="{{$gender.$key}}{{$keyCategory}}">
                                                                <div class="content table-responsive table-full-width " id="nav-team-t20" role="tabpanel" aria-labelledby="nav-team-t20">
                                                                    <table class="table table-hover table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Icc Ranking position</th>
                                                                                <th>Name</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @php $i = 1; @endphp
                                                                            @foreach ($subCategory as $subCategoryValue)
                                                                                @php
                                                                                $value = $subCategoryValue->toArray();    
                                                                                @endphp
                                                                                <tr>
                                                                                    <td>{{ $i++ }}</td>
                                                                                    <td>{{ $allPlayer[$value['item_id']] }}</td>
                                                                                    <td><a href="{{ route('editIccRanking', ['id' => $value['id']]) }}">edit</a> |
                                                                                        <a href="{{ route('deleteIccRanking', ['id' => $value['id']]) }}" onclick="if (!confirm('are you sure want to delete this Ranking?')) return false;" >delete</a></td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        @php $firstSubActive = null; @endphp
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @php $firstActive = null; @endphp
                                            @endforeach

                                        </div>
                                    </div>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endsection
    @push('scripts')
    <script>
        $(function() {
            $('[name="gender_type"]').change(function() {
               $('.woman').addClass('hidden');
               $('.man').addClass('hidden');
               $('.' + $(this).val()).removeClass('hidden');
            });
        });
    </script>
    @endpush
