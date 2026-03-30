@extends('layouts.dashboard')

@section('title','Beneficiaries - CDMS')
@section('page_title','Beneficiaries')
@section('page_subtitle','Coming soon module')

@section('sidebar')
  <a class="nav-link" href="/admin/dashboard">Overview</a>
  <a class="nav-link" href="/admin/donations">Donations</a>
  <a class="nav-link" href="/admin/inventory">Inventory</a>
  <a class="nav-link active" href="/admin/beneficiaries">Beneficiaries</a>
@endsection

@section('top_actions')
  <span class="btn btn-outline-light disabled">Coming Soon</span>
@endsection

@section('content')
  <div class="card-glass p-4">
    <h5 class="fw-semibold mb-2">Beneficiary Module (Coming Soon)</h5>
    <p class="muted mb-0">
      This section will handle beneficiary registration, clothing requests, approval, allocation, and distribution tracking.
    </p>
    <hr style="border-color: rgba(255,255,255,.12);">
    <ul class="muted mb-0">
      <li>Create beneficiaries</li>
      <li>Submit requests (category/size/quantity)</li>
      <li>Admin approval + inventory allocation</li>
      <li>Assign volunteer for distribution</li>
      <li>Track request status (Pending → Approved → Completed)</li>
    </ul>
  </div>
@endsection