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
                            <div class="col-xs-12">
                                        <div class="col-md-12" >
                                            <h3> Photos</h3>
                                            <div id="field">
                                            <div id="field0">
                            <!-- Text input-->
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="alt_tag">Alt Tag</label>
                              <div class="col-md-5">
                              <input id="action_id" name="alt_tag[]" type="text" placeholder="Alt Tag" class="form-control input-md">

                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="image_title">Image Title</label>
                              <div class="col-md-5">
                              <input id="action_id" name="image_title[]" type="text" placeholder="Image Title" class="form-control input-md">

                              </div>
                            </div>
                            <br><br>
                            <!-- Text input-->
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="action_name">Image Description</label>
                              <div class="col-md-5">
                              <input id="action_name" name="image_description[]" type="text" placeholder="Image Description" class="form-control input-md">

                              </div>
                            </div>
                            <br><br>
                                   <!-- File Button -->
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="action_json">Image</label>
                              <div class="col-md-4">
                                          <input type="file" id="action_json" name="image[]" class="input-file">
                                 <div id="action_jsondisplay"></div>
                              </div>
                            </div>

                            </div>
                            </div>
                            <!-- Button -->
                            <div class="form-group">
                              <div class="col-md-4">
                                <button id="add-more" name="add-more" class="btn btn-primary">Add More</button>
                              </div>
                            </div>
                            <br><br>
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
$(document).ready(function () {
    //@naresh action dynamic childs
    var next = 0;
    $("#add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = ' <div id="field'+ next +'" name="field'+ next +'"><!-- Text input--><div class="form-group"> <label class="col-md-4 control-label" for="action_id">Action Id</label> <div class="col-md-5"> <input id="action_id" name="action_id" type="text" placeholder="" class="form-control input-md"> </div></div><br><br> <!-- Text input--><div class="form-group"> <label class="col-md-4 control-label" for="action_name">Action Name</label> <div class="col-md-5"> <input id="action_name" name="action_name" type="text" placeholder="" class="form-control input-md"> </div></div><br><br><!-- File Button --> <div class="form-group"> <label class="col-md-4 control-label" for="action_json">Action JSON File</label> <div class="col-md-4"> <input id="action_json" name="action_json" class="input-file" type="file"> </div></div></div>';

        var newIn2 = ' <div id="field'+ next +'" name="field'+ next +'"><!-- Text input--> <div class="form-group"><label class="col-md-4 control-label" for="alt_tag">Alt Tag</label> <div class="col-md-5"> <input id="action_id" name="alt_tag[]" type="text" placeholder="Alt Tag" class="form-control input-md"></div></div> <br><br> <!-- Text input--><div class="form-group"><label class="col-md-4 control-label" for="image_title">Image Title</label><div class="col-md-5"><input id="action_id" name="image_title[]" type="text" placeholder="Image Title" class="form-control input-md"></div></div><br><br><!-- Text input--><div class="form-group"><label class="col-md-4 control-label" for="action_name">Image Description</label><div class="col-md-5"><input id="action_name" name="image_description[]" type="text" placeholder="Image Description" class="form-control input-md"> </div> </div>  <br><br><!-- File Button --><div class="form-group"><label class="col-md-4 control-label" for="action_json">Image</label><div class="col-md-4"><input type="file" id="action_json" name="image[]" class="input-file"></div></div></div> ';

        var newInput = $(newIn2);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >Remove</button></div></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);

            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
    });

});
</script>
@endpush
