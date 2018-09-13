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
                <h4 class="mt-5 mb-5">Stand Books</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('stand_books.stand_book.create') }}" class="btn btn-success" title="Create New Stand Book">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($standBooks) == 0)
            <div class="panel-body text-center">
                <h4>No Stand Books Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Stand</th>
                            <th>Isbn</th>
                            <th>Price</th>
                            <th>Is Active</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($standBooks as $standBook)
                        <tr>
                            <td>{{ optional($standBook->stand)->id }}</td>
                            <td>{{ $standBook->isbn }}</td>
                            <td>{{ $standBook->price }}</td>
                            <td>{{ ($standBook->is_active) ? 'Yes' : 'No' }}</td>

                            <td>

                                <form method="POST" action="{!! route('stand_books.stand_book.destroy', $standBook->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('stand_books.stand_book.show', $standBook->id ) }}" class="btn btn-info" title="Show Stand Book">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('stand_books.stand_book.edit', $standBook->id ) }}" class="btn btn-primary" title="Edit Stand Book">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Stand Book" onclick="return confirm(&quot;Delete Stand Book?&quot;)">
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
            {!! $standBooks->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection