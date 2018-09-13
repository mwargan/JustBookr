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
                <h4 class="mt-5 mb-5">Posts</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('posts.post.create') }}" class="btn btn-success" title="Create New Post">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($posts) == 0)
            <div class="panel-body text-center">
                <h4>No Posts Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Book</th>
                            <th>Date</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ optional($post->user)->{'name'} }}</td>
                            <td>{{ optional($post->textbook)->{'book-title'} }}</td>
                            <td>{{ $post->date }}</td>

                            <td>

                                <form method="POST" action="{!! route('posts.post.destroy', $post->{'post-id'}) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('posts.post.show', $post->{'post-id'} ) }}" class="btn btn-info" title="Show Post">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('posts.post.edit', $post->{'post-id'} ) }}" class="btn btn-primary" title="Edit Post">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Post" onclick="return confirm(&quot;Delete Post?&quot;)">
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
            {!! $posts->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection