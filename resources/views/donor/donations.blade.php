@extends('layouts.dashboard')

@section('title','My Donations - CDMS')
@section('page_title','My Donations')
@section('page_subtitle','Track donation status and details.')

@section('sidebar')
  <a class="nav-link" href="{{ url('/donor/dashboard') }}">Overview</a>
  <a class="nav-link" href="{{ url('/donations/create') }}">Submit Donation</a>
  <a class="nav-link active" href="{{ url('/donations') }}">Track Donations</a>
@endsection

@section('top_actions')
  <a class="btn btn-success" href="{{ url('/donations/create') }}">+ Submit</a>
@endsection

@section('content')

  <form method="GET" action="{{ url('/donations') }}" class="mb-3" style="display:flex; gap:10px; flex-wrap:wrap;">
    <select name="status" style="padding:6px 10px;">
      <option value="">All Status</option>
      <option value="Pending" {{ ($status ?? '')=='Pending'?'selected':'' }}>Pending</option>
      <option value="Collected" {{ ($status ?? '')=='Collected'?'selected':'' }}>Collected</option>
      <option value="Distributed" {{ ($status ?? '')=='Distributed'?'selected':'' }}>Distributed</option>
    </select>
    <button type="submit" class="btn btn-outline-light btn-sm">Filter</button>
    <a href="{{ url('/donations') }}" class="btn btn-outline-light btn-sm">Reset</a>
  </form>

  @forelse($donations as $d)
    <div class="card-glass p-3 mb-3">
      <div class="d-flex justify-content-between flex-wrap gap-2">
  <div>
    <div class="fw-semibold">Donation #{{ $d->id }}</div>
    <div class="muted">Status: {{ $d->status }}</div>
  </div>

  <div class="muted">
    Date: {{ $d->donation_date ?? $d->created_at->toDateString() }}
  </div>
</div>

@if($d->photo)
  <div style="margin-top:10px;">
    <img src="{{ asset('storage/'.$d->photo) }}"
         style="max-width:220px;border-radius:12px;">
  </div>
@endif

<hr style="border-color: rgba(255,255,255,.12);">
      <div class="muted mb-3">
        <b>Pickup Address:</b><br>
        {{ $d->pickup_address }}
      </div>
      </div>

      <hr style="border-color: rgba(255,255,255,.12);">

      <b>Items:</b>
      <ul class="mb-0">
        @foreach($d->items as $it)
          <li>{{ $it->category }} | {{ $it->size }} | {{ $it->condition }} | Qty: {{ $it->quantity }}</li>
        @endforeach
      </ul>
    </div>
  @empty
    <div class="card-glass p-4">
      <div class="fw-semibold">No donations found</div>
      <div class="muted">Try submitting a donation first.</div>
    </div>
  @endforelse

@endsection
