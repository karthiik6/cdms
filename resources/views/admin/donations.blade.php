@extends('layouts.dashboard')

@section('title','Admin - Donations')
@section('page_title','All Donations')
@section('page_subtitle','Assign volunteers and update donation status.')

@section('sidebar')
  <a class="nav-link" href="{{ url('/admin/dashboard') }}">Overview</a>
  <a class="nav-link active" href="{{ url('/admin/donations') }}">Donations</a>
  <a class="nav-link" href="{{ url('/admin/inventory') }}">Inventory</a>
  <a class="nav-link" href="{{ url('/admin/requests') }}">Requests</a>
  <a class="nav-link" href="{{ url('/admin/beneficiaries') }}">Beneficiaries</a>
@endsection

@section('top_actions')
  <a class="btn btn-outline-light" href="{{ url('/admin/dashboard') }}">Back</a>
@endsection

@section('content')

  @if(session('success'))
    <div class="card-glass p-3 mb-3" style="border: 1px solid rgba(34,197,94,.35);">
      <div class="fw-semibold">Success</div>
      <div class="muted">{{ session('success') }}</div>
    </div>
  @endif

  @if(session('error'))
    <div class="card-glass p-3 mb-3" style="border: 1px solid rgba(239,68,68,.35);">
      <div class="fw-semibold">Error</div>
      <div class="muted">{{ session('error') }}</div>
    </div>
  @endif

  {{-- Filter/Search --}}
  <div class="card-glass p-3 mb-3">
    <form method="GET" action="{{ url('/admin/donations') }}" style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
      <input type="text" name="q" placeholder="Search donor name/email"
             value="{{ $q ?? '' }}" style="padding:6px 10px; min-width:240px;">
      <select name="status" style="padding:6px 10px;">
        <option value="">All Status</option>
        <option value="Pending" {{ ($status ?? '')=='Pending'?'selected':'' }}>Pending</option>
        <option value="Collected" {{ ($status ?? '')=='Collected'?'selected':'' }}>Collected</option>
        <option value="Distributed" {{ ($status ?? '')=='Distributed'?'selected':'' }}>Distributed</option>
      </select>
      <button type="submit" class="btn btn-outline-light btn-sm">Apply</button>
      <a href="{{ url('/admin/donations') }}" class="btn btn-outline-light btn-sm">Reset</a>
    </form>
  </div>

  @forelse($donations as $d)
    <div class="card-glass p-4 mb-3">

      <div class="d-flex justify-content-between flex-wrap gap-2">
        <div>
          <div class="fw-semibold" style="font-size:1.05rem;">
            Donation #{{ $d->id }}
          </div>
          <div class="muted" style="margin-top:4px;">
            Donor: {{ $d->donor->name }} ({{ $d->donor->email }})
          </div>
          <div class="muted" style="margin-top:4px;">
            Donor Contact: {{ $d->contact_phone ?: ($d->donor->phone ?: 'Not available') }}
          </div>

          <div class="muted" style="margin-top:6px;">
            Status:
            @if($d->status === 'Distributed')
              <span style="padding:3px 10px;border-radius:999px;background:rgba(34,197,94,.18);border:1px solid rgba(34,197,94,.35);">Distributed</span>
            @elseif($d->status === 'Collected')
              <span style="padding:3px 10px;border-radius:999px;background:rgba(59,130,246,.18);border:1px solid rgba(59,130,246,.35);">Collected</span>
            @else
              <span style="padding:3px 10px;border-radius:999px;background:rgba(245,158,11,.18);border:1px solid rgba(245,158,11,.35);">Pending</span>
            @endif
          </div>
        </div>

        <div class="muted">
          Date: {{ $d->donation_date ?? $d->created_at->toDateString() }}
        </div>
      </div>

      {{-- donation photo --}}
      @if(!empty($d->photo))
        <div style="margin-top:10px;">
          <div class="muted mb-1">Donation Photo</div>
          <img src="{{ asset('storage/'.$d->photo) }}"
               style="max-width:260px;border-radius:12px;border:1px solid rgba(255,255,255,.15);">
        </div>
      @endif

      <hr style="border-color: rgba(255,255,255,.12);">

      <div class="row g-3">
        <div class="col-12 col-md-6">
          <div class="fw-semibold mb-2">Items</div>
          <div class="muted mb-2">
            <b>Pickup Address:</b><br>
            {{ $d->pickup_address }}
          </div>
          <ul class="mb-0">
            @foreach($d->items as $it)
              <li class="muted">{{ $it->category }} | {{ $it->size }} | {{ $it->condition }} | Qty: {{ $it->quantity }}</li>
            @endforeach
          </ul>
        </div>

        <div class="col-12 col-md-6">
          <div class="fw-semibold mb-2">Actions</div>

          <form method="POST" action="{{ url('/admin/donations/'.$d->id.'/assign') }}" class="mb-2">
            @csrf
            <div class="muted mb-1">Assign Volunteer</div>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
              <select name="volunteer_id" required style="padding:6px 10px; min-width:200px;">
                <option value="">-- choose --</option>
                @foreach($volunteers as $v)
                  <option value="{{ $v->id }}">{{ $v->name }}{{ $v->phone ? ' ('.$v->phone.')' : '' }}</option>
                @endforeach
              </select>
              <button type="submit" class="btn btn-primary btn-sm">Assign</button>
            </div>
            <label class="muted mt-2 d-block">
              <input type="checkbox" name="show_volunteer_details_to_donor" value="1" {{ $d->show_volunteer_details_to_donor ? 'checked' : '' }}>
              Allow donor to see assigned volunteer name and phone number
            </label>
          </form>

          @if($d->task)
            <form method="POST" action="{{ url('/admin/donations/'.$d->id.'/volunteer-sharing') }}" class="mb-2">
              @csrf
              <input type="hidden" name="show_volunteer_details_to_donor" value="{{ $d->show_volunteer_details_to_donor ? 0 : 1 }}">
              <button type="submit" class="btn btn-outline-light btn-sm">
                {{ $d->show_volunteer_details_to_donor ? 'Hide Volunteer Details from Donor' : 'Share Volunteer Details with Donor' }}
              </button>
            </form>
          @endif

          <form method="POST" action="{{ url('/admin/donations/'.$d->id.'/status') }}">
            @csrf
            <div class="muted mb-1">Update Donation Status</div>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
              <select name="status" style="padding:6px 10px; min-width:200px;">
                <option value="Pending" {{ $d->status=='Pending'?'selected':'' }}>Pending</option>
                <option value="Collected" {{ $d->status=='Collected'?'selected':'' }}>Collected</option>
                <option value="Distributed" {{ $d->status=='Distributed'?'selected':'' }}>Distributed</option>
              </select>
              <button type="submit" class="btn btn-success btn-sm">Update</button>
            </div>
          </form>

          <div class="muted mt-3">
            <b>Task:</b>
            @if($d->task)
              {{ $d->task->status }} (Volunteer: {{ $d->task->volunteer->name ?? 'N/A' }})
              <br>
              Volunteer Phone: {{ $d->task->volunteer->phone ?? 'Not available' }}
              <br>
              Donor can see volunteer details: {{ $d->show_volunteer_details_to_donor ? 'Yes' : 'No' }}
            @else
              Not assigned
            @endif
          </div>
        </div>
      </div>

    </div>
  @empty
    <div class="card-glass p-4">
      <div class="fw-semibold">No donations found</div>
      <div class="muted">Try changing filters or add donations first.</div>
    </div>
  @endforelse

@endsection
