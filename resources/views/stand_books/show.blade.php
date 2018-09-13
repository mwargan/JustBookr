@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Stand Book' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('stand_books.stand_book.destroy', $standBook->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('stand_books.stand_book.index') }}" class="btn btn-primary" title="Show All Stand Book">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('stand_books.stand_book.create') }}" class="btn btn-success" title="Create New Stand Book">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('stand_books.stand_book.edit', $standBook->id ) }}" class="btn btn-primary" title="Edit Stand Book">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Stand Book" onclick="return confirm(&quot;Delete Stand Book??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Stand</dt>
            <dd>{{ optional($standBook->stand)->id }}</dd>
            <dt>Isbn</dt>
            <dd>{{ $standBook->isbn }}</dd>
            <dt>Description</dt>
            <dd>{{ $standBook->description }}</dd>
            <dt>Price</dt>
            <dd>{{ $standBook->price }}</dd>
            <dt>Is Active</dt>
            <dd>{{ ($standBook->is_active) ? 'Yes' : 'No' }}</dd>

        </dl>

    </div>
</div>

@endsection