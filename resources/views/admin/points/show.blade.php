@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Point' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('points.point.destroy', $point->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('points.point.index') }}" class="btn btn-primary" title="Show All Point">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('points.point.create') }}" class="btn btn-success" title="Create New Point">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('points.point.edit', $point->id ) }}" class="btn btn-primary" title="Edit Point">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Point" onclick="return confirm(&quot;Delete Point??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Points</dt>
            <dd>{{ $point->points }}</dd>
            <dt>Action</dt>
            <dd>{{ $point->action }}</dd>
            <dt>Userid</dt>
            <dd>{{ optional($point->user)->name }}</dd>
            <dt>Timestamp</dt>
            <dd>{{ $point->timestamp }}</dd>

        </dl>

    </div>
</div>

@endsection