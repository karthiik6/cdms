@extends('layouts.dashboard')

@section('title','Approved Customer Requests - CDMS')
@section('page_title','Approved Customer Requests')
@section('page_subtitle','View approved requests and donate when admin enables donor support.')

@section('sidebar')
  <a class="nav-link" href="{{ url('/donor/dashboard') }}">Overview</a>
  <a class="nav-link" href="{{ url('/donations/create') }}">Submit Donation</a>
  <a class="nav-link" href="{{ url('/donations') }}">Track Donations</a>
  <a class="nav-link active" href="{{ url('/donor/customer-requests') }}">Customer Requests</a>
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
    @php($alreadyDonated = $r->donations->isNotEmpty())
    <div class="card-glass p-4 mb-3">
      <div class="fw-semibold">Request #{{ $r->id }}</div>
      <div class="muted">Customer: {{ $r->customer->name }} ({{ $r->customer->email }})</div>
      <div class="muted">Status: <b>{{ $r->status }}</b></div>
      @if($r->delivery_location)
        <div class="muted">Location: <b>{{ $r->delivery_location }}</b></div>
      @endif
      <div class="muted">Total Donor Donations: <b>{{ $r->donations_count }}</b></div>
      <div class="muted">
        Admin Donor Access:
        <b>{{ $r->donor_donation_allowed ? 'Enabled' : 'Disabled' }}</b>
      </div>

      <hr style="border-color: rgba(255,255,255,.12);">

      <ul class="mb-3">
        @foreach($r->items as $it)
          <li class="muted">
            {{ $it->inventory->item->category ?? '-' }}
            | {{ $it->inventory->item->size ?? '-' }}
            | Qty: {{ $it->quantity }}
          </li>
        @endforeach
      </ul>

      @if($alreadyDonated)
        @php($myDonation = $r->donations->first())
        <div class="muted mb-2">
          <b>Your Donation Status:</b> {{ $myDonation->status }}
        </div>
        @if($myDonation->note)
          <div class="muted mb-2"><b>Your Note:</b> {{ $myDonation->note }}</div>
        @endif
      @endif

      @if($r->donor_donation_allowed && ! $alreadyDonated)
        <form method="POST" action="{{ url('/donor/customer-requests/'.$r->id.'/donate') }}">
          @csrf
          <div class="muted mb-1">Donation Note (optional)</div>
          <textarea name="note" rows="2" class="form-control mb-2" placeholder="Add note for admin/customer..."></textarea>
          <button class="btn btn-success btn-sm">Donate to This Request</button>
        </form>
      @elseif($alreadyDonated)
        <div class="muted"><b>You already donated to this request.</b></div>
      @else
        <div class="muted"><b>Donation is locked until admin enables donor support.</b></div>
      @endif
    </div>
  @empty
    <div class="card-glass p-4">
      <div class="fw-semibold">No approved requests yet</div>
      <div class="muted">Approved customer requests will show here.</div>
    </div>
  @endforelse
@endsection
