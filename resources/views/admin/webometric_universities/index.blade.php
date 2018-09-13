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
                <h4 class="mt-5 mb-5">Webometric Universities</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('webometric_universities.webometric_university.create') }}" class="btn btn-success" title="Create New Webometric University">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>

        @if(count($webometricUniversities) == 0)
            <div class="panel-body text-center">
                <h4>No Webometric Universities Available!</h4>
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
                    @foreach($webometricUniversities as $webometricUniversity)
                        <tr>
                            <td>{{ $webometricUniversity->{'uni-name'} }}</td>
                            <td>{{ $webometricUniversity->{'en-name'} }}</td>
                            <td>{{ $webometricUniversity->abr }}</td>
                            <td>{{ optional($webometricUniversity->country)->name }}</td>
                            <td>{{ $webometricUniversity->city }}</td>

                            <td>

                                <form method="POST" action="{!! route('webometric_universities.webometric_university.destroy', $webometricUniversity->{'uni-id'}) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('webometric_universities.webometric_university.show', $webometricUniversity->{'uni-id'} ) }}" class="btn btn-info" title="Show Webometric University">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('webometric_universities.webometric_university.edit', $webometricUniversity->{'uni-id'} ) }}" class="btn btn-primary" title="Edit Webometric University">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Webometric University" onclick="return confirm(&quot;Delete Webometric University?&quot;)">
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
            {!! $webometricUniversities->render() !!}
        </div>

        @endif

    </div>
@endsection