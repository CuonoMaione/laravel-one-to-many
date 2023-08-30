@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">

        <form action="{{route('admin.posts.update', $post->id)}}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="text" class="form-label">Title</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="title..." name="title" value=" {{ old( 'title' , $post->title )}}">
            </div>
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="image..." name="image" value="{{old('image' ,  $post->image)}}"> 
            </div>
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content">{{old('content' , $post->content)  }}</textarea>
            </div>
            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <button type="submit" class="btn btn-sm btn-success me-1">Edit post</button>
                <button type="reset"class="btn btn-sm btn-danger">Reset</button>
            </div>
        </form>
                    
            
        </div>
    </div>
</div>
@endsection