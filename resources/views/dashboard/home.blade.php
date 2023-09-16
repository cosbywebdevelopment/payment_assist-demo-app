@extends('layouts.dashboard')

@section('content')

    <div class="container">
        <div class="columns">
            <div class="column is-3 ">
                @include('partials._nav')
            </div>
            <div class="column is-9">
                @include('partials._header')
                <section class="info-tiles">
                    <div class="tile is-ancestor has-text-centered">
                        <div class="tile is-parent">
                            <article class="tile is-child box">
                                <p class="title">{{ $customers + 3}}</p>
                                <p class="subtitle">Customers</p>
                            </article>
                        </div>
                        <div class="tile is-parent">
                            <article class="tile is-child box">
                                <p class="title">{{ $products + 1 }}</p>
                                <p class="subtitle">Products</p>
                            </article>
                        </div>
                        <div class="tile is-parent">
                            <article class="tile is-child box">
                                <p class="title">{{ $orders }}</p>
                                <p class="subtitle">Orders</p>
                            </article>
                        </div>
                    </div>
                </section>
                <div class="columns">
                    <div class="column is-6">

                    </div>
                    <div class="column is-6">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
