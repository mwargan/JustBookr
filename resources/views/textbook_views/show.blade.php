@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Textbook View' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('textbook_views.textbook_view.destroy', $textbookView->tviewid) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('textbook_views.textbook_view.index') }}" class="btn btn-primary" title="Show All Textbook View">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('textbook_views.textbook_view.create') }}" class="btn btn-success" title="Create New Textbook View">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('textbook_views.textbook_view.edit', $textbookView->tviewid ) }}" class="btn btn-primary" title="Edit Textbook View">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Textbook View" onclick="return confirm(&quot;Delete Textbook View??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Userid</dt>
            <dd>{{ $textbookView->userid }}</dd>
            <dt>View  I P</dt>
            <dd>{{ $textbookView->view_IP }}</dd>
            <dt>Isbnviewed</dt>
            <dd>{{ $textbookView->isbnviewed }}</dd>
            <dt>Univiewed</dt>
            <dd>{{ $textbookView->univiewed }}</dd>
            <dt>Dateviewed</dt>
            <dd>{{ $textbookView->dateviewed }}</dd>

        </dl>

    </div>
</div>

@endsection