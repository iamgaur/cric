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
                            @php $image = ($gallery->image) ? asset('images/gallery/'. $gallery->image) : null; @endphp
                            <img class="col-md-12 col-sm-12" src="{{ $image }}"  style="float:left;width:100%;height:100%;"/>
                            
                            <input type="file" id="file1" name="image" accept="image/*">
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
</script>
@endpush