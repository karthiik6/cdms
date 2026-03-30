@extends('layouts.dashboard')

@section('title','Approved Customer Requests - CDMS')
@section('page_title','Approved Customer Requests')
@section('page_subtitle','View approved requests with delivery location for execution.')

@section('sidebar')
  <a class="nav-link" href="{{ url('/volunteer/dashboard') }}">Overview</a>
  <a class="nav-link" href="{{ url('/tasks') }}">My Tasks</a>
  <a class="nav-link active" href="{{ url('/volunteer/customer-requests') }}">Customer Requests</a>
@endsection

@section('content')
  @forelse($requests as $r)
    <div class="card-glass p-4 mb-3">
      <div class="fw-semibold">Request #{{ $r->id }}</div>
      <div class="muted">Customer: {{ $r->customer->name }} ({{ $r->customer->email }})</div>
      <div class="muted">Status: <b>{{ $r->status }}</b></div>
      @if($r->delivery_location)
        <div class="muted">Location: <b>{{ $r->delivery_location }}</b></div>
      @endif
      <div class="muted">Total Donor Donations: <b>{{ $r->donations_count }}</b></div>

      <hr style="border-color: rgba(255,255,255,.12);">

      <ul class="mb-0">
        @foreach($r->items as $it)
          <li class="muted">
            {{ $it->inventory->item->category ?? '-' }}
            | {{ $it->inventory->item->size ?? '-' }}
            | Qty: {{ $it->quantity }}
          </li>
        @endforeach
      </ul>
    </div>
  @empty
    <div class="card-glass p-4">
      <div class="fw-semibold">No approved requests yet</div>
      <div class="muted">Approved customer requests will show here.</div>
    </div>
  @endforelse
@endsection
