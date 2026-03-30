@extends('layouts.auth')

@section('title', 'Login - CDMS')
@section('heading', 'Welcome back')
@section('subheading', 'Login to manage donations, tasks, requests, and inventory.')

@section('content')
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  @if(empty($role))
    <div class="alert alert-warning">
      Role not selected. Choose a role login from the home page for best experience.
    </div>
  @endif

  <form method="POST" action="{{ route('login.post') }}">
    @csrf
    <input type="hidden" name="role" value="{{ $role ?? '' }}">

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="you@example.com" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
    </div>

    <button class="btn btn-primary w-100 py-2 fw-semibold" type="submit">Login</button>

    <div class="d-flex justify-content-between mt-3">
      <span class="muted">No account yet?</span>
      <a href="/register" class="text-decoration-none">Create one</a>
    </div>
  </form>
@endsection
