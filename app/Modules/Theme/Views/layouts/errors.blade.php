@if ($errors->has('message'))
    <div class="col-xl-12 col-md-12 alert alert-danger alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
       <strong>{{ $errors->first('message') }}</strong>
    </div> 
@elseif ($errors->all())
    @foreach($errors->getMessages() as $key => $message)
        <div class="col-xl-12 col-md-12 alert alert-danger alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
           <strong>{{ $errors->first($key) }}</strong>
        </div>
        @break
    @endforeach
@endif