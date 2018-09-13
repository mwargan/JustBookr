@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Post' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('posts.post.destroy', $post->{'post-id'}) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('posts.post.index') }}" class="btn btn-primary" title="Show All Post">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('posts.post.create') }}" class="btn btn-success" title="Create New Post">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('posts.post.edit', $post->{'post-id'} ) }}" class="btn btn-primary" title="Edit Post">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Post" onclick="return confirm(&quot;Delete Post??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Seller</dt>
            <dd>{{ optional($post->user)->name }}</dd>
            <dt>Date</dt>
            <dd>{{ $post->date }}</dd>
            <dt>Description</dt>
            <dd>{{ $post->{'post-description'} }}</dd>
            <dt>Book</dt>
            <dd>{{ optional($post->textbook)->{'book-title'} }}</dd>
            <dt>Quality</dt>
            <dd>{{ $post->quality }}</dd>
            <dt>Uni</dt>
            <dd>{{ optional($post->webometricUniversity)->{'uni-name'} }}</dd>
            <dt>Sku</dt>
            <dd>{{ $post->sku }}</dd>
            <dt>Price</dt>
            <dd>{{ $post->price }}</dd>
            <dt>Status</dt>
            <dd>{{ $post->status }}</dd>
            <dt>Comments</dt>
            <dd>{{count($post->postComments)}}</dd>
        </dl>
    </div>
</div>

@endsection