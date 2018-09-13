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
                <h4 class="mt-5 mb-5">Reported Posts</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('reported_posts.reported_post.create') }}" class="btn btn-success" title="Create New Reported Post">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($reportedPosts) == 0)
            <div class="panel-body text-center">
                <h4>No Reported Posts Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Reported By</th>
                            <th>Postid</th>
                            <th>Reason</th>
                            <th>Report Time</th>
                            <th>Resolved</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($reportedPosts as $reportedPost)
                        <tr>
                            <td>{{ optional($reportedPost->user)->name }}</td>
                            <td>{{ optional($reportedPost->post)->userid }}</td>
                            <td>{{ $reportedPost->reason }}</td>
                            <td>{{ $reportedPost->report_time }}</td>
                            <td>{{ $reportedPost->resolved }}</td>

                            <td>

                                <form method="POST" action="{!! route('reported_posts.reported_post.destroy', $reportedPost->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('reported_posts.reported_post.show', $reportedPost->id ) }}" class="btn btn-info" title="Show Reported Post">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('reported_posts.reported_post.edit', $reportedPost->id ) }}" class="btn btn-primary" title="Edit Reported Post">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Reported Post" onclick="return confirm(&quot;Delete Reported Post?&quot;)">
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
            {!! $reportedPosts->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection