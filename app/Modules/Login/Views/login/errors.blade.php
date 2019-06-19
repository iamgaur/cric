@if ($errors->has('invalid_attempt'))
    <div class="alert alert-warning">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{ $errors->first('invalid_attempt') }}</strong>
    </div>
@endif