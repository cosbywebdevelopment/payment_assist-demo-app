@extends('layouts.dashboard')

@section('content')

    <div class="container">
        <div class="columns">
            <div class="column is-3 ">
                @include('partials._nav')
            </div>
            <div class="column is-9">
                <section class="hero is-info welcome is-small">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title">
                                Billing, {{ $customer->firstname . ' ' . $customer->surname }}.
                            </h1>
                        </div>
                    </div>
                </section>

                @if(session('plan_error') == 'Please add an item to the basket!')
                    <section id="message" class="mt-2">
                        <div class="notification is-danger is-light">
                            <button class="delete"></button>
                            Please add an item to the basket!
                        </div>
                    </section>
                @endif

                @if(session('preapproved') == 'preapproved')
                    <section id="message" class="mt-2">
                        <div class="notification is-success is-light">
                            <button class="delete"></button>
                            You have been preapproved!
                        </div>
                    </section>
                @elseif(session('preapproved') == 'failed')
                    <section id="message" class="mt-2">
                        <div class="notification is-danger is-light">
                            <button class="delete"></button>
                            You have not been preapproved!
                        </div>
                    </section>
                @endif

                @if(session('order_id') == 'not unique')
                    <section id="message" class="mt-2">
                        <div class="notification is-danger is-light">
                            <button class="delete"></button>
                            Customer order number not unique!
                        </div>
                    </section>
                @endif

                @if(session('status-error'))
                    <section id="message" class="mt-2">
                        <div class="notification is-danger is-light">
                            <button class="delete"></button>
                            Error!
                        </div>
                    </section>
                @endif

                @if(session('status'))
                    <section id="message" class="mt-2">
                        <div class="notification is-primary is-light">
                            <button class="delete"></button>
                            {{ session('status') }}
                        </div>
                    </section>
                @endif

                @if(session('invoice'))
                    <section id="message" class="mt-2">
                        <div class="notification is-primary is-light">
                            <button class="delete"></button>
                            {{ session('invoice') }}
                        </div>
                    </section>
                @endif

                <div class="columns" style="height: 280px">
                    <div class="column">
                        <div class="box mt-2">
                            <div class="field">
                                <label class="label">
                                    {{ $customer->firstname . ' ' . $customer->surname }}
                                </label>
                            </div>

                            <div class="field">
                                <label class="label">
                                    {{ $customer->address1 }}
                                    <br> {{ $customer->address2 }}
                                    <br> {{ $customer->city }}
                                    <br> {{ $customer->postcode }}
                                </label>
                            </div>

                            <div class="field">
                                <label class="label">Mobile - {{ $customer->mobile }}</label>
                                <label class="label">Email - {{ $customer->email }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="column">
                        <div class="box mt-2">
                            <div class="columns">
                                <div class="column">
                                    <label class="label">Select Product:</label>
                                    <div class="select">
                                        <select id="product">
                                            <option disabled selected>Choose</option>
                                            @foreach($products as $product)
                                                <option data-cost="{{ $product->cost }}"
                                                        value="{{ $product->sku }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="column">
                                    <label class="label">Quantity:</label>
                                    <div class="select">
                                        <select id="product_qty">
                                            <option disabled selected>Choose</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="buttons">
                        <button id="preapproval_button" type="submit"
                                class="button is-dark" {{ session('preapproved_button') }}>Preapproval
                        </button>
                        <button id="plan_button" type="submit" class="button is-success" {{ $plan_button ?? '' }}>See
                            Payment Schedule
                        </button>
                        <button id="customer_present_button" type="submit"
                                class="button is-primary" {{ $checkout_button ?? '' }}>Checkout (customer present)
                        </button>
                        <button id="send_customer_button" type="submit"
                                class="button is-warning" {{ $checkout_button ?? '' }}>Checkout (send to customer)
                        </button>
                    </div>
                </div>

                <form id="preapproval_form" action="{{ route('billing.preapproval') }}" method="post">
                    @csrf
                    <input name="f_name" value="{{ $customer->firstname }}" hidden>
                    <input name="s_name" value="{{ $customer->surname }}" hidden>
                    <input name="addr1" value="{{ $customer->address1 }}" hidden>
                    <input name="postcode" value="{{ $customer->postcode }}" hidden>
                </form>

                <form id="plan_form" action="{{ route('billing.plan') }}" method="post">
                    @csrf
                    <input name="amount" value="{{ Cart::total() }}" hidden>
                </form>

                <form id="customer_present_form" action="{{ route('billing.begin', $customer->id) }}" method="post">
                    @csrf
                    <input name="f_name" value="{{ $customer->firstname }}" hidden>
                    <input name="s_name" value="{{ $customer->surname }}" hidden>
                    <input name="addr1" value="{{ $customer->address1 }}" hidden>
                    <input name="addr2" value="{{ $customer->address2 }}" hidden>
                    <input name="city" value="{{ $customer->city }}" hidden>
                    <input name="county" value="{{ $customer->county }}" hidden>
                    <input name="postcode" value="{{ $customer->postcode }}" hidden>
                    <input name="telephone" value="{{ $customer->mobile }}" hidden>
                    <input name="email" value="{{ $customer->email }}" hidden>
                    <input name="amount" value="{{ Cart::total() }}" hidden>
                </form>

                <form id="send_customer_form" action="{{ route('billing.begin', $customer->id) }}" method="post">
                    @csrf
                    <input name="f_name" value="{{ $customer->firstname }}" hidden>
                    <input name="s_name" value="{{ $customer->surname }}" hidden>
                    <input name="addr1" value="{{ $customer->address1 }}" hidden>
                    <input name="addr2" value="{{ $customer->address2 }}" hidden>
                    <input name="city" value="{{ $customer->city }}" hidden>
                    <input name="county" value="{{ $customer->county }}" hidden>
                    <input name="postcode" value="{{ $customer->postcode }}" hidden>
                    <input name="telephone" value="{{ $customer->mobile }}" hidden>
                    <input name="email" value="{{ $customer->email }}" hidden>
                    <input name="amount" value="{{ Cart::total() }}" hidden>
                    <input id="send_email" name="send_email" value="1" hidden>
                    <input id="send_sms" name="send_sms" value="1" hidden>
                </form>

                @if(session('plan'))
                    <div class="box">
                        <strong>Payment Plan</strong>
                        <table id="" class="table is-fullwidth is-hoverable">
                            <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Interest</th>
                                <th>Repayable</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <td><strong>{{ session('plan') }}</strong></td>
                            <td><strong>£{{ substr_replace(session('amount'), '.', -2, 0) }}</strong></td>
                            <td><strong>{{ session('interest') }}% APR</strong></td>
                            <td><strong>£{{ substr_replace(session('repayable'), '.', -2, 0) }}</strong></td>

                            </tbody>
                        </table>

                        <table id="" class="table is-fullwidth is-hoverable">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(session('schedule'))
                                @foreach(session('schedule') as $schedule)
                                    <tr>
                                        @if(\Carbon\Carbon::today()->format('yy-m-d') == $schedule->date)
                                            <td><strong>Today</strong></td>
                                        @else
                                            <td>
                                                <strong>{{ \Carbon\Carbon::createFromDate($schedule->date)->format('d-M-yy') }}</strong>
                                            </td>
                                        @endif
                                        <td><strong>£{{ substr_replace($schedule->amount, '.', -2, 0) }}</strong></td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>


                    </div>
                @endif
                <div class="box">
                    <table id="cart_table" class="table is-fullwidth is-hoverable">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach(Cart::content() as $row)

                            <tr>
                                <td class="w-400">
                                    <p><strong>{{ $row->name }}</strong></p>
                                    <p>{{ ($row->options->has('size') ? $row->options->size : '')}}</p>
                                </td>
                                <td class="w-75"><input class="input" type="text" value="{{ $row->qty }}"></td>
                                <td class="w-75">£{{ $row->price }}</td>
                                <td>£{{ $row->total }}</td>
                                <td>
                                    <form action="{{ route('cart.remove') }}" method="post">
                                        @csrf
                                        <button class="button is-danger">Remove</button>
                                    </form>

                                </td>
                            </tr>

                        @endforeach

                        </tbody>

                        <tfoot>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td>Subtotal</td>
                            <td>£{{ Cart::subtotal() }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td>Tax</td>
                            <td>£{{ Cart::tax() }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td><strong>Total</strong></td>
                            <td><strong>£{{ Cart::total() }}</strong></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>

        <script>

            $(function () {

                $("#product_qty").on('change', function () {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('cart') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'sku': $("#product").val(),
                            'name': $("#product option:selected").html(),
                            'cost': $("#product option:selected").attr("data-cost"),
                            'qty': this.value
                        },
                        success: function (resultData) {
                            $('#cart_table').load(' #cart_table')
                        }
                    });
                });

                $("#preapproval_button").click(function () {
                    $("#preapproval_form").submit();
                });

                $("#plan_button").click(function () {
                    $("#plan_form").submit();
                });

                $("#customer_present_button").click(function () {
                    $("#customer_present_form").submit();
                });

                $("#send_customer_button").click(function () {
                    $("#send_customer_form").submit();
                });

            })

        </script>

@endsection
