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

                <section class="section">
                    <table class="table is-hoverable is-fullwidth">
                        <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Order Total</th>
                            <th>Created</th>
                            <th></th>
                            <th>Customer
                                <br>application
                                <br>complete
                            </th>
                            <th>Invoiced</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->customer->firstname . ' ' . $order->customer->surname }}</td>
                                <td>{{ $order->total }}</td>
                                <td>{{ \Carbon\Carbon::createFromTimeString($order->created_at)->diffForHumans()  }}</td>
                                @if(is_null($order->status))
                                    <div id="spinner">
                                        <td>
                                            <a id="invoiced-{{ $order->id }}" style="display: none" href="{{ route('billing.invoice', $order->id) }}"
                                               class="button is-link" {{ $invoice_button ?? '' }}>Upload Invoice</a>
                                        </td>
                                        <td>
                                            <i id="spin-{{ $order->id }}" class="fas fa-spinner fa-spin"></i>
                                        </td>
                                        @elseif($order->status >= 2)
                                            <div id="spinner">
                                                <td></td>
                                                <td>
                                                    <i id="spin-{{ $order->id }}" class="fas fa-times has-text-danger"></i>
                                                </td>
                                        @else
                                            <td>
                                                @if(!$order->invoiced)
                                                    <a href="{{ route('billing.invoice', $order->id) }}"
                                                       class="button is-link" {{ $invoice_button ?? '' }}>Upload
                                                        Invoice</a>
                                                @endif
                                            </td>
                                            <td>
                                                <i class="fas fa-check has-text-success"></i>
                                            </td>
                                    </div>
                                @endif

                                <td>
                                    @if($order->invoiced)
                                        <i class="fas fa-check has-text-success"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="button is-dark">View Order</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </section>
            </div>
        </div>
    </div>

    <script>
        $(function () {

             setInterval(function () {

                //get status update if true then change class from 'fas fa-spinner fa-spin' to 'fas fa-check has-text-success'
                //using id's append with order id
                $.ajax({
                    type: "GET",
                    url: '{{ route('billing.status') }}',
                    success: function (resultData) {
                        $.each(resultData['complete'], function (index, value) {
                            $("#spin-" + value.id).removeClass('fas fa-spinner fa-spin').addClass('fas fa-check has-text-success');
                            // show 'invoice button'
                            $("#invoiced-" + value.id).show()
                            console.log('complete ' + value.id)
                        });
                        $.each(resultData['expired'], function (index, value) {
                            $("#spin-" + value.id).removeClass().addClass('fas fa-hourglass-end has-text-warning');
                            console.log('expired ' + value.id)
                        });
                        //console.log(resultData)
                    }
                });
             }, 5000);
        });
    </script>

@endsection
