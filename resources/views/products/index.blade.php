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
                        <a class="button is-primary" href="{{ route('tyres.create') }}">Add New Tyres</a>
                    </div>
                    <table class="table is-hoverable is-fullwidth">
                        <thead>
                        <tr>
                            <th>Product Sku</th>
                            <th>Product Name/Brand</th>
                            <th>Product Description</th>
                            <th>Cost</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->cost }}</td>
                                <td>
                                    <a class="button is-dark" href="{{ route('tyres.edit', $product->id) }}">
                                        Edit
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('tyres.destroy', $product->id) }}" method="POST" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button is-danger">
                                            Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>

@endsection
