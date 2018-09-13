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
                <h4 class="mt-5 mb-5">User Ratings</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('user_ratings.user_rating.create') }}" class="btn btn-success" title="Create New User Rating">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>

        @if(count($userRatings) == 0)
            <div class="panel-body text-center">
                <h4>No User Ratings Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Userid</th>
                            <th>Rating</th>
                            <th>Timestamp</th>
                            <th>Rated By</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($userRatings as $userRating)
                        <tr>
                            <td>{{ optional($userRating->user)->name }}</td>
                            <td>{{ $userRating->rating }}</td>
                            <td>{{ $userRating->timestamp }}</td>
                            <td>{{ optional($userRating->ratedBy)->name }}</td>

                            <td>

                                <form method="POST" action="{!! route('user_ratings.user_rating.destroy', $userRating->rate_id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('user_ratings.user_rating.show', $userRating->rate_id ) }}" class="btn btn-info" title="Show User Rating">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('user_ratings.user_rating.edit', $userRating->rate_id ) }}" class="btn btn-primary" title="Edit User Rating">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete User Rating" onclick="return confirm(&quot;Delete User Rating?&quot;)">
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
            {!! $userRatings->render() !!}
        </div>

        @endif

    </div>
@endsection