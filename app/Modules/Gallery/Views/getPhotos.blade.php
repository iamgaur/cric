@extends('Theme::layouts.baseLayout')
<style>
    .btn-green {
        background-color: yellow !important;
        color: black !important;
    }
</style>
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">{{ $title }}</h4><a class="linkClass" href="{{ route('addGallery') }}">Add new gallery</a> &nbsp | &nbsp
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
                                            @if(isset($allGallery))
                                            <th>Associate</th>
                                            @endif
                                        </tr></thead>
                                    <tbody>

                                    @foreach($gallery as $gal_info)

                                        <tr class="image-row" data-photo-id="{{$gal_info['id'] }}">
                                          <td> {{ $k++ }} </td>
                                          <td> {{ $gal_info['image_title'] }} </td>
                                          <td> {{ $gal_info['alt_tag'] }} </td>
                                          <td> {{ $gal_info['image_description'] }} </td>
                                          <td> <img src="{{ URL::to('/images/gallery/') .'/'.$gal_info['image'] }}" border="0" width="40" height="40"/> </td>
                                          <td> {{ !empty($gal_info['profile_pic']) ? 'Yes' : 'No' }} </td>
                                          <td><a href="{{ route('editPhoto', ['id' => $gal_info['id']]) }}">Profile Pic</a> |
                                              <a href="{{ route('deletePhoto', ['id' => $gal_info['id']]) }}" onclick="if (!confirm('are you sure want to delete this Photo?')) return false;" >delete</a> </td>
                                          @if(isset($allGallery))
                                          <td><button type="button" class="btn btn-fill btn-sm associate-photo" data-toggle="modal" data-target="#associateGalleryModal">Associate photo</button>
                                          </td>
                                          @endif
                                        </tr>
                                        @endforeach
                                        
                                        
                                       @foreach($associativeGalleryPhotos as $gal_info)

                                        <tr class="associated-row">
                                          <td> {{ $k++ }} </td>
                                          <td> {{ $gal_info['image_title'] }} </td>
                                          <td> {{ $gal_info['alt_tag'] }} </td>
                                          <td> {{ $gal_info['image_description'] }} </td>
                                          <td> <img src="{{ URL::to('/images/gallery/') .'/'.$gal_info['image'] }}" border="0" width="40" height="40"/> </td>
                                          <td> {{ !empty($gal_info['profile_pic']) ? 'Yes' : 'No' }} </td>
                                          <td><a onclick="if (!confirm('are you sure want to de-associate this Photo?')) return false;"
                                                  href="{{ route('deAssociatePhoto',['associative_id' => $parentGallery['id'], 'photo_id' => $gal_info['id']]) }}" >De-associate</a></td>
                                          <td><button type="button" class="btn btn-green btn-sm associated-pic">Associated photo</button>
                                          </td>               
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
    @include('Gallery::associateGallery')
@push('scripts')
<script>
    $(function() {
        $('.associate-photo').on('click', function () {
            var photo_id = $(this).parents('tr').attr('data-photo-id');
            $('#associateGalleryModal .photo-id').val(photo_id);
        });
    });
</script>
@endpush