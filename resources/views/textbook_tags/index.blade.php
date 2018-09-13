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
                <h4 class="mt-5 mb-5">Textbook Tags</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('textbook_tags.textbook_tag.create') }}" class="btn btn-success" title="Create New Textbook Tag">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($textbookTags) == 0)
            <div class="panel-body text-center">
                <h4>No Textbook Tags Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Tagid</th>
                            <th>Isbn</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($textbookTags as $textbookTag)
                        <tr>
                            <td>{{ optional($textbookTag->tag)->tdata }}</td>
                            <td>{{ optional($textbookTag->textbook)->booktitle }}</td>

                            <td>

                                <form method="POST" action="{!! route('textbook_tags.textbook_tag.destroy', $textbookTag->ttid) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('textbook_tags.textbook_tag.show', $textbookTag->ttid ) }}" class="btn btn-info" title="Show Textbook Tag">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('textbook_tags.textbook_tag.edit', $textbookTag->ttid ) }}" class="btn btn-primary" title="Edit Textbook Tag">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Textbook Tag" onclick="return confirm(&quot;Delete Textbook Tag?&quot;)">
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
            {!! $textbookTags->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection