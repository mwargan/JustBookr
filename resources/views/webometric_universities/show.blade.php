@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Webometric University' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('webometric_universities.webometric_university.destroy', $webometricUniversity->{'uni-id'}) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('webometric_universities.webometric_university.index') }}" class="btn btn-primary" title="Show All Webometric University">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('webometric_universities.webometric_university.create') }}" class="btn btn-success" title="Create New Webometric University">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('webometric_universities.webometric_university.edit', $webometricUniversity->{'uni-id'} ) }}" class="btn btn-primary" title="Edit Webometric University">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Webometric University" onclick="return confirm(&quot;Delete Webometric University??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>{'uni-name'}</dt>
            <dd>{{ $webometricUniversity->{'uni-name'} }}</dd>
            <dt>{'en-name'}</dt>
            <dd>{{ $webometricUniversity->{'en-name'} }}</dd>
            <dt>Abr</dt>
            <dd>{{ $webometricUniversity->abr }}</dd>
            <dt>Country</dt>
            <dd>{{ optional($webometricUniversity->country)->name }}</dd>
            <dt>City</dt>
            <dd>{{ $webometricUniversity->city }}</dd>
            <dt>Address</dt>
            <dd>{{ $webometricUniversity->address }}</dd>
            <dt>Description</dt>
            <dd>{{ $webometricUniversity->description }}</dd>
            <dt>Unitel</dt>
            <dd>{{ $webometricUniversity->unitel }}</dd>
            <dt>Unipic</dt>
            <dd>{{ $webometricUniversity->unipic }}</dd>
            <dt>Unilogo</dt>
            <dd>{{ $webometricUniversity->unilogo }}</dd>
            <dt>Unilat</dt>
            <dd>{{ $webometricUniversity->unilat }}</dd>
            <dt>Unilon</dt>
            <dd>{{ $webometricUniversity->unilon }}</dd>
            <dt>Url</dt>
            <dd>{{ $webometricUniversity->url }}</dd>

        </dl>

    </div>
</div>

@endsection