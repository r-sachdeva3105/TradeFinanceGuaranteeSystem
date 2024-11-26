@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row h-screen">
        <aside class="col-md-2 p-0 vh-100">
            <div class="bg-dark text-white p-4 h-100">
                <h1 class="text-center bold">Admin Panel</h1>
                <ul class="list-unstyled text-center mt-5">
                    <li><a href="{{ route('dashboard.admin') }}" class="text-white h4 text-decoration-none d-block p-2">Dashboard</a></li>
                    <li><a href="{{ route('admin.users') }}" class="text-white h4 text-decoration-none d-block p-2">Users</a></li>
                    <li><a href="{{ route('admin.guarantees') }}" class="text-white h4 text-decoration-none d-block p-2">Guarantees</a></li>
                    <li><a href="{{ route('admin.files') }}" class="text-white h4 text-decoration-none d-block p-2">Files</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="col-md-10">
            <div class="content p-4">
                <h1>Welcome to the Admin Dashboard, {{ auth()->user()->name }}</h1>

                @if(isset($message))
                <div class="alert alert-info">
                    {{ $message }}
                </div>
                @endif

                <div class="row flex gap-4 mt-4">
                    <div class="col-md border p-4 rounded">
                        <h3>Total Users</h3>
                        <p class="display-5">{{ $users }}</p> <!-- Display total number of users -->
                    </div>
                    <div class="col-md border p-4 rounded">
                        <h3>Total Guarantees</h3>
                        <p class="display-5">{{ $guarantees }}</p> <!-- Display total number of guarantees -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection