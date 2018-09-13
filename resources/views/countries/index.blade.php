@extends('layouts.app') @section('content') @if(Session::has('success_message'))
<div class="alert alert-success">
    <span class="glyphicon glyphicon-ok"></span> {!! session('success_message') !!}
    <button type="button" class="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <div class="pull-left">
            <h4 class="mt-5 mb-5">Countries</h4>
        </div>
    </div>
    @if(count($countries) == 0)
    <div class="panel-body text-center">
        <h4>No Countries Available!</h4>
    </div>
    @else
    <div class="panel-body panel-body-with-table">
        <div class="table-responsive">
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>Iso2</th>
                        <th>Iso3</th>
                        <th>Name</th>
                        <th>Currency</th>
                        <th>Currency Iso</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($countries as $country)
                    <tr>
                        <td>{{ $country->iso2 }}</td>
                        <td>{{ $country->iso3 }}</td>
                        <td>{{ $country->name }}</td>
                        <td>{{ $country->currency }}</td>
                        <td>{{ $country->currency_iso }}</td>
                        <td>
                            <div class="btn-group btn-group-xs pull-right" role="group">
                                <a href="{{ route('countries.country.show', $country->id ) }}" class="btn btn-info" title="Show Country">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                <a href="{{ route('countries.country.edit', $country->id ) }}" class="btn btn-primary" title="Edit Country">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-footer">
        {!! $countries->render() !!}
    </div>
    @endif
</div>
@endsection