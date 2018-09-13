@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'User Rating' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('user_ratings.user_rating.destroy', $userRating->rate_id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('user_ratings.user_rating.index') }}" class="btn btn-primary" title="Show All User Rating">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('user_ratings.user_rating.create') }}" class="btn btn-success" title="Create New User Rating">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('user_ratings.user_rating.edit', $userRating->rate_id ) }}" class="btn btn-primary" title="Edit User Rating">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete User Rating" onclick="return confirm(&quot;Delete User Rating??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Userid</dt>
            <dd>{{ optional($userRating->user)->name }}</dd>
            <dt>Rating</dt>
            <dd>{{ $userRating->rating }}</dd>
            <dt>Timestamp</dt>
            <dd>{{ $userRating->timestamp }}</dd>
            <dt>Rated By</dt>
            <dd>{{ optional($userRating->ratedBy)->id }}</dd>
            <dt>Comment</dt>
            <dd>{{ $userRating->comment }}</dd>
            <dt>Connectid</dt>
            <dd>{{ $userRating->connectid }}</dd>
            <dt>Status</dt>
            <dd>{{ $userRating->status }}</dd>

        </dl>

    </div>
</div>

@endsection