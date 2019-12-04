@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">{{$title[0]}}</h4><a class="linkClass" href="{{ route('addGallery') }}">Add new gallery</a> &nbsp | &nbsp
                                <a class="linkClass" href="{{ route('addgalleryphoto') }}">Add photos</a>
                            </div>
                            <div class="content table-responsive table-full-width">
                              @php
                              $k = 1;
                              @endphp

                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>S.No.</th>
                                            <th>Image title</th>
                                            <th>Alt tag</th>
                                            <th>Image description</th>
                                            <th>Image</th>
                                            <th>Profile Image</th>
                                            <th> Action </th>
                                        </tr></thead>
                                    <tbody>

                                        @foreach($gallery as $gal_info)

                                        <tr>
                                          <td> {{ $k++ }} </td>
                                          <td> {{ $gal_info['image_title'] }} </td>
                                          <td> {{ $gal_info['alt_tag'] }} </td>
                                          <td> {{ $gal_info['image_description'] }} </td>
                                          <td> <img src="{{ URL::to('/images/gallery/') .'/'.$gal_info['image'] }}" border="0" width="40" height="40"/> </td>
                                          <td> {{ !empty($gal_info['profile_pic']) ? 'Yes' : 'No' }} </td>
                                          <td><a href="{{ route('editPhoto', ['id' => $gal_info['id']]) }}">edit</a> |
                                              <a href="{{ route('deletePhoto', ['id' => $gal_info['id']]) }}" onclick="if (!confirm('are you sure want to delete this Photo?')) return false;" >delete</a> </td>
                                        </tr>

                                        @endforeach



                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
