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
                <h4 class="mt-5 mb-5">Textbooks</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('textbooks.textbook.create') }}" class="btn btn-success" title="Create New Textbook">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($textbooks) == 0)
            <div class="panel-body text-center">
                <h4>No Textbooks Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Edition</th>
                            <th>Authors</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($textbooks as $textbook)
                        <tr>
            <td><img width="50px" src="{{ $textbook->{'image-url'} }}"></td>
                        <td>{{ $textbook->{'book-title'} }}</td>
                        <td>{{ $textbook->edition }}</td>
                        <td>{{ $textbook->author }}</td>

                            <td>


                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('textbooks.textbook.show', $textbook->isbn ) }}" class="btn btn-info" title="Show Textbook">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('textbooks.textbook.edit', $textbook->isbn ) }}" class="btn btn-primary" title="Edit Textbook">
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
            {!! $textbooks->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection