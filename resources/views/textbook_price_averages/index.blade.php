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
                <h4 class="mt-5 mb-5">Textbook Price Averages</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('textbook_price_averages.textbook_price_average.create') }}" class="btn btn-success" title="Create New Textbook Price Average">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($textbookPriceAverages) == 0)
            <div class="panel-body text-center">
                <h4>No Textbook Price Averages Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Isbn</th>
                            <th>Min</th>
                            <th>Avg</th>
                            <th>Max</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($textbookPriceAverages as $textbookPriceAverage)
                        <tr>
                            <td>{{ $textbookPriceAverage->isbn }}</td>
                            <td>{{ $textbookPriceAverage->min }}</td>
                            <td>{{ $textbookPriceAverage->avg }}</td>
                            <td>{{ $textbookPriceAverage->max }}</td>

                            <td>

                                <form method="POST" action="{!! route('textbook_price_averages.textbook_price_average.destroy', $textbookPriceAverage->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('textbook_price_averages.textbook_price_average.show', $textbookPriceAverage->id ) }}" class="btn btn-info" title="Show Textbook Price Average">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('textbook_price_averages.textbook_price_average.edit', $textbookPriceAverage->id ) }}" class="btn btn-primary" title="Edit Textbook Price Average">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Textbook Price Average" onclick="return confirm(&quot;Delete Textbook Price Average?&quot;)">
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
            {!! $textbookPriceAverages->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection