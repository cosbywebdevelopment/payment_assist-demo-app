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
                                F1 Tyres.
                            </h1>
                            <h2 class="subtitle">
                                Tyres!
                            </h2>
                        </div>
                    </div>
                </section>

                <div class="box mt-2">
                    <form action="{{ route('tyres.store') }}" method="post">
                        @csrf
                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label">Tyre Name/Brand</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="type" value="tyre" hidden>
                                        <input name="name" class="input" type="text" placeholder="Tyre Name/Brand" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-car"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Cost</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="cost" class="input" type="text" placeholder="Cost" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-pound-sign"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Sku Number</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input name="sku" class="input" type="text" placeholder="Sku Number" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-folder-plus"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Add Tyre</label>
                                    <button class="button is-primary">Add</button>
                                </div>

                            </div>

                            <div class="column">
                                <div class="field">
                                    <label class="label">Description</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <textarea name="description" class="textarea" placeholder="Description" rows="4"></textarea>
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
