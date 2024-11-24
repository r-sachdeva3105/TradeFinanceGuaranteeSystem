@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section -->
    <div class="hero text-center text-white d-flex flex-column justify-content-center align-items-center" style="height: 100vh; background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('bg.png') center/cover;">
        <h1 class="display-3">Welcome to Trade Finance Guarantee System</h1>
        <p class="lead mt-3">Streamline your guarantee management process with ease and efficiency.</p>
        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mx-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-secondary btn-lg mx-2">Register</a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5 text-center">
        <h2 class="mb-4">Our Features</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <i class="bi bi-shield-lock display-4 text-primary"></i>
                    <h4 class="mt-3">Secure Platform</h4>
                    <p>Your data is protected with top-notch security measures.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <i class="bi bi-speedometer2 display-4 text-success"></i>
                    <h4 class="mt-3">Fast Processing</h4>
                    <p>Quickly create and manage guarantees with minimal effort.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <i class="bi bi-people display-4 text-warning"></i>
                    <h4 class="mt-3">User Friendly</h4>
                    <p>An intuitive design for seamless user experience.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call-to-Action Section -->
    <div class="text-center text-white py-5" style="background-color: #343a40;">
        <h2>Ready to Get Started?</h2>
        <p class="lead">Sign up today and experience the ease of managing guarantees.</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg">Get Started</a>
    </div>
</div>
@endsection