@extends('layouts.app')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Book Notifications</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('book_notifications.book_notification.create') }}" class="btn btn-success" title="Create New Book Notification">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($bookNotifications) == 0)
            <div class="panel-body text-center">
                <h4>No Book Notifications Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Uni</th>
                            <th>Isbn</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($bookNotifications as $bookNotification)
                        <tr>
                            <td>{{ optional($bookNotification->user)->name }}</td>
                            <td>{{ optional($bookNotification->uni)->id }}</td>
                            <td>{{ $bookNotification->isbn }}</td>

                            <td>

                                <form method="POST" action="{!! route('book_notifications.book_notification.destroy', $bookNotification->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('book_notifications.book_notification.show', $bookNotification->id ) }}" class="btn btn-info" title="Show Book Notification">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('book_notifications.book_notification.edit', $bookNotification->id ) }}" class="btn btn-primary" title="Edit Book Notification">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Book Notification" onclick="return confirm(&quot;Delete Book Notification?&quot;)">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
            {!! $bookNotifications->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection