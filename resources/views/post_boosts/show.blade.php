@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Post Boost' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('post_boosts.post_boost.destroy', $postBoost->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('post_boosts.post_boost.index') }}" class="btn btn-primary" title="Show All Post Boost">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('post_boosts.post_boost.create') }}" class="btn btn-success" title="Create New Post Boost">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('post_boosts.post_boost.edit', $postBoost->id ) }}" class="btn btn-primary" title="Edit Post Boost">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Post Boost" onclick="return confirm(&quot;Delete Post Boost??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Post T</dt>
            <dd>{{ optional($postBoost->postT)->id }}</dd>
            <dt>Expires At</dt>
            <dd>{{ $postBoost->expires_at }}</dd>

        </dl>

    </div>
</div>

@endsection