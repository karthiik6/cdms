@extends('layouts.dashboard')

@section('title','Customer Dashboard - CDMS')
@section('page_title','Customer Dashboard')
@section('page_subtitle','Browse products and track request approvals.')

@section('sidebar')
  <a class="nav-link active" href="{{ url('/customer/dashboard') }}">Overview</a>
  <a class="nav-link" href="{{ url('/customer/products') }}">Products</a>
  <a class="nav-link" href="{{ url('/customer/requests') }}">My Requests</a>
@endsection

@section('top_actions')
  <a class="btn btn-primary" href="{{ url('/customer/products') }}">Browse Products</a>
@endsection

@section('content')
  <div class="card-glass p-4 mb-4">
    <h5 class="fw-semibold mb-3">Key Metrics</h5>
    <div class="row g-3">
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">My Requests</span><b>{{ $stats['my_requests'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Pending</span><b>{{ $stats['pending_requests'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Approved</span><b>{{ $stats['approved_requests'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Rejected</span><b>{{ $stats['rejected_requests'] }}</b></div></div>
    </div>
  </div>

  <div class="card-glass p-4 mb-4">
    <h5 class="fw-semibold mb-3">Primary Actions</h5>
    <div class="row g-3">
      <div class="col-12 col-md-6">
        <div class="kpi">
          <div>
            <div class="muted">Products</div>
            <div class="fw-bold">Create New Request</div>
          </div>
          <a href="{{ url('/customer/products') }}" class="btn btn-outline-light btn-sm">Open</a>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="kpi">
          <div>
            <div class="muted">History</div>
            <div class="fw-bold">View All Requests</div>
          </div>
          <a href="{{ url('/customer/requests') }}" class="btn btn-outline-light btn-sm">Open</a>
        </div>
      </div>
    </div>
  </div>

  <div class="card-glass p-4">
    <h5 class="fw-semibold mb-2">Quick Tips</h5>
    <ul class="muted mb-0">
      <li>Request only available quantities to avoid rejection.</li>
      <li>Add a short note when your request has urgent requirements.</li>
    </ul>
  </div>
@endsection
