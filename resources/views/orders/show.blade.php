@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Order' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('orders.order.destroy', $order->{'connect-id'}) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('orders.order.index') }}" class="btn btn-primary" title="Show All Order">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('orders.order.create') }}" class="btn btn-success" title="Create New Order">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('orders.order.edit', $order->{'connect-id'} ) }}" class="btn btn-primary" title="Edit Order">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Order" onclick="return confirm(&quot;Delete Order??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Useridsell</dt>
            <dd>{{ optional($order->post)->{'user-id'} }}</dd>
            <dt>Useridbuy</dt>
            <dd>{{ optional($order->buyer)->name }}</dd>
            <dt>Postid</dt>
            <dd>{{ optional($order->post)->{'post-id'} }}</dd>
            <dt>Comment</dt>
            <dd>{{ $order->comment }}</dd>
            <dt>Timestamp</dt>
            <dd>{{ $order->timestamp }}</dd>
            <dt>Locationmeet</dt>
            <dd>{{ $order->{'location-meet'} }}</dd>
            <dt>Locationdate</dt>
            <dd>{{ $order->{'location-date'} }}</dd>
            <dt>Locationtime</dt>
            <dd>{{ $order->{'location-time'} }}</dd>
            <dt>Replied</dt>
            <dd>{{ $order->replied }}</dd>

        </dl>

    </div>
</div>

@endsection