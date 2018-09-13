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
                <h4 class="mt-5 mb-5">Orders</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('orders.order.create') }}" class="btn btn-success" title="Create New Order">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>

        @if(count($orders) == 0)
            <div class="panel-body text-center">
                <h4>No Orders Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Useridsell</th>
                            <th>Useridbuy</th>
                            <th>Postid</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ optional($order->seller)->name }}</td>
                            <td>{{ optional($order->buyer)->name }}</td>
                            <td>{{ optional($order->post)->{'post-id'} }}</td>

                            <td>

                                <form method="POST" action="{!! route('orders.order.destroy', $order->{'connect-id'}) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('orders.order.show', $order->{'connect-id'} ) }}" class="btn btn-info" title="Show Order">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('orders.order.edit', $order->{'connect-id'} ) }}" class="btn btn-primary" title="Edit Order">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Order" onclick="return confirm(&quot;Delete Order?&quot;)">
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
            {!! $orders->render() !!}
        </div>

        @endif

    </div>
@endsection