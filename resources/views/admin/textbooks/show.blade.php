@extends('layouts.app') @section('content')
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Textbook' }}</h4>
        </span>
        <div class="pull-right">
            <div class="btn-group btn-group-sm" role="group">
                <a href="{{ route('textbooks.textbook.index') }}" class="btn btn-primary" title="Show All Textbook">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                <a href="{{ route('textbooks.textbook.create') }}" class="btn btn-success" title="Create New Textbook">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                <a href="{{ route('textbooks.textbook.edit', $textbook->isbn ) }}" class="btn btn-primary" title="Edit Textbook">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Title</dt>
            <dd>{{ $textbook->{'book-title'} }}</dd>
            <dt>Authors</dt>
            <dd>{{ $textbook->author }}</dd>
            <dt>Description</dt>
            <dd>{{ $textbook->{'book-des'} }}</dd>
            <dt>Edition</dt>
            <dd>{{ $textbook->edition }}</dd>
            <dt>Image</dt>
            <dd><img width="50%" src="{{ $textbook->{'image-url'} }}"></dd>
            <dt>Image URL</dt>
            <dd>{{ $textbook->{'image-url'} }}</dd>
        </dl>
    </div>
</div>
@endsection