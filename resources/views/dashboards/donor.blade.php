@extends('layouts.dashboard')

@section('title','Donor Dashboard - CDMS')
@section('page_title','Donor Dashboard')
@section('page_subtitle','Submit donations and track their status.')

@section('sidebar')
  <a class="nav-link active" href="{{ url('/donor/dashboard') }}">Overview</a>
  <a class="nav-link" href="{{ url('/donations/create') }}">Submit Donation</a>
  <a class="nav-link" href="{{ url('/donations') }}">Track Donations</a>
  <a class="nav-link" href="{{ url('/donor/customer-requests') }}">Approved Customer Requests</a>
@endsection

@section('top_actions')
  <a class="btn btn-success" href="{{ url('/donations/create') }}">+ Submit Donation</a>
@endsection

@section('content')
  <div class="card-glass p-4 mb-4">
    <h5 class="fw-semibold mb-3">Key Metrics</h5>
    <div class="row g-3">
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">My Donations</span><b>{{ $stats['my_donations'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Pending</span><b>{{ $stats['pending_donations'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Collected</span><b>{{ $stats['collected_donations'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Distributed</span><b>{{ $stats['distributed_donations'] }}</b></div></div>
    </div>
  </div>

  <div class="card-glass p-4 mb-4">
    <h5 class="fw-semibold mb-3">Primary Actions</h5>
    <div class="row g-3">
      <div class="col-12 col-md-6">
        <div class="kpi">
          <div>
            <div class="muted">Submit</div>
            <div class="fw-bold">Create New Donation</div>
          </div>
          <a href="{{ url('/donations/create') }}" class="btn btn-outline-light btn-sm">Open</a>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="kpi">
          <div>
            <div class="muted">Track</div>
            <div class="fw-bold">View Donation Status</div>
          </div>
          <a href="{{ url('/donations') }}" class="btn btn-outline-light btn-sm">Open</a>
        </div>
      </div>
    </div>
  </div>

  <div class="card-glass p-4">
    <h5 class="fw-semibold mb-2">Quick Tips</h5>
    <ul class="muted mb-0">
      <li>Add accurate size and condition details for faster pickup.</li>
      <li>Check status updates regularly to know when items are distributed.</li>
    </ul>
  </div>
@endsection
