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
                <h4 class="mt-5 mb-5">Points</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('points.point.create') }}" class="btn btn-success" title="Create New Point">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($points) == 0)
            <div class="panel-body text-center">
                <h4>No Points Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Points</th>
                            <th>Action</th>
                            <th>Userid</th>
                            <th>Timestamp</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($points as $point)
                        <tr>
                            <td>{{ $point->points }}</td>
                            <td>{{ $point->action }}</td>
                            <td>{{ optional($point->user)->name }}</td>
                            <td>{{ $point->timestamp }}</td>

                            <td>

                                <form method="POST" action="{!! route('points.point.destroy', $point->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('points.point.show', $point->id ) }}" class="btn btn-info" title="Show Point">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('points.point.edit', $point->id ) }}" class="btn btn-primary" title="Edit Point">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Point" onclick="return confirm(&quot;Delete Point?&quot;)">
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
            {!! $points->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection