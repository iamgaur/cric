@extends('Theme::layouts.baseLayout')
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">{{ $title }}</h4>
                        <a class="linkClass" href="{{ route('gallery') }}">Back to list</a>
                    </div>
                    <div class="content">
                        <form  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Select gallery type for:</label>
                                    <div class="form-group">
                                        @foreach(config('constants.gallery_type') as $key => $value)
                                            <label class="radio-inline">
                                                <input class="gallery-type" type="radio" value="{{ $value }}" name="type" {{ (old('type', $opted) == $value) ? 'checked' : null }}>{{ $key }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @foreach(config('constants.gallery_type') as $key => $value)
                                <div class="row item_id {{ (old('type', $opted) != $value) ? 'hidden': null}}" id="{{ $value }}">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="{{ $key }}">Select {{ $key }}:</label>
                                            <select name="item_id[{{ $value }}]" class="form-control" id="{{ $key }}">
                                                <option value="">Select {{ $key }}</option>
                                                @foreach($gallery_types[strtolower($key)] as $id => $name)
                                                    <option {{ old('item_id.'. $value, $gallery->item_id) == $id ? 'selected' : null }} value={{ $id }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Gallery Title</label>
                                        <input type="text" class="form-control" value="{{ old('alt_tag', $gallery->gallery_title) }}" placeholder="Gallery Title" name="gallery_title" id="gallery_title">
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Gallery Description</label>
                                        <textarea rows="7" class="form-control" placeholder="Gallery Description" name="gallery_description" id="gallery_description">{{ old('gallery_description', $gallery->gallery_description) }}</textarea>
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
