@extends('Theme::layouts.baseLayout')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">{{$dataArray['series_name']}}</h4>
                    </div>
                    <div class="content table-responsive table-full-width">
                      <form  method="post">
                            @csrf
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr><th>Team</th>
                                    <th>Played</th>
                                    <th>Won</th>
                                    <th>Lost</th>
                                    <th>Tied</th>
                                    <th>NR</th>
                                    <th>Points</th>
                                    <th>NRR</th>
                                </tr></thead>
                            <tbody>
                                  @foreach($dataArray['teams'] as $team_id => $name)
                                  @php
                                  if(isset($dataArray['points']) && !empty($dataArray['points']) && isset($dataArray['points'][$team_id])) {
                                    $points = json_decode($dataArray['points'][$team_id],true);
                                  } else {
                                    $points = array();
                                  }
                                  @endphp
                                  <tr>
                                    <td>{{$name}}</td>
                                    <td><input style="width:70px" type="number"  value="{{ isset($points['tp']) ? $points['tp'] : 0  }}" name="tp[{{$team_id}}]"></td>
                                    <td><input style="width:70px" type="number"  value="{{ isset($points['won']) ? $points['won'] : 0 }}" name="won[{{$team_id}}]"></td>
                                    <td><input style="width:70px" type="number"  value="{{ isset($points['lost']) ? $points['lost'] : 0 }}" name="lost[{{$team_id}}]"></td>
                                    <td><input style="width:70px" type="number"  value="{{ isset($points['tied']) ? $points['tied'] : 0 }}" name="tied[{{$team_id}}]"></td>
                                    <td><input style="width:70px" type="number"  value="{{ isset($points['nr']) ? $points['nr'] : 0 }}" name="nr[{{$team_id}}]"></td>
                                    <td><input style="width:70px" type="number"  value="{{ isset($points['pts']) ? $points['pts'] : 0 }}" name="pts[{{$team_id}}]"></td>
                                    <td><input style="width:70px" type="number"  value="{{ isset($points['nrr']) ? $points['nrr'] : 0 }}" name="nrr[{{$team_id}}]"></td>
                                  </tr>
                                  @endforeach
                                  <input type="hidden" value="{{ implode(",",array_keys($dataArray['teams'])) }}" name="teams"/>
                                  <input type="hidden" value="{{ $dataArray['series_id'] }}" name="series_id"/>
                              </tbody>
                              </table>
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
