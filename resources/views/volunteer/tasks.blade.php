@extends('layouts.dashboard')

@section('title','My Tasks - CDMS')
@section('page_title','My Tasks')
@section('page_subtitle','View assigned pickup/distribution/customer delivery tasks and mark them completed.')

@section('sidebar')
  <a class="nav-link" href="{{ url('/volunteer/dashboard') }}">Overview</a>
  <a class="nav-link active" href="{{ url('/tasks') }}">My Tasks</a>
@endsection

@section('top_actions')
  <a class="btn btn-outline-light" href="{{ url('/volunteer/dashboard') }}">Back</a>
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

{{-- Filter --}}
<div class="card-glass p-3 mb-3">
  <form method="GET" action="{{ url('/tasks') }}" style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
    <div class="muted">Filter:</div>
    <select name="status" style="padding:6px 10px;">
      <option value="">All</option>
      <option value="Assigned" {{ ($status ?? '')=='Assigned'?'selected':'' }}>Assigned</option>
      <option value="Completed" {{ ($status ?? '')=='Completed'?'selected':'' }}>Completed</option>
    </select>
    <button class="btn btn-outline-light btn-sm" type="submit">Apply</button>
    <a class="btn btn-outline-light btn-sm" href="{{ url('/tasks') }}">Reset</a>
  </form>
</div>

@forelse($tasks as $t)

<div class="card-glass p-4 mb-3">

  <div class="d-flex justify-content-between flex-wrap gap-2">
    <div>
      <div class="fw-semibold" style="font-size:1.05rem;">
        Task #{{ $t->id }} - {{ strtoupper($t->type) }}
      </div>

      <div class="muted mt-1">
        Status:
        @if($t->status === 'Completed')
          <span style="padding:3px 10px;border-radius:999px;background:rgba(34,197,94,.18);border:1px solid rgba(34,197,94,.35);">Completed</span>
        @else
          <span style="padding:3px 10px;border-radius:999px;background:rgba(245,158,11,.18);border:1px solid rgba(245,158,11,.35);">Assigned</span>
        @endif
      </div>
    </div>

    <div class="muted">
      Created: {{ $t->created_at->toDateString() }}
    </div>
  </div>

  <hr style="border-color: rgba(255,255,255,.12);">

  {{-- ================= PICKUP TASK ================= --}}
  @if($t->type === 'pickup' && $t->donation)

    <div class="fw-semibold mb-1">Donor</div>
    <div class="muted">
      {{ $t->donation->donor->name }} - {{ $t->donation->donor->email }}
    </div>

    <div class="fw-semibold mt-3 mb-1">Pickup Address</div>
    <div class="muted">
      {{ $t->donation->pickup_address }}
    </div>

    @if(!empty($t->donation->photo))
      <div class="mt-2">
        <div class="muted mb-1">Donation Photo</div>
        <img src="{{ asset('storage/'.$t->donation->photo) }}"
             style="max-width:260px;border-radius:12px;border:1px solid rgba(255,255,255,.15);">
      </div>
    @endif

    <div class="fw-semibold mt-3 mb-1">Items</div>
    <ul class="mb-0">
      @foreach($t->donation->items as $it)
        <li class="muted">
          {{ $it->category }} | {{ $it->size }} | {{ $it->condition }} | Qty: {{ $it->quantity }}
        </li>
      @endforeach
    </ul>

  {{-- ================= DISTRIBUTION TASK ================= --}}
  @elseif($t->type === 'distribution' && $t->request)

    <div class="fw-semibold mb-1">Request #{{ $t->request->id }}</div>

    <div class="fw-semibold mt-2 mb-1">Requested Items</div>
    <ul class="mb-0">
      @foreach($t->request->items as $it)
        <li class="muted">
          {{ $it->category }} | {{ $it->size }} | Qty: {{ $it->quantity }}
        </li>
      @endforeach
    </ul>

  {{-- ================= CUSTOMER DELIVERY TASK ================= --}}
  @elseif($t->type === 'customer_delivery' && $t->customerRequest)

    <div class="fw-semibold mb-1">Customer</div>
    <div class="muted">
      {{ $t->customerRequest->customer->name }}
      ({{ $t->customerRequest->customer->email }})
    </div>
    @if($t->customerRequest->delivery_location)
      <div class="muted mt-1">
        Location: <b>{{ $t->customerRequest->delivery_location }}</b>
      </div>
    @endif

    <div class="fw-semibold mt-3 mb-1">Purchased Items</div>
    <ul class="mb-0">
      @foreach($t->customerRequest->items as $it)
        <li class="muted">
          {{ $it->inventory->item->category ?? '-' }}
          | {{ $it->inventory->item->size ?? '-' }}
          | Qty: {{ $it->quantity }}
        </li>
      @endforeach
    </ul>

  {{-- ================= FALLBACK ================= --}}
  @else
    <div class="muted">This task has missing linked data.</div>
  @endif

  {{-- Complete Button --}}
  <div class="mt-3 d-flex gap-2 flex-wrap">
    @if($t->status !== 'Completed')
      <form method="POST" action="{{ url('/tasks/'.$t->id.'/complete') }}">
        @csrf
        <button class="btn btn-success">{{ $t->type === 'pickup' ? 'Mark as Collected' : 'Mark Completed' }}</button>
      </form>
    @else
      <span class="btn btn-outline-light disabled">{{ $t->type === 'pickup' ? 'Already Collected' : 'Already Completed' }}</span>
    @endif
  </div>

</div>

@empty
  <div class="card-glass p-4">
    <div class="fw-semibold">No tasks found</div>
    <div class="muted">When admin assigns tasks, they will show here.</div>
  </div>
@endforelse

@endsection
