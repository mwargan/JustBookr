@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Book Notification' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('book_notifications.book_notification.destroy', $bookNotification->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('book_notifications.book_notification.index') }}" class="btn btn-primary" title="Show All Book Notification">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('book_notifications.book_notification.create') }}" class="btn btn-success" title="Create New Book Notification">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('book_notifications.book_notification.edit', $bookNotification->id ) }}" class="btn btn-primary" title="Edit Book Notification">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Book Notification" onclick="return confirm(&quot;Delete Book Notification??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>User</dt>
            <dd>{{ optional($bookNotification->user)->name }}</dd>
            <dt>Uni</dt>
            <dd>{{ optional($bookNotification->uni)->id }}</dd>
            <dt>Isbn</dt>
            <dd>{{ $bookNotification->isbn }}</dd>

        </dl>

    </div>
</div>

@endsection