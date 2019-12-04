@extends('Theme::layouts.baseLayout')
    @section('content')
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">{{ $title }}</h4>
                                <a class="linkClass" href="{{ route('news') }}">Back to list</a>
                            </div>
                            <div class="content">
                                <form  method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" class="form-control" placeholder="Title" value="{{ old('title', $news->title) }}" name="title" id="title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea id="editor" rows="20" class="form-control" placeholder="Description" name="description">{{ old('description', $news->description) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tags</label>
                                                <input type="text" class="form-control" placeholder="Tags" value="{{ old('tags', $news->tags) }}" name="tags" id="tags">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta title</label>
                                                <input type="text" class="form-control" placeholder="Meta title" value="{{ old('meta_title', $news->meta_title) }}" name="meta_title" id="meta_title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta description</label>
                                                <input type="text" class="form-control" placeholder="Meta description" value="{{ old('meta_description', $news->meta_description) }}" name="meta_description" id="meta_description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Meta keywords</label>
                                                <input type="text" class="form-control" placeholder="Meta keywords" value="{{ old('meta_keywords', $news->meta_keywords) }}" name="meta_keywords" id="meta_keywords">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                              <label>Image</label>
                                              <input type="file" id="file1" class="form-control" value="{{ old('image', $news->image) }}" name="image" accept="image/*">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Alt Tag</label>
                                                <input type="text" class="form-control" value="{{ old('alt_tag', $news->alt_tag) }}" placeholder="Image Alt Tag" name="alt_tag" id="country">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Image Title</label>
                                                <input type="text" class="form-control" value="{{ old('image_title', $news->image_title) }}" placeholder="Image Alt Tag" name="image_title" id="image_title">
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
        <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
        <script>
         $('#editor').summernote({
                  height: 500,
         });
         </script>
    @endpush