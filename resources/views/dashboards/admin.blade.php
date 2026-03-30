@extends('layouts.dashboard')

@section('title','Admin Dashboard - CDMS')
@section('page_title','Admin Dashboard')
@section('page_subtitle','Manage donations, volunteers, inventory and workflow.')

@section('sidebar')
  <a class="nav-link active" href="{{ url('/admin/dashboard') }}">Overview</a>
  <a class="nav-link" href="{{ url('/admin/donations') }}">Donations</a>
  <a class="nav-link" href="{{ url('/admin/inventory') }}">Inventory</a>
  <a class="nav-link" href="{{ url('/admin/beneficiaries') }}">Beneficiaries</a>
  <a class="nav-link" href="/admin/customer-requests">Customer Requests</a>
@endsection

@section('top_actions')
  <a class="btn btn-primary" href="{{ url('/admin/donations') }}">Go to Donations</a>
@endsection

@section('content')

  <div class="card-glass p-4 mb-4">
    <h5 class="fw-semibold mb-3">Key Metrics</h5>
    <div class="row g-3">
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Users</span><b>{{ $stats['total_users'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Donors</span><b>{{ $stats['total_donors'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Volunteers</span><b>{{ $stats['total_volunteers'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Donations</span><b>{{ $stats['total_donations'] }}</b></div></div>

      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Inventory Rows</span><b>{{ $stats['inventory_rows'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Total Stock</span><b>{{ $stats['inventory_stock'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Tasks</span><b>{{ $stats['tasks_total'] }}</b></div></div>
      <div class="col-12 col-md-3"><div class="kpi"><span class="muted">Completed</span><b>{{ $stats['tasks_completed'] }}</b></div></div>
    </div>
  </div>

  <div class="card-glass p-4 mb-4">
    <h5 class="fw-semibold mb-3">Primary Actions</h5>
    <div class="row g-3">
      <div class="col-12 col-md-4">
        <div class="kpi">
          <div>
            <div class="muted">Donations</div>
            <div class="fw-bold">Review and Assign</div>
          </div>
          <a href="{{ url('/admin/donations') }}" class="btn btn-outline-light btn-sm">Open</a>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="kpi">
          <div>
            <div class="muted">Inventory</div>
            <div class="fw-bold">Track Stock</div>
          </div>
          <a href="{{ url('/admin/inventory') }}" class="btn btn-outline-light btn-sm">Open</a>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="kpi">
          <div>
            <div class="muted">Customer Requests</div>
            <div class="fw-bold">Approve or Reject</div>
          </div>
          <a href="{{ url('/admin/customer-requests') }}" class="btn btn-outline-light btn-sm">Open</a>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-12 col-md-4">
      <div class="kpi">
        <div>
          <div class="muted">Tasks</div>
          <div class="fw-bold">Total</div>
        </div>
        <span class="fw-bold">{{ $stats['tasks_total'] }}</span>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="kpi">
        <div>
          <div class="muted">Tasks</div>
          <div class="fw-bold">Completed</div>
        </div>
        <span class="fw-bold">{{ $stats['tasks_completed'] }}</span>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="kpi">
        <div>
          <div class="muted">Inventory</div>
          <div class="fw-bold">Total Stock</div>
        </div>
        <span class="fw-bold">{{ $stats['inventory_stock'] }}</span>
      </div>
    </div>
  </div>

  <div class="card-glass p-4 mt-4">
    <h5 class="fw-semibold mb-2">Quick Actions</h5>
    <p class="muted mb-3">Use these to manage the system faster.</p>
    <div class="d-flex flex-wrap gap-2">
      <a href="{{ url('/admin/donations') }}" class="btn btn-primary">Assign Pickup Tasks</a>
      <a href="{{ url('/admin/inventory') }}" class="btn btn-success">Update Inventory</a>
    </div>
  </div>

@endsection
