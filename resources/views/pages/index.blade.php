@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Search post by tag</div>

                <div class="card-body">
                    <form method="POST" action="/post/search" aria-label="">
                        @csrf

                        <div class="form-group row">
                            <label for="tags"class="col-md-4 col-form-label text-md-right">Tags</label>
                            <select name="tags" class="form-control col-md-6" id="tags">
                                @foreach($tags as $k => $tag)
                                <option value="{{$k}}">{{$tag}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Search') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
  <h1>Posts</h1>
  @foreach ($posts as $post)
  <div class="card mb-5">
    <img class="card-img-top" src="" alt="Card image cap">
    <div class="card-header text-center">
     {{ $post->title }}
     @foreach($post->tags as $tag)
     <span class="badge badge-primary">{{$tag->name}}</span>
     @endforeach
   </div>
   <div class="card-body">
    <p class="card-text">{{ $post->content }}</p>
  </div>
  <div class="card-footer">
    <p class="card-text">Posted by {{ $post->author }} at {{ $post->created_at}}</p>
    @if ($post->updated_at !=  $post->created_at )
    <p class="card-text">Updated at {{ $post->updated_at}}</p>
    @endif
    @auth
    @if ($post->author ==  Auth::user()->name )
    <a href="/post/delete/{{$post->id}}" class="btn btn-danger" role="button">Delete</a>
    <a href="/post/update/{{$post->id}}" class="btn btn-primary" role="button">Update</a>
    @endif
    @endauth
    <a href="/post/show/{{$post->id}}" class="btn btn-success" role="button">Show</a>
  </div>
</div>
@endforeach
</div>

@endsection

