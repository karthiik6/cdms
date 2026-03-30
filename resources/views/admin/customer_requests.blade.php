@extends('layouts.dashboard')

@section('title','Customer Requests - CDMS')
@section('page_title','Customer Requests')
@section('page_subtitle','Approve requests, assign volunteers, and control donor support access.')

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
          <div class="muted">Customer Contact: {{ $r->contact_phone ?: ($r->customer->phone ?: 'Not available') }}</div>
          <div class="muted">Status: <b>{{ $r->status }}</b></div>
          @if($r->delivery_location)
            <div class="muted">Location: <b>{{ $r->delivery_location }}</b></div>
          @endif
          <div class="muted">Donor Donations: <b>{{ $r->donations_count }}</b></div>
          <div class="muted">
            Donor Support Enabled:
            <b>{{ $r->donor_donation_allowed ? 'Yes' : 'No' }}</b>
          </div>
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

      <div class="fw-semibold mb-2">Donor Contributions</div>
      @if($r->donations->count() === 0)
        <div class="muted mb-3">No donor contributions yet.</div>
      @else
        <div class="mb-3" style="overflow:auto;">
          <table class="table table-dark table-borderless align-middle mb-0" style="min-width:700px;">
            <thead>
              <tr class="muted">
                <th>Donor</th>
                <th>Status</th>
                <th>Note</th>
                <th>Update</th>
              </tr>
            </thead>
            <tbody>
              @foreach($r->donations as $d)
                <tr>
                  <td>{{ $d->donor->name ?? 'N/A' }}</td>
                  <td><b>{{ $d->status }}</b></td>
                  <td>{{ $d->note ?: '-' }}</td>
                  <td>
                    <form method="POST" action="{{ url('/admin/customer-requests/'.$r->id.'/donations/'.$d->id.'/status') }}" style="display:flex; gap:8px; flex-wrap:wrap;">
                      @csrf
                      <select name="status" style="padding:6px 10px; min-width:160px;">
                        @foreach(['Pledged','Accepted','Completed','Rejected'] as $status)
                          <option value="{{ $status }}" {{ $d->status === $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                      </select>
                      <button class="btn btn-outline-light btn-sm">Save</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif

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

      @if($r->status === 'Approved')
        <form method="POST" action="{{ url('/admin/customer-requests/'.$r->id.'/assign') }}" style="margin-top:10px;">
          @csrf
          <label class="muted">Assign Volunteer:</label>
          <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <select name="volunteer_id" required style="padding:6px 10px; min-width:200px;">
              <option value="">-- choose --</option>
              @foreach($volunteers as $v)
                <option value="{{ $v->id }}">{{ $v->name }}{{ $v->phone ? ' ('.$v->phone.')' : '' }}</option>
              @endforeach
            </select>
            <button class="btn btn-primary btn-sm">Assign</button>
          </div>
          <label class="muted mt-2 d-block">
            <input type="checkbox" name="show_volunteer_details_to_customer" value="1" {{ $r->show_volunteer_details_to_customer ? 'checked' : '' }}>
            Allow customer to see assigned volunteer name and phone number
          </label>
        </form>

        @if($r->task)
          <form method="POST" action="{{ url('/admin/customer-requests/'.$r->id.'/volunteer-sharing') }}" style="margin-top:10px;">
            @csrf
            <input type="hidden" name="show_volunteer_details_to_customer" value="{{ $r->show_volunteer_details_to_customer ? 0 : 1 }}">
            <button class="btn btn-outline-light btn-sm">
              {{ $r->show_volunteer_details_to_customer ? 'Hide Volunteer Details from Customer' : 'Share Volunteer Details with Customer' }}
            </button>
          </form>
        @endif

        <form method="POST" action="{{ url('/admin/customer-requests/'.$r->id.'/donor-permission') }}" style="margin-top:10px;">
          @csrf
          <input type="hidden" name="allowed" value="{{ $r->donor_donation_allowed ? 0 : 1 }}">
          <button class="btn {{ $r->donor_donation_allowed ? 'btn-outline-warning' : 'btn-warning' }} btn-sm">
            {{ $r->donor_donation_allowed ? 'Disable Donor Donations' : 'Allow Donor Donations' }}
          </button>
        </form>
      @endif

      <div class="muted mt-2">
        <b>Volunteer Task:</b>
        @if($r->task)
          {{ $r->task->status }} ({{ $r->task->volunteer->name ?? 'N/A' }})
          <br>
          Volunteer Phone: {{ $r->task->volunteer->phone ?? 'Not available' }}
          <br>
          Customer can see volunteer details: {{ $r->show_volunteer_details_to_customer ? 'Yes' : 'No' }}
        @else
          Not assigned
        @endif
      </div>
    </div>
  @empty
    <div class="card-glass p-4">
      <div class="fw-semibold">No customer requests</div>
      <div class="muted">When customers submit, they appear here.</div>
    </div>
  @endforelse
@endsection
