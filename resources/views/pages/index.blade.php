@extends('layouts.app')

@section('content')
<div class="container">
@foreach ($posts as $post)
<div class="card mb-5">
  <div class="card-header text-center">
   {{ $post->title }}
  </div>
  <div class="card-body">
    <p class="card-text">{{ $post->content }}</p>
  </div>
  <div class="card-footer">
    <p class="card-text">Posted by {{ $post->author }} at {{ $post->created_at}}</p>
  </div>
</div>
@endforeach
</div>

@endsection