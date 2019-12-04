@extends('Theme::layouts.baseLayout')
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Add Photos</h4>
                        <a class="linkClass" href="{{ route('gallery') }}">Back to list</a>
                    </div>
                    <div class="content">
                        <form  method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select Gallery</label>
                                        <select class="form-control" name="g_id" id="g_id">
                                            <option value="">Select Gallery</option>
                                            @foreach ($gallery as $g_id => $value)
                                            <option {{ old('g_id', $galleryPhoto->g_id) == $g_id ? 'selected' : null }} value="{{ $g_id }}">{{ $value }}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Gallery Image</label>
                                      <input type="file" id="file1" class="custom-file-input" id="validatedCustomFile" value="{{ old('image', $galleryPhoto->image) }}" name="image" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Alt Tag</label>
                                        <input type="text" class="form-control" value="{{ old('alt_tag', $galleryPhoto->alt_tag) }}" placeholder="Image Alt Tag" name="alt_tag" id="country">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Image Title</label>
                                        <input type="text" class="form-control" value="{{ old('image_title', $galleryPhoto->image_title) }}" placeholder="Image Alt Tag" name="image_title" id="image_title">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Image Description</label>
                                        <input type="text" class="form-control" placeholder="Image Description" value="{{ old('image_description', $galleryPhoto->image_description ) }}" name="image_description" id="meta_title">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js" type="text/javascript"></script>
<script>
    $(function () {
        $(document.body).on('click', '.gallery-type', function() {
            $('.item_id').addClass('hidden');
            $('#' + $(this).val()).removeClass('hidden');
        });
    });

    $(document).ready(function(){
    	var i=1;
    	$('#add').click(function(){
    		 i++;
    		 $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="file" name="image[]" placeholder="Please select image" class="custom-file-input" id="inputGroupFile02" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    	 });
    	 $(document).on('click', '.btn_remove', function(){
    		 var button_id = $(this).attr("id");
    		 $('#row'+button_id+'').remove();
    	 });
    });
</script>
@endpush
