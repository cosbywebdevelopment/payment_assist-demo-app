@extends('layouts.dashboard')

@section('content')

    <div class="container">
        <div class="columns">
            <div class="column is-3 ">
                @include('partials._nav')
            </div>
            <div class="column is-9">
                @include('partials._header')
                @if(session('status'))
                    <section id="message" class="mt-2">
                        <div class="notification is-primary is-light">
                            <button class="delete"></button>
                            {{ session('status') }}
                        </div>
                    </section>
                @endif

                <section class="section">
                    <div class="buttons">
                        <a class="button is-primary" href="{{ route('customers.create') }}">Add New Customer</a>
                    </div>
                    <table class="table is-hoverable is-fullwidth">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Mobile</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $customer->firstname . ' ' . $customer->surname }}</td>
                                    <td>{{ $customer->address1 }}</td>
                                    <td>{{ $customer->city }}</td>
                                    <td>{{ $customer->mobile }}</td>
                                    <td>
                                        <a class="button is-success" href="{{ route('billing.show', $customer->id) }}">
                                            New Order
                                        </a>
                                    </td>
                                    <td>
                                        <a class="button is-dark" href="{{ route('customers.edit', $customer->id) }}">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>Bob Smith</td>
                                <td>55 Frank Lane</td>
                                <td>Leicester</td>
                                <td>01234 5678977</td>
                                <td>
                                    <a class="button is-success" href="">
                                        New Order
                                    </a>
                                </td>
                                <td>
                                    <a class="button is-dark">
                                        View
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Bob Smith</td>
                                <td>55 Frank Lane</td>
                                <td>Leicester</td>
                                <td>01234 5678977</td>
                                <td>
                                    <a class="button is-success" href="">
                                        New Order
                                    </a>
                                </td>
                                <td>
                                    <a class="button is-dark">
                                        View
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Bob Smith</td>
                                <td>55 Frank Lane</td>
                                <td>Leicester</td>
                                <td>01234 5678977</td>
                                <td>
                                    <a class="button is-success" href="">
                                        New Order
                                    </a>
                                </td>
                                <td>
                                    <a class="button is-dark">
                                        View
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>

    <script>
        $(function() {

            setInterval(function() {

                $.ajax({
                    type: "GET",
                    url: '{{ route('billing.status') }}',
                    success: function (resultData) {

                    }
                });

            }, 10000);
        });
    </script>

@endsection
