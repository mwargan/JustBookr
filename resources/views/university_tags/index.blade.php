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
                <h4 class="mt-5 mb-5">University Tags</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('university_tags.university_tag.create') }}" class="btn btn-success" title="Create New University Tag">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($universityTags) == 0)
            <div class="panel-body text-center">
                <h4>No University Tags Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Uniid</th>
                            <th>Tagid</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($universityTags as $universityTag)
                        <tr>
                            <td>{{ $universityTag->uniid }}</td>
                            <td>{{ $universityTag->tagid }}</td>

                            <td>

                                <form method="POST" action="{!! route('university_tags.university_tag.destroy', $universityTag->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('university_tags.university_tag.show', $universityTag->id ) }}" class="btn btn-info" title="Show University Tag">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('university_tags.university_tag.edit', $universityTag->id ) }}" class="btn btn-primary" title="Edit University Tag">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete University Tag" onclick="return confirm(&quot;Delete University Tag?&quot;)">
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
            {!! $universityTags->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection