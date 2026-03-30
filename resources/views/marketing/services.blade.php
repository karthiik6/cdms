@extends('layouts.marketing')

@php
    $pageTitle = 'CDMS | Services';
@endphp

@section('content')
  <section class="hero mb-4">
    <div class="mini-label mb-2">Services</div>
    <h1 class="section-title fw-bold mb-3">Core services for a cleaner donation workflow.</h1>
    <p class="muted mb-0">CDMS supports the full cycle of receiving, managing, and distributing clothing donations with a simple and professional interface.</p>
  </section>

  <section>
    <div class="row g-4">
      <div class="col-12 col-md-6">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Donor Management</h5>
          <p class="muted mb-0">Enable donors to register, create donations, and follow progress without unnecessary complexity.</p>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Volunteer Coordination</h5>
          <p class="muted mb-0">Assign pickups and deliveries so volunteers can work with clearer responsibilities.</p>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Inventory Control</h5>
          <p class="muted mb-0">Track available clothing stock and keep item quantities visible for better planning.</p>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Request Oversight</h5>
          <p class="muted mb-0">Help administrators review requests and make distribution decisions more efficiently.</p>
        </div>
      </div>
    </div>
  </section>
@endsection
