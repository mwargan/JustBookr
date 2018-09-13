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
                <h4 class="mt-5 mb-5">Business Stands</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('business_stands.business_stand.create') }}" class="btn btn-success" title="Create New Business Stand">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($businessStands) == 0)
            <div class="panel-body text-center">
                <h4>No Business Stands Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Business</th>
                            <th>Uni</th>
                            <th>Stand Text</th>
                            <th>Location</th>
                            <th>Active</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($businessStands as $businessStand)
                        <tr>
                            <td>{{ optional($businessStand->business)->name }}</td>
                            <td>{{ optional($businessStand->uni)->id }}</td>
                            <td>{{ $businessStand->stand_text }}</td>
                            <td>{{ $businessStand->location }}</td>
                            <td>{{ $businessStand->active }}</td>

                            <td>

                                <form method="POST" action="{!! route('business_stands.business_stand.destroy', $businessStand->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('business_stands.business_stand.show', $businessStand->id ) }}" class="btn btn-info" title="Show Business Stand">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('business_stands.business_stand.edit', $businessStand->id ) }}" class="btn btn-primary" title="Edit Business Stand">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Business Stand" onclick="return confirm(&quot;Delete Business Stand?&quot;)">
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
            {!! $businessStands->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection