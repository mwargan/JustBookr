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
                <h4 class="mt-5 mb-5">Post Boosts</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('post_boosts.post_boost.create') }}" class="btn btn-success" title="Create New Post Boost">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($postBoosts) == 0)
            <div class="panel-body text-center">
                <h4>No Post Boosts Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Post T</th>
                            <th>Expires At</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($postBoosts as $postBoost)
                        <tr>
                            <td>{{ optional($postBoost->postT)->id }}</td>
                            <td>{{ $postBoost->expires_at }}</td>

                            <td>

                                <form method="POST" action="{!! route('post_boosts.post_boost.destroy', $postBoost->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('post_boosts.post_boost.show', $postBoost->id ) }}" class="btn btn-info" title="Show Post Boost">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('post_boosts.post_boost.edit', $postBoost->id ) }}" class="btn btn-primary" title="Edit Post Boost">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Post Boost" onclick="return confirm(&quot;Delete Post Boost?&quot;)">
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
            {!! $postBoosts->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection