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
                <h4 class="mt-5 mb-5">Post Comments</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('post_comments.post_comment.create') }}" class="btn btn-success" title="Create New Post Comment">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($postComments) == 0)
            <div class="panel-body text-center">
                <h4>No Post Comments Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Postid</th>
                            <th>Userid</th>
                            <th>Comment</th>
                            <th>Comment Timestamp</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($postComments as $postComment)
                        <tr>
                            <td>{{ optional($postComment->post)->{'post-id'} }}</td>
                            <td>{{ optional($postComment->user)->name }}</td>
                            <td>{{ $postComment->comment }}</td>
                            <td>{{ $postComment->comment_timestamp }}</td>

                            <td>

                                <form method="POST" action="{!! route('post_comments.post_comment.destroy', $postComment->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('post_comments.post_comment.show', $postComment->id ) }}" class="btn btn-info" title="Show Post Comment">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('post_comments.post_comment.edit', $postComment->id ) }}" class="btn btn-primary" title="Edit Post Comment">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Post Comment" onclick="return confirm(&quot;Delete Post Comment?&quot;)">
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
            {!! $postComments->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection