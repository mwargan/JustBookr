@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($country->name) ? $country->name : 'Country' }}</h4>
        </span>

        <div class="pull-right">

                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('countries.country.index') }}" class="btn btn-primary" title="Show All Country">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('countries.country.edit', $country->id ) }}" class="btn btn-primary" title="Edit Country">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                </div>


        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Iso2</dt>
            <dd>{{ $country->iso2 }}</dd>
            <dt>Iso3</dt>
            <dd>{{ $country->iso3 }}</dd>
            <dt>Name</dt>
            <dd>{{ $country->name }}</dd>
            <dt>Currency</dt>
            <dd>{{ $country->currency }}</dd>
            <dt>Currency Iso</dt>
            <dd>{{ $country->currency_iso }}</dd>

        </dl>

    </div>
</div>

@endsection