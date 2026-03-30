@extends('layouts.dashboard')

@section('title','My Requests - CDMS')
@section('page_title','My Requests')
@section('page_subtitle','Track your request status.')

@section('sidebar')
  <a class="nav-link" href="{{ url('/customer/dashboard') }}">Overview</a>
  <a class="nav-link" href="{{ url('/customer/products') }}">Products</a>
  <a class="nav-link active" href="{{ url('/customer/requests') }}">My Requests</a>
@endsection

@section('top_actions')
  <a class="btn btn-outline-light" href="{{ url('/customer/products') }}">Back</a>
@endsection

@section('content')
  @forelse($requests as $r)
    <div class="card-glass p-4 mb-3">
      <div class="fw-semibold">Request #{{ $r->id }}</div>
      <div class="muted">Status: <b>{{ $r->status }}</b></div>
      @if($r->note) <div class="muted mt-2">Note: {{ $r->note }}</div> @endif
      @if($r->delivery_location) <div class="muted mt-1">Location: {{ $r->delivery_location }}</div> @endif
      <div class="muted mt-1">Donor Donations: <b>{{ $r->donations_count }}</b></div>
      <div class="muted mt-1">
        Donor Support Enabled:
        <b>{{ $r->donor_donation_allowed ? 'Yes' : 'No' }}</b>
      </div>

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

      @if($r->donations->count() > 0)
        <hr style="border-color: rgba(255,255,255,.12);">
        <div class="fw-semibold mb-2">Donor Contributions</div>
        <ul class="mb-0">
          @foreach($r->donations as $d)
            <li class="muted">
              {{ $d->donor->name ?? 'Donor' }} - {{ $d->status }}
              @if($d->note)
                ({{ $d->note }})
              @endif
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  @empty
    <div class="card-glass p-4">
      <div class="fw-semibold">No requests yet</div>
      <div class="muted">Go to Products and submit a request.</div>
    </div>
  @endforelse
@endsection
