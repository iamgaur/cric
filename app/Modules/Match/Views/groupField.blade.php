@extends('Theme::layouts.baseLayout')
<style>
    .repeat-group {
        width: 100%;
        float: left;
    }

    </style>
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">{{ $title }}</h4>
                        <a class="linkClass" href=" {{ route('matches') }}">Back to list</a>
                    </div>
                    <div class="content">
                        <form method="post" action="{{route('matchAddGroupFields')}}">

                            @csrf
                            @php $i = 1; @endphp
                            <div class="group-fields-clone  {{ count($field_group) > 0 ? 'hidden': 'repeat-group' }}">
                                <span class="number">{{ $i }}.</span> 
                                <label>Heading</label>
                                <div class="form-inline">
                                    <input type="text" style="min-width: 65%;" value="" class="form-control group-field-heading" placeholder="Heading" name="groupField[{{$i + 1}}][heading]">
                                    <button class="btn btn-fill add-more-group">Add More Group</button>
                                    <button class="btn btn-danger remove-group">Remove Group</button>
                                </div>
                                <div class="sub-field-group">
                                    <div class="col-md-12">
                                        <div class="form-group sub-field">
                                            <label>Sub Field Title</label>
                                            <div data-heading-number="{{$i}}" class="form-inline col-md-12 add-more-field">
                                                <span class="single-field" style="display: block; margin-bottom: 5px">
                                                    <input style="min-width: 65%;" type="text" value="" class="form-control group-sub-field-title" placeholder="Field" name="groupField[{{$i+1}}][fields][0]">
                                                    <button class="btn btn-fill add-more">Add More</button>
                                                    <button class="btn btn-danger remove-field">Remove Field</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" group-fields">
                                @foreach ($field_group as $group)
                                <div class="repeat-group">
                                    
                                    <span class="number">{{ $i }}.</span>
                                    <label>Heading</label>
                                    <div class="form-inline">
                                        <input type="text" style="min-width: 65%;"  value="{{ $group['heading'] }}" class="form-control group-field-heading" placeholder="Heading" name="groupField[{{$i}}][heading]">
                                        <button class="btn btn-fill add-more-group">Add More Group</button>
                                        <button class="btn btn-danger remove-group">Remove Group</button>
                                    </div>
                                    
                                   
                                    <div class="sub-field-group">
                                        <div class="col-md-12">
                                            
                                                <div class="form-group sub-field">
                                                    <label>Title</label>
                                                    <div data-heading-number="{{$i}}" class="form-inline col-md-12 add-more-field">
                                                    @php $j = 0; @endphp
                                                    @foreach($group['fields'] as $field)     
                                                        <span  class="single-field" style="display: block; margin-bottom: 5px">
                                                            <input type="text" value="{{ $field }}" style="min-width: 65%;" class="form-control group-sub-field-title" placeholder="Field" name="groupField[{{$i}}][fields][{{$j}}]" >
                                                            <button class="btn btn-fill add-more">Add More</button>
                                                            <button class="btn btn-danger remove-field">Remove Field</button>
                                                        </span>
                                                        
                                                    @php $j++; @endphp
                                                    @endforeach
                                                    </div>
                                                </div>
                                            

                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                                @endforeach      
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
<script>
    $(function () {
        $(document.body).on('click', '.add-more-group', function (e) {
            e.preventDefault();
            var cloned_dynamic_field = $('.group-fields-clone').clone();

            cloned_dynamic_field.removeClass('group-fields-clone hidden').addClass('repeat-group');
            var next_dynamic_field_number = parseInt($('.repeat-group').length) + 1;
            cloned_dynamic_field.find('.group-field-heading').attr('name', 'groupField[' + next_dynamic_field_number + '][heading]');
            cloned_dynamic_field.find('.number').html(next_dynamic_field_number);
            cloned_dynamic_field.find('.single-field:gt(0)').remove();
            cloned_dynamic_field.find('.group-sub-field-title').attr('name', 'groupField[' + next_dynamic_field_number + '][fields][0]');
            cloned_dynamic_field.find('.add-more-field').attr('data-heading-number', next_dynamic_field_number);
            cloned_dynamic_field.appendTo('.group-fields');
        });
        $(document.body).on('click', '.add-more', function (e) {
            e.preventDefault();
            var cloned = $(this).parents('.single-field').clone();

            var next_dynamic_heading_number = parseInt($(this).parents('.add-more-field').attr('data-heading-number'));
            var next_dynamic_title_number = parseInt($(this).parents('.add-more-field').children('.single-field').length);
            cloned.find('.group-sub-field-title').attr('name', 'groupField['+ next_dynamic_heading_number +'][fields]['+ next_dynamic_title_number +']');
            
            cloned.appendTo($(this).closest('.add-more-field'));
        });

        $(document.body).on('click', '.remove-group', function (e) {
            e.preventDefault();
            if (confirm('Are you sure want to delete this group')) {
                $(this).parents('.repeat-group').remove();
            }
        });

        $(document.body).on('click', '.remove-field', function (e) {
            e.preventDefault();
            if (confirm('Are you sure want to delete this field')) {
                $(this).parents('.single-field').remove();
            }
        });
    });
</script>
@endpush
