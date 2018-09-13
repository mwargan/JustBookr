@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Textbook Price Average' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('textbook_price_averages.textbook_price_average.destroy', $textbookPriceAverage->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('textbook_price_averages.textbook_price_average.index') }}" class="btn btn-primary" title="Show All Textbook Price Average">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('textbook_price_averages.textbook_price_average.create') }}" class="btn btn-success" title="Create New Textbook Price Average">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('textbook_price_averages.textbook_price_average.edit', $textbookPriceAverage->id ) }}" class="btn btn-primary" title="Edit Textbook Price Average">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Textbook Price Average" onclick="return confirm(&quot;Delete Textbook Price Average??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Isbn</dt>
            <dd>{{ $textbookPriceAverage->isbn }}</dd>
            <dt>Min</dt>
            <dd>{{ $textbookPriceAverage->min }}</dd>
            <dt>Avg</dt>
            <dd>{{ $textbookPriceAverage->avg }}</dd>
            <dt>Max</dt>
            <dd>{{ $textbookPriceAverage->max }}</dd>

        </dl>

    </div>
</div>

@endsection