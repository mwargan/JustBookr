@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($user->name) ? $user->name : 'User' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('users.user.destroy', $user->{'user-id'}) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('users.user.index') }}" class="btn btn-primary" title="Show All User">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('users.user.create') }}" class="btn btn-success" title="Create New User">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('users.user.edit', $user->{'user-id'} ) }}" class="btn btn-primary" title="Edit User">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete User" onclick="return confirm(&quot;Delete User??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $user->name }}</dd>
            <dt>Surname</dt>
            <dd>{{ $user->surname }}</dd>
            <dt>About me</dt>
            <dd>{{ $user->aboutme }}</dd>
            <dt>Username</dt>
            <dd>{{ $user->username }}</dd>
            <dt>Email</dt>
            <dd>{{ $user->email }}</dd>
            <dt>University</dt>
            <dd>{{ optional($user->webometricUniversity)->{'uni-name'} }}</dd>
            <dt>Country</dt>
            <dd>{{ $user->country }}</dd>
            <dt>City</dt>
            <dd>{{ $user->city }}</dd>
            <dt>Address</dt>
            <dd>{{ $user->address }}</dd>
            <dt>Usertel</dt>
            <dd>{{ $user->usertel }}</dd>
            <dt>Userregistered</dt>
            <dd>{{ $user->userregistered }}</dd>
            <dt>Userlevel</dt>
            <dd>{{ ($user->userlevel) ? 'Yes' : 'No' }}</dd>
            <dt>Profilepic</dt>
            <dd>{{ $user->profilepic }}</dd>
            <dt>Seen</dt>
            <dd>{{ $user->seen }}</dd>
            <dt>Last Login</dt>
            <dd>{{ $user->last_login }}</dd>
            <dt>Last Ip Access</dt>
            <dd>{{ $user->last_ip_access }}</dd>
            <dt>Sessid</dt>
            <dd>{{ $user->sessid }}</dd>

        </dl>

    </div>
</div>

@endsection