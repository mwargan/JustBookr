@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Search' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('searches.search.destroy', $search->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('searches.search.index') }}" class="btn btn-primary" title="Show All Search">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('searches.search.create') }}" class="btn btn-success" title="Create New Search">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('searches.search.edit', $search->id ) }}" class="btn btn-primary" title="Edit Search">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Search" onclick="return confirm(&quot;Delete Search??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Query</dt>
            <dd>{{ $search->query }}</dd>
            <dt>User</dt>
            <dd>{{ $search->user }}</dd>
            <dt>Uni</dt>
            <dd>{{ $search->uni }}</dd>
            <dt>Results Count</dt>
            <dd>{{ $search->results_count }}</dd>
            <dt>Timestamp</dt>
            <dd>{{ $search->timestamp }}</dd>

        </dl>

    </div>
</div>

@endsection