@extends('layouts.dashboard')

@section('title','Products - CDMS')
@section('page_title','Available Products')
@section('page_subtitle','Select quantities and send request to admin.')

@section('sidebar')
  <a class="nav-link" href="{{ url('/customer/dashboard') }}">Overview</a>
  <a class="nav-link active" href="{{ url('/customer/products') }}">Products</a>
  <a class="nav-link" href="{{ url('/customer/requests') }}">My Requests</a>
@endsection

@section('top_actions')
  <form method="POST" action="{{ url('/logout') }}">
    @csrf
    <button class="btn btn-outline-light">Logout</button>
  </form>
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

  <form method="POST" action="{{ url('/customer/requests') }}">
    @csrf

    <div class="card-glass p-4 mb-3">
      <div class="fw-semibold mb-2">Request Note (optional)</div>
      <textarea name="note" class="form-control" rows="2" placeholder="Any note for admin..."></textarea>

      <div class="fw-semibold mb-2 mt-3">Delivery Location</div>
      <input
        type="text"
        name="delivery_location"
        class="form-control"
        maxlength="500"
        placeholder="Enter your full delivery location"
        required
      >
      <div class="muted mt-1" style="font-size:.9rem;">
        Admin and assigned volunteer will use this location after approval.
      </div>

      <div class="fw-semibold mb-2 mt-3">Contact Number</div>
      <input
        type="text"
        name="contact_phone"
        class="form-control"
        maxlength="20"
        value="{{ old('contact_phone', auth()->user()->phone) }}"
        placeholder="Phone number for delivery coordination"
        required
      >
      <div class="muted mt-1" style="font-size:.9rem;">
        Required so admin and the assigned volunteer can contact you for delivery.
      </div>
    </div>

    <div class="card-glass p-4">
      <div class="fw-semibold mb-3">Inventory Items</div>

      @if($productOptions->count() === 0)
        <div class="muted">No stock available right now.</div>
      @else
        <div style="overflow:auto;">
          <table class="table table-borderless align-middle" style="min-width:900px;">
            <thead>
              <tr class="muted">
                <th>Category</th><th>Type</th><th>Size</th><th>Available</th><th>Request Qty</th>
              </tr>
            </thead>
            <tbody>
              @foreach($productOptions as $option)
                <tr>
                  <td>{{ $option['label'] }}</td>
                  <td>{{ $option['type'] }}</td>
                  <td>{{ $option['size'] }}</td>
                  <td><b>{{ $option['available'] }}</b></td>
                  <td style="width:180px;">
                    @foreach($option['inventory_ids'] as $inventoryId)
                      <input type="hidden" name="items[{{ $option['key'] }}][inventory_ids][]" value="{{ $inventoryId }}">
                    @endforeach
                    <input type="number" min="0" max="{{ $option['available'] }}"
                      name="items[{{ $option['key'] }}][qty]" value="0" class="form-control">
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <button class="btn btn-success mt-2">Send Request to Admin</button>
      @endif
    </div>
  </form>

@endsection
