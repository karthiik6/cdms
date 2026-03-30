@extends('layouts.dashboard')

@section('title','Volunteer Dashboard - CDMS')
@section('page_title','Volunteer Dashboard')
@section('page_subtitle','View assigned tasks and mark them completed.')

@section('sidebar')
  <a class="nav-link active" href="{{ url('/volunteer/dashboard') }}">Overview</a>
  <a class="nav-link" href="{{ url('/tasks') }}">My Tasks</a>
  <a class="nav-link" href="{{ url('/volunteer/customer-requests') }}">Approved Customer Requests</a>
@endsection

@section('top_actions')
  <a class="btn btn-primary" href="{{ url('/tasks') }}">Open Tasks</a>
@endsection

@section('content')
  <div class="card-glass p-4 mb-4">
    <h5 class="fw-semibold mb-3">Key Metrics</h5>
    <div class="row g-3">
      <div class="col-12 col-md-4"><div class="kpi"><span class="muted">Assigned Tasks</span><b>{{ $stats['assigned_tasks'] }}</b></div></div>
      <div class="col-12 col-md-4"><div class="kpi"><span class="muted">Pending</span><b>{{ $stats['pending_tasks'] }}</b></div></div>
      <div class="col-12 col-md-4"><div class="kpi"><span class="muted">Completed</span><b>{{ $stats['completed_tasks'] }}</b></div></div>
      <div class="col-12 col-md-6"><div class="kpi"><span class="muted">Pickup Tasks</span><b>{{ $stats['pickup_tasks'] }}</b></div></div>
      <div class="col-12 col-md-6"><div class="kpi"><span class="muted">Distribution Tasks</span><b>{{ $stats['distribution_tasks'] }}</b></div></div>
    </div>
  </div>

  <div class="card-glass p-4 mb-4">
    <h5 class="fw-semibold mb-3">Primary Actions</h5>
    <div class="row g-3">
      <div class="col-12 col-md-6">
        <div class="kpi">
          <div>
            <div class="muted">Tasks</div>
            <div class="fw-bold">Review Assigned Work</div>
          </div>
          <a href="{{ url('/tasks') }}" class="btn btn-outline-light btn-sm">Open</a>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="kpi">
          <div>
            <div class="muted">Requests</div>
            <div class="fw-bold">Approved Customer Requests</div>
          </div>
          <a href="{{ url('/volunteer/customer-requests') }}" class="btn btn-outline-light btn-sm">Open</a>
        </div>
      </div>
    </div>
  </div>

  <div class="card-glass p-4">
    <h5 class="fw-semibold mb-2">Quick Tips</h5>
    <ul class="muted mb-0">
      <li>Complete tasks only after physical pickup or delivery is done.</li>
      <li>Use task notes to track handover details and exceptions.</li>
    </ul>
  </div>
@endsection
