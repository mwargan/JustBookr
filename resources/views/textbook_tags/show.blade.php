@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Textbook Tag' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('textbook_tags.textbook_tag.destroy', $textbookTag->ttid) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('textbook_tags.textbook_tag.index') }}" class="btn btn-primary" title="Show All Textbook Tag">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('textbook_tags.textbook_tag.create') }}" class="btn btn-success" title="Create New Textbook Tag">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('textbook_tags.textbook_tag.edit', $textbookTag->ttid ) }}" class="btn btn-primary" title="Edit Textbook Tag">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Textbook Tag" onclick="return confirm(&quot;Delete Textbook Tag??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Tagid</dt>
            <dd>{{ optional($textbookTag->tag)->tdata }}</dd>
            <dt>Isbn</dt>
            <dd>{{ optional($textbookTag->textbook)->booktitle }}</dd>

        </dl>

    </div>
</div>

@endsection