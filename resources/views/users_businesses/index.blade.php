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
                <h4 class="mt-5 mb-5">Users Businesses</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('users_businesses.users_business.create') }}" class="btn btn-success" title="Create New Users Business">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($usersBusinesses) == 0)
            <div class="panel-body text-center">
                <h4>No Users Businesses Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Business</th>
                            <th>User</th>
                            <th>Is Admin</th>
                            <th>Is Active</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($usersBusinesses as $usersBusiness)
                        <tr>
                            <td>{{ optional($usersBusiness->business)->name }}</td>
                            <td>{{ optional($usersBusiness->user)->name }}</td>
                            <td>{{ ($usersBusiness->is_admin) ? 'Yes' : 'No' }}</td>
                            <td>{{ ($usersBusiness->is_active) ? 'Yes' : 'No' }}</td>

                            <td>

                                <form method="POST" action="{!! route('users_businesses.users_business.destroy', $usersBusiness->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('users_businesses.users_business.show', $usersBusiness->id ) }}" class="btn btn-info" title="Show Users Business">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('users_businesses.users_business.edit', $usersBusiness->id ) }}" class="btn btn-primary" title="Edit Users Business">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Users Business" onclick="return confirm(&quot;Delete Users Business?&quot;)">
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
            {!! $usersBusinesses->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection