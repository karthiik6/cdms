@extends('layouts.dashboard')

@section('title','Submit Donation - CDMS')
@section('page_title','Submit Donation')
@section('page_subtitle','Add items and upload a photo for this donation.')

@section('sidebar')
  <a class="nav-link" href="{{ url('/donor/dashboard') }}">Overview</a>
  <a class="nav-link active" href="{{ url('/donations/create') }}">Submit Donation</a>
  <a class="nav-link" href="{{ url('/donations') }}">Track Donations</a>
@endsection

@section('top_actions')
  <a class="btn btn-outline-light" href="{{ url('/donations') }}">Back</a>
@endsection

@section('content')

<div class="card-glass p-4">
  <form method="POST" action="{{ url('/donations') }}" enctype="multipart/form-data">
    @csrf

    <div class="row g-3">

      <div class="col-12 col-md-6">
        <label class="form-label">Donation Date (optional)</label>
        <input type="date" name="donation_date" class="form-control"
               value="{{ old('donation_date') }}">
        <div class="muted mt-1" style="font-size:.9rem;">Leave empty to use today.</div>
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Donation Photo</label>
        <input type="file" name="photo" class="form-control" accept="image/*" required>
        <div class="muted mt-1" style="font-size:.9rem;">jpg / png / webp up to 2MB</div>
      </div>

      <div class="col-12">
        <label class="form-label">Pickup Address</label>
        <textarea name="pickup_address" class="form-control" rows="3" required
                  placeholder="Enter the full address where the volunteer should collect the clothes">{{ old('pickup_address') }}</textarea>
        <div class="muted mt-1" style="font-size:.9rem;">This address will be shared with the assigned volunteer for collection.</div>
      </div>

      <div class="col-12">
        <hr style="border-color: rgba(255,255,255,.12);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
          <h5 class="mb-0">Clothing Items</h5>
          <button type="button" class="btn btn-outline-light btn-sm" onclick="addItem()">+ Add Item</button>
        </div>
        <div class="muted mt-1">Add at least one item. You can add multiple.</div>
      </div>

      <div class="col-12" id="itemsWrap">
        {{-- Item Row Template (first item) --}}
        <div class="card-glass p-3 mb-3 itemRow">
          <div class="row g-3">
            <div class="col-12 col-md-3">
              <label class="form-label">Category</label>
              <input class="form-control" name="items[0][category]" placeholder="Shirt / Pant / Jacket" required>
            </div>

            <div class="col-12 col-md-2">
              <label class="form-label">Size</label>
              <select class="form-control" name="items[0][size]" required>
                <option value="">Select</option>
                <option>S</option><option>M</option><option>L</option><option>XL</option>
              </select>
            </div>

            <div class="col-12 col-md-3">
              <label class="form-label">Condition</label>
              <select class="form-control" name="items[0][condition]" required>
                <option value="">Select</option>
                <option>New</option>
                <option>Good</option>
                <option>Used</option>
              </select>
            </div>

            <div class="col-12 col-md-2">
              <label class="form-label">Quantity</label>
              <input type="number" min="1" class="form-control" name="items[0][quantity]" required>
            </div>

            <div class="col-12 col-md-2 d-flex align-items-end">
              <button type="button" class="btn btn-outline-danger w-100" onclick="removeItem(this)">Remove</button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-success">Submit Donation</button>
        <a href="{{ url('/donations') }}" class="btn btn-outline-light">Cancel</a>
      </div>

    </div>
  </form>
</div>

<script>
  let itemIndex = 1;

  function addItem(){
    const wrap = document.getElementById('itemsWrap');

    const html = `
      <div class="card-glass p-3 mb-3 itemRow">
        <div class="row g-3">
          <div class="col-12 col-md-3">
            <label class="form-label">Category</label>
            <input class="form-control" name="items[${itemIndex}][category]" placeholder="Shirt / Pant / Jacket" required>
          </div>

          <div class="col-12 col-md-2">
            <label class="form-label">Size</label>
            <select class="form-control" name="items[${itemIndex}][size]" required>
              <option value="">Select</option>
              <option>S</option><option>M</option><option>L</option><option>XL</option>
            </select>
          </div>

          <div class="col-12 col-md-3">
            <label class="form-label">Condition</label>
            <select class="form-control" name="items[${itemIndex}][condition]" required>
              <option value="">Select</option>
              <option>New</option>
              <option>Good</option>
              <option>Used</option>
            </select>
          </div>

          <div class="col-12 col-md-2">
            <label class="form-label">Quantity</label>
            <input type="number" min="1" class="form-control" name="items[${itemIndex}][quantity]" required>
          </div>

          <div class="col-12 col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-outline-danger w-100" onclick="removeItem(this)">Remove</button>
          </div>
        </div>
      </div>
    `;

    wrap.insertAdjacentHTML('beforeend', html);
    itemIndex++;
  }

  function removeItem(btn){
    const rows = document.querySelectorAll('.itemRow');
    if(rows.length <= 1){
      alert('At least one item is required.');
      return;
    }
    btn.closest('.itemRow').remove();
  }
</script>

@endsection
