@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Users Business' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('users_businesses.users_business.destroy', $usersBusiness->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('users_businesses.users_business.index') }}" class="btn btn-primary" title="Show All Users Business">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('users_businesses.users_business.create') }}" class="btn btn-success" title="Create New Users Business">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('users_businesses.users_business.edit', $usersBusiness->id ) }}" class="btn btn-primary" title="Edit Users Business">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Users Business" onclick="return confirm(&quot;Delete Users Business??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Business</dt>
            <dd>{{ optional($usersBusiness->business)->name }}</dd>
            <dt>User</dt>
            <dd>{{ optional($usersBusiness->user)->name }}</dd>
            <dt>Is Admin</dt>
            <dd>{{ ($usersBusiness->is_admin) ? 'Yes' : 'No' }}</dd>
            <dt>Is Active</dt>
            <dd>{{ ($usersBusiness->is_active) ? 'Yes' : 'No' }}</dd>

        </dl>

    </div>
</div>

@endsection