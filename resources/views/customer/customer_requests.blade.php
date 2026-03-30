@extends('layouts.dashboard')

@section('title','Customer Requests - CDMS')
@section('page_title','Customer Requests')
@section('page_subtitle','Approve or reject customer purchase requests.')

@section('sidebar')
  <a class="nav-link" href="{{ url('/admin/dashboard') }}">Overview</a>
  <a class="nav-link" href="{{ url('/admin/donations') }}">Donations</a>
  <a class="nav-link" href="{{ url('/admin/inventory') }}">Inventory</a>
  <a class="nav-link active" href="{{ url('/admin/customer-requests') }}">Customer Requests</a>
@endsection

@section('content')

  @if(session('success'))
    <div class="card-glass p-3 mb-3" style="border:1px solid rgba(34,197,94,.35);">
      <div class="fw-semibold">Success</div>
      <div class="muted">{{ session('success') }}</div>
    </div>
  @endif
  @if(session('error'))
    <div class="card-glass p-3 mb-3" style="border:1px solid rgba(239,68,68,.35);">
      <div class="fw-semibold">Error</div>
      <div class="muted">{{ session('error') }}</div>
    </div>
  @endif

  @forelse($requests as $r)
    <div class="card-glass p-4 mb-3">
      <div class="d-flex justify-content-between flex-wrap gap-2">
        <div>
          <div class="fw-semibold">Request #{{ $r->id }}</div>
          <div class="muted">Customer: {{ $r->customer->name }} ({{ $r->customer->email }})</div>
          <div class="muted">Status: <b>{{ $r->status }}</b></div>
        </div>
        <div class="muted">{{ $r->created_at->toDateString() }}</div>
      </div>

      @if($r->note)
        <div class="muted mt-2">Note: {{ $r->note }}</div>
      @endif

      <hr style="border-color: rgba(255,255,255,.12);">

      <ul class="mb-3">
        @foreach($r->items as $it)
          <li class="muted">
            {{ $it->inventory->item->category ?? '-' }}
            | {{ $it->inventory->item->size ?? '-' }}
            | Qty: {{ $it->quantity }}
            (Available: {{ $it->inventory->available_quantity ?? 0 }})
          </li>
        @endforeach
      </ul>

      @if($r->status === 'Pending')
        <div class="d-flex gap-2 flex-wrap">
          <form method="POST" action="{{ url('/admin/customer-requests/'.$r->id.'/approve') }}">
            @csrf
            <button class="btn btn-success">Approve</button>
          </form>
          <form method="POST" action="{{ url('/admin/customer-requests/'.$r->id.'/reject') }}">
            @csrf
            <button class="btn btn-outline-danger">Reject</button>
          </form>
        </div>
      @endif
    </div>
  @empty
    <div class="card-glass p-4">
      <div class="fw-semibold">No customer requests</div>
      <div class="muted">When customers submit, they appear here.</div>
    </div>
  @endforelse

@endsection