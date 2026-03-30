@extends('layouts.marketing')

@php
    $pageTitle = 'CDMS | Contact';
@endphp

@section('content')
  <section class="hero mb-4">
    <div class="mini-label mb-2">Contact</div>
    <h1 class="section-title fw-bold mb-3">Stay connected with your donation team.</h1>
    <p class="muted mb-0">Use these contact blocks as placeholders now, and replace them later with your organization’s real details.</p>
  </section>

  <section>
    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Office</h5>
          <p class="muted mb-0">CDMS Operations Center<br>Community Donation Services<br>Clothing Distribution Hub</p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Reach Us</h5>
          <p class="mb-2"><a href="mailto:support@cdms.local" class="contact-link">support@cdms.local</a></p>
          <p class="mb-0"><a href="tel:+910000000000" class="contact-link">+91 00000 00000</a></p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card-simple info-card">
          <h5 class="fw-bold mb-2">Quick Access</h5>
          <p class="mb-2"><a href="/login?role=admin" class="contact-link">Admin Portal</a></p>
          <p class="mb-2"><a href="/register?role=donor" class="contact-link">Become a Donor</a></p>
          <p class="mb-0"><a href="/register?role=volunteer" class="contact-link">Volunteer Registration</a></p>
        </div>
      </div>
    </div>
  </section>
@endsection
