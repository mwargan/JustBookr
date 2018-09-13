@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Post Comment' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('post_comments.post_comment.destroy', $postComment->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('post_comments.post_comment.index') }}" class="btn btn-primary" title="Show All Post Comment">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('post_comments.post_comment.create') }}" class="btn btn-success" title="Create New Post Comment">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('post_comments.post_comment.edit', $postComment->id ) }}" class="btn btn-primary" title="Edit Post Comment">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Post Comment" onclick="return confirm(&quot;Delete Post Comment??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Postid</dt>
            <dd>{{ optional($postComment->post)->userid }}</dd>
            <dt>Userid</dt>
            <dd>{{ optional($postComment->user)->name }}</dd>
            <dt>Comment</dt>
            <dd>{{ $postComment->comment }}</dd>
            <dt>Comment Timestamp</dt>
            <dd>{{ $postComment->comment_timestamp }}</dd>

        </dl>

    </div>
</div>

@endsection