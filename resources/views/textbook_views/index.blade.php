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
                <h4 class="mt-5 mb-5">Textbook Views</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('textbook_views.textbook_view.create') }}" class="btn btn-success" title="Create New Textbook View">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($textbookViews) == 0)
            <div class="panel-body text-center">
                <h4>No Textbook Views Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Userid</th>
                            <th>View  I P</th>
                            <th>Isbnviewed</th>
                            <th>Univiewed</th>
                            <th>Dateviewed</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($textbookViews as $textbookView)
                        <tr>
                            <td>{{ $textbookView->userid }}</td>
                            <td>{{ $textbookView->view_IP }}</td>
                            <td>{{ $textbookView->isbnviewed }}</td>
                            <td>{{ $textbookView->univiewed }}</td>
                            <td>{{ $textbookView->dateviewed }}</td>

                            <td>

                                <form method="POST" action="{!! route('textbook_views.textbook_view.destroy', $textbookView->tviewid) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('textbook_views.textbook_view.show', $textbookView->tviewid ) }}" class="btn btn-info" title="Show Textbook View">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('textbook_views.textbook_view.edit', $textbookView->tviewid ) }}" class="btn btn-primary" title="Edit Textbook View">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Textbook View" onclick="return confirm(&quot;Delete Textbook View?&quot;)">
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
            {!! $textbookViews->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection