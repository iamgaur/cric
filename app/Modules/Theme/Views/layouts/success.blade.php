@if (session()->has('success'))
    <div class="col-xl-12 col-md-12 alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
       <strong>{{ session()->get('success') }}</strong>
    </div>
@endif