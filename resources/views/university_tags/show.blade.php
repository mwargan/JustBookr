@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'University Tag' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('university_tags.university_tag.destroy', $universityTag->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('university_tags.university_tag.index') }}" class="btn btn-primary" title="Show All University Tag">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('university_tags.university_tag.create') }}" class="btn btn-success" title="Create New University Tag">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('university_tags.university_tag.edit', $universityTag->id ) }}" class="btn btn-primary" title="Edit University Tag">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete University Tag" onclick="return confirm(&quot;Delete University Tag??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Uniid</dt>
            <dd>{{ $universityTag->uniid }}</dd>
            <dt>Tagid</dt>
            <dd>{{ $universityTag->tagid }}</dd>

        </dl>

    </div>
</div>

@endsection