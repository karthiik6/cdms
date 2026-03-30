@extends('layouts.marketing')

@php
    $pageTitle = 'CDMS | About';
@endphp

@section('content')
  <section class="hero">
    <div class="mini-label mb-2">About</div>
    <h1 class="section-title fw-bold mb-3">A platform focused on organized community support.</h1>
    <p class="muted mb-4">CDMS is designed to make donation management more transparent, more reliable, and easier to operate for teams serving their communities.</p>

    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Clear Process</h5>
          <p class="muted mb-0">Each role has a defined path so donations and requests move through the system more smoothly.</p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Transparent Data</h5>
          <p class="muted mb-0">Live numbers and structured records make it easier to understand ongoing activity.</p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Community First</h5>
          <p class="muted mb-0">The goal is to help donors, volunteers, and beneficiaries connect through a more dependable system.</p>
        </div>
      </div>
    </div>
  </section>
@endsection
