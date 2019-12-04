@extends('Theme::layouts.baseLayout')
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Galleries</h4><a class="linkClass" href="{{ route('addGallery') }}">Add new gallery</a> &nbsp | &nbsp
                                <a class="linkClass" href="{{ route('addgalleryphoto') }}">Add photos</a>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr><th>Gallery ID</th>
                                            <th> Gallery Name </th>
                                            <th>Item Name</th>
                                            <th>Type</th>
                                            <th>Gallery description</th>
                                            <th>Action</th>
                                        </tr></thead>
                                    <tbody>

                                        @foreach ($fetchGallery as $value)
                                            <tr>
                                                <td>{{ $value['id'] }}</td>
                                                <td>{{ $value['gallery_title'] }}</td>
                                                <td>{{ $value['type_name'] }}</td>
                                                <td class="text-uppercase">{{ $galleryTypes[$value['type']] }}</td>
                                                <td><div style="width:250px; max-height:100px; overflow:auto">{{ $value['gallery_description'] }}
                                                     </div></td>

                                                <td><a href="{{ route('editGallery', ['id' => $value['id']]) }}">edit</a> |
                                                    <a href="{{ route('getPhoto', ['id' => $value['id']]) }}">photos</a> |
                                                    <a href="{{ route('deleteGallery', ['id' => $value['id']]) }}" onclick="if (!confirm('are you sure want to delete this gallery?')) return false;" >delete</a>

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
