@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Tag' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('tags.tag.destroy', $tag->{'tag-id'}) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('tags.tag.index') }}" class="btn btn-primary" title="Show All Tag">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('tags.tag.create') }}" class="btn btn-success" title="Create New Tag">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('tags.tag.edit', $tag->{'tag-id'} ) }}" class="btn btn-primary" title="Edit Tag">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Tag" onclick="return confirm(&quot;Delete Tag??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Tdata</dt>
            <dd>{{ $tag->{'t-data'} }}</dd>
            <dt>Tpic</dt>
            <dd>{{ $tag->{'t-pic'} }}</dd>

        </dl>

    </div>
</div>

@endsection