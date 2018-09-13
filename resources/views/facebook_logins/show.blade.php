@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Facebook Login' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('facebook_logins.facebook_login.destroy', $facebookLogin->fbuserid) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('facebook_logins.facebook_login.index') }}" class="btn btn-primary" title="Show All Facebook Login">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('facebook_logins.facebook_login.create') }}" class="btn btn-success" title="Create New Facebook Login">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('facebook_logins.facebook_login.edit', $facebookLogin->fbuserid ) }}" class="btn btn-primary" title="Edit Facebook Login">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Facebook Login" onclick="return confirm(&quot;Delete Facebook Login??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Userid</dt>
            <dd>{{ optional($facebookLogin->user)->name }}</dd>
            <dt>Syncprofilepic</dt>
            <dd>{{ ($facebookLogin->syncprofilepic) ? 'Yes' : 'No' }}</dd>
            <dt>Fb Name</dt>
            <dd>{{ $facebookLogin->fb_name }}</dd>
            <dt>Fb Surname</dt>
            <dd>{{ $facebookLogin->fb_surname }}</dd>
            <dt>Fb Email</dt>
            <dd>{{ $facebookLogin->fb_email }}</dd>
            <dt>Fb Gender</dt>
            <dd>{{ $facebookLogin->fb_gender }}</dd>
            <dt>Fb Profilepic</dt>
            <dd>{{ $facebookLogin->fb_profilepic }}</dd>
            <dt>Fb Link</dt>
            <dd>{{ $facebookLogin->fb_link }}</dd>
            <dt>Fb Location</dt>
            <dd>{{ $facebookLogin->fb_location }}</dd>

        </dl>

    </div>
</div>

@endsection