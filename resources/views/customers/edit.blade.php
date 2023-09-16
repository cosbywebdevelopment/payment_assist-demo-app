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
                                Hello, {{ Auth::user()->name }}.
                            </h1>
                            <h2 class="subtitle">
                                Welcome to your Customers Page!
                            </h2>
                        </div>
                    </div>
                </section>

                <div class="box mt-2">
                    <form action="{{ route('customers.update', $customer->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label">First Name</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="firstname" class="input" type="text" placeholder="First Name" value="{{ $customer->firstname }}" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Address1</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="address1" class="input" type="text" placeholder="Address1" value="{{ $customer->address1 }}" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-home"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Town/City</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="city" class="input" type="text" placeholder="Town/City" value="{{ $customer->city }}" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-city"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Mobile</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="mobile" class="input" type="text" placeholder="Mobile" value="{{ $customer->mobile }}" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-mobile"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Update Customer</label>
                                    <button class="button is-primary">Update</button>
                                </div>

                            </div>

                            <div class="column">
                                <div class="field">
                                    <label class="label">Surname</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="surname" class="input" type="text" placeholder="Surname" value="{{ $customer->surname }}" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Address2</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="address2" class="input" type="text" placeholder="Address2" value="{{ $customer->address2 }}" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-home"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Postcode</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="postcode" class="input" type="text" placeholder="Postcode" value="{{ $customer->postcode }}" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-city"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Email</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="email" class="input" type="text" placeholder="Email" value="{{ $customer->email }}" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-envelope-open"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">County</label>
                                    <div class="select">
                                        <select name="county" required>
                                            <option selected>{{ $customer->county }}</option>
                                            <optgroup label="England">
                                                @foreach($counties['England'] as $county)
                                                    <option>{{ $county }}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Wales">
                                                @foreach($counties['Wales'] as $county)
                                                    <option>{{ $county }}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Scotland">
                                                @foreach($counties['Scotland'] as $county)
                                                    <option>{{ $county }}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Northern Ireland">
                                                @foreach($counties['Northern Ireland'] as $county)
                                                    <option>{{ $county }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <div class="box mt-2">
                    <p><strong>Recent Orders</strong></p>
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
                                        <td></td>
                                        <td>
                                            <i id="spin-{{ $order->id }}" class="fas fa-spinner fa-spin"></i>
                                        </td>
                                        @else
                                            <td>
                                                @if(!$order->invoiced)
                                                    <a href="{{ route('billing.invoice', $order->id) }}" class="button is-link" {{ $invoice_button ?? '' }}>Upload Invoice</a>
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>

@endsection
