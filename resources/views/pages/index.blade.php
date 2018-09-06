@extends('layouts.app')

@section('content')
<div class="container">
@foreach ($posts as $post)
<div class="card mb-5">
  <img class="card-img-top" src="{{ $post->image }}" alt="Card image cap">
  <div class="card-header text-center">
   {{ $post->title }}
  </div>
  <div class="card-body">
    <p class="card-text">{{ $post->content }}</p>
  </div>
  <div class="card-footer">
    <p class="card-text">Posted by {{ $post->author }} at {{ $post->created_at}}</p>
    <a href="/post/delete/{{$post->id}}" class="btn btn-danger" role="button">Delete</a>
    <a href="/post/update/{{$post->id}}" class="btn btn-primary" role="button">Update</a>
    <a href="/post/show/{{$post->id}}" class="btn btn-success" role="button">Comment</a>
  </div>
</div>
@endforeach
</div>

@endsection