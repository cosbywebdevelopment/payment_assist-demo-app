@extends('layouts.dashboard')

@section('content')

    <div class="container">
        <div class="columns">
            <div class="column is-3 ">
                @include('partials._nav')
            </div>
            <div class="column is-9">
                @include('partials._header')

                @if(session('sent_to_customer'))
                    <section id="message" class="mt-2">
                        <div class="notification is-success is-light">
                            <button class="delete"></button>
                            {{ session('sent_to_customer') }}
                        </div>
                    </section>
                @endif
                @if(session('invoice'))
                    <section id="message" class="mt-2">
                        <div class="notification is-success is-light">
                            <button class="delete"></button>
                            {{ session('invoice') }}
                        </div>
                    </section>
                @endif

                <div class="box mt-2">
                    <div class="columns">
                        <div class="column">
                            <h1 class="subtitle">Order Details</h1>
                            <p>Order Number <strong>{{ $order->id }}</strong></p>
                            <p>Customer <strong>{{ $order->customer->firstname . ' ' . $order->customer->surname }}</strong></p>
                            <p>Order Created <strong>{{ \Carbon\Carbon::createFromTimeString($order->created_at)->diffForHumans() }}</strong></p>
                            <p>Payment Assist Reference  <strong>{{ $order->token }}</strong></p>
                        </div>
                        <div class="column">
                            <h1 class="subtitle">Order Contents</h1>
                            @foreach($rows as $row)
                                <p>Product: <strong>{{ $row['name'] }}</strong> Qty: <strong>{{ $row['qty'] }}</strong> Price: <strong>£{{ $row['price'] }}</strong></p>
                            @endforeach
                            <h1 class="subtitle mt-2">Order Total</h1>
                            <p>Total  <strong>£{{ $order->total }}</strong></p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
