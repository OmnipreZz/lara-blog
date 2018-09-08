@extends('layouts.app')

@section('content')
<div class="container">

<h1>Post</h1>
    <div class="card mb-5">
  <div class="card-header text-center">
   {{ $post->title }}
  </div>
  <div class="card-body">
    <p class="card-text">{{ $post->content }}</p>
  </div>
  <div class="card-footer">
    <p class="card-text">Posted by {{ $post->author }} at {{ $post->created_at}}</p>
    @auth
    @if ($post->author ==  Auth::user()->name )
    <a href="/post/delete/{{$post->id}}" class="btn btn-danger" role="button">Delete</a>
    <a href="/post/update/{{$post->id}}" class="btn btn-primary" role="button">Update</a>
    @endif
    @endauth
  </div>
    </div>
@auth
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create your comment</div>

                <div class="card-body">
                    <form method="POST" action="/comment/create/{{$post->id}}" aria-label="">
                        @csrf

                        <div class="form-group row">
                            <label for="content" class="col-md-4 col-form-label text-md-right">{{ __('Content') }}</label>

                            <div class="col-md-6">
                                <textarea id="content" class="form-control" name="content" rows="10" required style="resize:none;"></textarea>

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endauth
<h1>Comments</h1>
@foreach ($comments as $comment)
                <div class="card mb-5">
                        <div class="card-body">
                            <p class="card-text">{{$comment->content}}</p>
                        </div>
                        <div class="card-footer">
                        <p class="card-text">Posted by {{ $comment->author }} at {{ $comment->created_at}}</p>
                        <!-- <a href="" class="btn btn-danger" role="button">Delete</a>
                        <a href="" class="btn btn-primary" role="button">Update</a> -->
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection