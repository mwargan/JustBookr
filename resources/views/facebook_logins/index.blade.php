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
                <h4 class="mt-5 mb-5">Facebook Logins</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('facebook_logins.facebook_login.create') }}" class="btn btn-success" title="Create New Facebook Login">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($facebookLogins) == 0)
            <div class="panel-body text-center">
                <h4>No Facebook Logins Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Userid</th>
                            <th>Syncprofilepic</th>
                            <th>Fb Name</th>
                            <th>Fb Surname</th>
                            <th>Fb Email</th>
                            <th>Fb Gender</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($facebookLogins as $facebookLogin)
                        <tr>
                            <td>{{ optional($facebookLogin->user)->name }}</td>
                            <td>{{ ($facebookLogin->syncprofilepic) ? 'Yes' : 'No' }}</td>
                            <td>{{ $facebookLogin->fb_name }}</td>
                            <td>{{ $facebookLogin->fb_surname }}</td>
                            <td>{{ $facebookLogin->fb_email }}</td>
                            <td>{{ $facebookLogin->fb_gender }}</td>

                            <td>

                                <form method="POST" action="{!! route('facebook_logins.facebook_login.destroy', $facebookLogin->fbuserid) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('facebook_logins.facebook_login.show', $facebookLogin->fbuserid ) }}" class="btn btn-info" title="Show Facebook Login">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('facebook_logins.facebook_login.edit', $facebookLogin->fbuserid ) }}" class="btn btn-primary" title="Edit Facebook Login">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Facebook Login" onclick="return confirm(&quot;Delete Facebook Login?&quot;)">
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
            {!! $facebookLogins->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection