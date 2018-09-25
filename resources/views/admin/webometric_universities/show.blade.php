@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'University' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('universities.university.destroy', $University->{'uni-id'}) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('universities.university.index') }}" class="btn btn-primary" title="Show All University">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('universities.university.create') }}" class="btn btn-success" title="Create New University">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('universities.university.edit', $University->{'uni-id'} ) }}" class="btn btn-primary" title="Edit University">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete University" onclick="return confirm(&quot;Delete University??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>{'uni-name'}</dt>
            <dd>{{ $University->{'uni-name'} }}</dd>
            <dt>{'en-name'}</dt>
            <dd>{{ $University->{'en-name'} }}</dd>
            <dt>Abr</dt>
            <dd>{{ $University->abr }}</dd>
            <dt>Country</dt>
            <dd>{{ optional($University->country)->name }}</dd>
            <dt>City</dt>
            <dd>{{ $University->city }}</dd>
            <dt>Address</dt>
            <dd>{{ $University->address }}</dd>
            <dt>Description</dt>
            <dd>{{ $University->description }}</dd>
            <dt>Unitel</dt>
            <dd>{{ $University->unitel }}</dd>
            <dt>Unipic</dt>
            <dd>{{ $University->unipic }}</dd>
            <dt>Unilogo</dt>
            <dd>{{ $University->unilogo }}</dd>
            <dt>Unilat</dt>
            <dd>{{ $University->unilat }}</dd>
            <dt>Unilon</dt>
            <dd>{{ $University->unilon }}</dd>
            <dt>Url</dt>
            <dd>{{ $University->url }}</dd>

        </dl>

    </div>
</div>

@endsection