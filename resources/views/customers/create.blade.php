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
                                API Demo.
                            </h1>
                            <h2 class="subtitle">
                                Customers!
                            </h2>
                        </div>
                    </div>
                </section>

                <div class="box mt-2">
                    <form action="{{ route('customers.store') }}" method="post">
                        @csrf
                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label">First Name</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="firstname" class="input" type="text" placeholder="First Name" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Address1</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="address1" class="input" type="text" placeholder="Address1" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-home"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Town/City</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="city" class="input" type="text" placeholder="Town/City" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-city"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Postcode</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="postcode" class="input" type="text" placeholder="Postcode" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-city"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Create Customer</label>
                                    <button class="button is-primary">Create</button>

                                </div>
                            </div>

                            <div class="column">
                                <div class="field">
                                    <label class="label">Surname</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="surname" class="input" type="text" placeholder="Surname" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Address2</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="address2" class="input" type="text" placeholder="Address2">
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-home"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">County</label>
                                    <div class="select">
                                        <select name="county" required>
                                            <option disabled selected>Select County</option>
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

                                <div class="field">
                                    <label class="label">Mobile</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="mobile" class="input" type="text" placeholder="Mobile" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-mobile"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Email</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="email" class="input" type="text" placeholder="Email" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-envelope-open"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
