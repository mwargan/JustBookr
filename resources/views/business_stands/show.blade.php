@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Business Stand' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('business_stands.business_stand.destroy', $businessStand->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('business_stands.business_stand.index') }}" class="btn btn-primary" title="Show All Business Stand">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('business_stands.business_stand.create') }}" class="btn btn-success" title="Create New Business Stand">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('business_stands.business_stand.edit', $businessStand->id ) }}" class="btn btn-primary" title="Edit Business Stand">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Business Stand" onclick="return confirm(&quot;Delete Business Stand??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Business</dt>
            <dd>{{ optional($businessStand->business)->name }}</dd>
            <dt>Uni</dt>
            <dd>{{ optional($businessStand->uni)->id }}</dd>
            <dt>Stand Text</dt>
            <dd>{{ $businessStand->stand_text }}</dd>
            <dt>Location</dt>
            <dd>{{ $businessStand->location }}</dd>
            <dt>Active</dt>
            <dd>{{ $businessStand->active }}</dd>

        </dl>

    </div>
</div>

@endsection