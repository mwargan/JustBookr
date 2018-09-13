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
                <h4 class="mt-5 mb-5">Searches</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('searches.search.create') }}" class="btn btn-success" title="Create New Search">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($searches) == 0)
            <div class="panel-body text-center">
                <h4>No Searches Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Query</th>
                            <th>User</th>
                            <th>Uni</th>
                            <th>Results Count</th>
                            <th>Timestamp</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($searches as $search)
                        <tr>
                            <td>{{ $search->query }}</td>
                            <td>{{ $search->user }}</td>
                            <td>{{ $search->uni }}</td>
                            <td>{{ $search->results_count }}</td>
                            <td>{{ $search->timestamp }}</td>

                            <td>

                                <form method="POST" action="{!! route('searches.search.destroy', $search->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('searches.search.show', $search->id ) }}" class="btn btn-info" title="Show Search">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('searches.search.edit', $search->id ) }}" class="btn btn-primary" title="Edit Search">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Search" onclick="return confirm(&quot;Delete Search?&quot;)">
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
            {!! $searches->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection