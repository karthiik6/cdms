@extends('layouts.auth')

@section('title', 'Register - CDMS')
@section('heading', 'Create your account')
@section('subheading', 'Join as a donor, volunteer, or customer.')

@section('content')
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="/register" class="mt-2">
    @csrf

    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Your name" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="you@example.com" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Phone Number</label>
      <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Enter your contact number" required>
      <div class="muted mt-1" style="font-size:.9rem;">Used for volunteer coordination, pickup, and delivery updates.</div>
    </div>

    @if(!empty($role))
      <input type="hidden" name="role" value="{{ $role }}">
      <div class="mb-3">
        <label class="form-label">Role</label>
        <input class="form-control" value="{{ ucfirst($role) }}" disabled>
      </div>
    @else
      <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
          <option value="">-- choose --</option>
          <option value="donor">Donor</option>
          <option value="volunteer">Volunteer</option>
          <option value="customer">Customer</option>
        </select>
      </div>
    @endif

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Create a strong password" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Confirm Password</label>
      <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
    </div>

    <button class="btn btn-success w-100 py-2 fw-semibold" type="submit">Create Account</button>

    <div class="d-flex justify-content-between mt-3">
      <span class="muted">Already registered?</span>
      <a href="/login" class="text-decoration-none">Login</a>
    </div>
  </form>
@endsection
