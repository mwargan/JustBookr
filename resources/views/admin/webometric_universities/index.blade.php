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
                <h4 class="mt-5 mb-5">Universities</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('universities.university.create') }}" class="btn btn-success" title="Create New University">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>

        @if(count($Universities) == 0)
            <div class="panel-body text-center">
                <h4>No Universities Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Uniname</th>
                            <th>Enname</th>
                            <th>Abr</th>
                            <th>Country</th>
                            <th>City</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($Universities as $University)
                        <tr>
                            <td>{{ $University->{'uni-name'} }}</td>
                            <td>{{ $University->{'en-name'} }}</td>
                            <td>{{ $University->abr }}</td>
                            <td>{{ optional($University->country)->name }}</td>
                            <td>{{ $University->city }}</td>

                            <td>

                                <form method="POST" action="{!! route('universities.university.destroy', $University->{'uni-id'}) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('universities.university.show', $University->{'uni-id'} ) }}" class="btn btn-info" title="Show University">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('universities.university.edit', $University->{'uni-id'} ) }}" class="btn btn-primary" title="Edit University">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete University" onclick="return confirm(&quot;Delete University?&quot;)">
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
            {!! $Universities->render() !!}
        </div>

        @endif

    </div>
@endsection