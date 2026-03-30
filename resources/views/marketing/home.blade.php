@extends('layouts.marketing')

@php
    $pageTitle = 'CDMS | Home';
@endphp

@section('content')
  <section class="hero mb-5">
    <div class="row g-4 align-items-center">
      <div class="col-12 col-lg-7">
        <div class="mini-label mb-2">Home</div>
        <p class="muted mb-4">
          Welcome to CDMS. Manage donations, volunteer support, and clothing distribution from one place.
        </p>

        <div class="hero-actions d-flex flex-column flex-sm-row gap-3 mb-3">
          <a href="/register?role=donor" class="btn btn-brand px-4 py-3">Join as Donor</a>
          <a href="/register?role=volunteer" class="btn btn-soft px-4 py-3">Join as Volunteer</a>
          <a href="/register?role=customer" class="btn btn-soft px-4 py-3">Request Support</a>
        </div>

        <div class="d-flex flex-wrap gap-3 small">
          <a href="/login?role=donor" class="contact-link">Donor Login</a>
          <a href="/login?role=volunteer" class="contact-link">Volunteer Login</a>
          <a href="/login?role=customer" class="contact-link">Customer Login</a>
        </div>
      </div>

      <div class="col-12 col-lg-5">
        <div class="card-simple p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="fw-bold mb-1">Live Update</h5>
              <p class="muted mb-0">Current system totals</p>
            </div>
            <span class="mini-label">Active</span>
          </div>

          <div class="stats-grid">
            <div class="stat-box">
              <span class="muted small">Donors</span>
              <strong>{{ number_format($publicStats['donors'] ?? 0) }}</strong>
            </div>
            <div class="stat-box">
              <span class="muted small">Volunteers</span>
              <strong>{{ number_format($publicStats['volunteers'] ?? 0) }}</strong>
            </div>
            <div class="stat-box">
              <span class="muted small">Donations</span>
              <strong>{{ number_format($publicStats['donations'] ?? 0) }}</strong>
            </div>
            <div class="stat-box">
              <span class="muted small">Stock Units</span>
              <strong>{{ number_format($publicStats['inventory_stock'] ?? 0) }}</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="row g-4">
      <div class="col-12 col-md-6 col-xl-3">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Donation Flow</h5>
          <p class="muted mb-0">Support donors with a simple path from registration to donation tracking.</p>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-3">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Volunteer Tasks</h5>
          <p class="muted mb-0">Keep pickups, delivery work, and assignments organized for your volunteer team.</p>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-3">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Inventory Tracking</h5>
          <p class="muted mb-0">View stock totals clearly and plan distribution more confidently.</p>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-3">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Admin Control</h5>
          <p class="muted mb-0">Review requests, donations, and system activity from one platform.</p>
        </div>
      </div>
    </div>
  </section>
@endsection
