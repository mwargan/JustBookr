@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Reported Post' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('reported_posts.reported_post.destroy', $reportedPost->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('reported_posts.reported_post.index') }}" class="btn btn-primary" title="Show All Reported Post">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('reported_posts.reported_post.create') }}" class="btn btn-success" title="Create New Reported Post">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('reported_posts.reported_post.edit', $reportedPost->id ) }}" class="btn btn-primary" title="Edit Reported Post">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Reported Post" onclick="return confirm(&quot;Delete Reported Post??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Reported By</dt>
            <dd>{{ optional($reportedPost->user)->name }}</dd>
            <dt>Postid</dt>
            <dd>{{ optional($reportedPost->post)->userid }}</dd>
            <dt>Reason</dt>
            <dd>{{ $reportedPost->reason }}</dd>
            <dt>Report Time</dt>
            <dd>{{ $reportedPost->report_time }}</dd>
            <dt>Resolved</dt>
            <dd>{{ $reportedPost->resolved }}</dd>

        </dl>

    </div>
</div>

@endsection