<aside class="menu is-hidden-mobile">
    <p class="menu-label">
        General
    </p>
    <ul class="menu-list">
        <li><a class="{{ Request::is('dashboard') ? 'is-active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a></li>
    </ul>
    <p class="menu-label">
        Accounts
    </p>
    <ul class="menu-list">
        <li><a class="{{ Request::is('customers') ? 'is-active' : '' }}" href="{{ route('customers.index') }}">Customers</a></li>
        <li><a class="{{ Request::is('customers/create') ? 'is-active' : '' }}" href="{{ route('customers.create') }}">Add New Customer</a></li>
        <li><a class="{{ Request::is('orders') ? 'is-active' : '' }}" href="{{ route('orders') }}">Orders</a></li>
        @if(isset($order) && Request::is('orders*'))
            <li><a class="{{ Request::is('orders*') ? 'is-active' : '' }}" href="">Order Number {{ isset($order) ? ':- ' . $order->id . ' ' . $order->customer->surname : '' }}</a></li>
        @endif
    </ul>
    <p class="menu-label">
        Products
    </p>
    <ul class="menu-list">
        <li><a class="{{ Request::is('tyres*') ? 'is-active' : '' }}" href="{{ route('tyres.index') }}">Tyres</a></li>
    </ul>
    <p class="menu-label">
        Billing
    </p>
    <ul class="menu-list">
        @if(isset($customer) && Request::is('billing/customer*'))
            <li><a class="{{ Request::is('billing/customer*') ? 'is-active' : '' }}" href="{{ route('customers.index') }}">Customer {{ isset($customer) ? ':- ' . $customer->firstname . ' ' . $customer->surname : '' }}</a></li>
        @endif
    </ul>
</aside>
