@extends('layouts.dashboard')

@section('title','My Donations - CDMS')
@section('page_title','My Donations')
@section('page_subtitle','Track all donation entries and item details.')

@section('sidebar')
  <a href="/dashboard" class="nav-link">Dashboard</a>
  <a href="/donations" class="nav-link active">My Donations</a>
  <a href="/donations/create" class="nav-link">Submit Donation</a>
@endsection

@section('content')
  <div class="d-flex justify-content-end mb-3">
    <a href="/donations/create" class="btn btn-primary">+ Submit Donation</a>
  </div>

  @foreach($donations as $d)
    <div class="card-glass p-3 mb-3">
      <div class="d-flex flex-wrap gap-3 mb-2">
        <div><b>Status:</b> {{ $d->status }}</div>
        <div><b>Date:</b> {{ $d->donation_date ?? 'N/A' }}</div>
      </div>
      <div class="fw-semibold mb-1">Items</div>
      <ul class="mb-0">
        @foreach($d->items as $it)
          <li>{{ $it->category }} | {{ $it->size }} | {{ $it->condition }} | Qty: {{ $it->quantity }}</li>
        @endforeach
      </ul>
    </div>
  @endforeach
@endsection
