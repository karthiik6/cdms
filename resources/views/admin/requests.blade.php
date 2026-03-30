@extends('layouts.dashboard')

@section('title','Admin - Requests')
@section('page_title','Clothing Requests')
@section('page_subtitle','Approve allocations and assign volunteers for beneficiary requests.')

@section('sidebar')
  <a class="nav-link" href="{{ url('/admin/dashboard') }}">Overview</a>
  <a class="nav-link" href="{{ url('/admin/donations') }}">Donations</a>
  <a class="nav-link" href="{{ url('/admin/inventory') }}">Inventory</a>
  <a class="nav-link active" href="{{ url('/admin/requests') }}">Requests</a>
  <a class="nav-link" href="{{ url('/admin/beneficiaries') }}">Beneficiaries</a>
@endsection

@section('top_actions')
  <a class="btn btn-outline-light" href="{{ url('/admin/dashboard') }}">Back</a>
@endsection

@section('content')
  @forelse($requests as $r)
    <div class="card-glass p-4 mb-3">
      <div class="d-flex justify-content-between flex-wrap gap-2">
        <div>
          <div class="fw-semibold" style="font-size:1.05rem;">
            Request #{{ $r->id }}
          </div>
          <div class="muted" style="margin-top:4px;">
            Beneficiary: {{ $r->beneficiary->name }} ({{ $r->beneficiary->contact }})
          </div>
          <div class="muted" style="margin-top:6px;">
            Status:
            @if($r->status === 'Approved')
              <span style="padding:3px 10px;border-radius:999px;background:rgba(34,197,94,.18);border:1px solid rgba(34,197,94,.35);">Approved</span>
            @elseif($r->status === 'Partially Approved')
              <span style="padding:3px 10px;border-radius:999px;background:rgba(59,130,246,.18);border:1px solid rgba(59,130,246,.35);">Partially Approved</span>
            @elseif($r->status === 'Rejected')
              <span style="padding:3px 10px;border-radius:999px;background:rgba(239,68,68,.18);border:1px solid rgba(239,68,68,.35);">Rejected</span>
            @else
              <span style="padding:3px 10px;border-radius:999px;background:rgba(245,158,11,.18);border:1px solid rgba(245,158,11,.35);">Pending</span>
            @endif
          </div>
        </div>

        <div class="muted">
          Date: {{ $r->created_at?->toDateString() }}
        </div>
      </div>

      <hr style="border-color: rgba(255,255,255,.12);">

      <div class="row g-3">
        <div class="col-12 col-md-6">
          <div class="fw-semibold mb-2">Requested Items</div>
          <ul class="mb-0">
            @foreach($r->items as $it)
              <li class="muted">{{ $it->category }} | {{ $it->size }} | Need: {{ $it->quantity }}</li>
            @endforeach
          </ul>

          <div class="fw-semibold mt-3 mb-2">Allocations</div>
          <ul class="mb-0">
            @forelse($r->allocations as $a)
              <li class="muted">
                Inventory #{{ $a->inventory_id }}:
                {{ $a->inventory->item->category }} {{ $a->inventory->item->size }}
                | Qty: {{ $a->allocated_quantity }}
              </li>
            @empty
              <li class="muted">Not allocated yet</li>
            @endforelse
          </ul>
        </div>

        <div class="col-12 col-md-6">
          <div class="fw-semibold mb-2">Actions</div>

          @if(in_array($r->status, ['Pending', 'Partially Approved']))
            <form method="POST" action="{{ url('/admin/requests/'.$r->id.'/approve') }}" class="mb-3">
              @csrf
              <button type="submit" class="btn btn-success btn-sm">
                {{ $r->status === 'Pending' ? 'Approve & Allocate' : 'Allocate Remaining' }}
              </button>
            </form>
          @endif

          <form method="POST" action="{{ url('/admin/requests/'.$r->id.'/assign') }}" class="mb-2">
            @csrf
            <div class="muted mb-1">Assign Volunteer</div>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
              <select name="volunteer_id" required style="padding:6px 10px; min-width:200px;">
                <option value="">-- choose --</option>
                @foreach($volunteers as $v)
                  <option value="{{ $v->id }}">{{ $v->name }}</option>
                @endforeach
              </select>
              <button type="submit" class="btn btn-primary btn-sm">Assign</button>
            </div>
          </form>

          <div class="muted mt-3">
            <b>Task:</b>
            @if($r->task)
              {{ $r->task->status }} (Volunteer: {{ $r->task->volunteer->name ?? 'N/A' }})
            @else
              Not assigned
            @endif
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="card-glass p-4">
      <div class="fw-semibold">No requests found</div>
      <div class="muted">Beneficiary requests will appear here.</div>
    </div>
  @endforelse
@endsection
