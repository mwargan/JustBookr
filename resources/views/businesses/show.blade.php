@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($business->name) ? $business->name : 'Business' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('businesses.business.destroy', $business->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('businesses.business.index') }}" class="btn btn-primary" title="Show All Business">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('businesses.business.create') }}" class="btn btn-success" title="Create New Business">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('businesses.business.edit', $business->id ) }}" class="btn btn-primary" title="Edit Business">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Business" onclick="return confirm(&quot;Delete Business??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $business->name }}</dd>
            <dt>Description</dt>
            <dd>{{ $business->description }}</dd>

        </dl>

    </div>
</div>

@endsection