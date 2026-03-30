@extends('layouts.auth')

@section('title', 'Beneficiary Request - CDMS')
@section('heading', 'Request Clothing')
@section('subheading', 'Submit beneficiary details and item quantities for admin review.')

@section('content')
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="/beneficiary/request" class="mt-2">
    @csrf

    <div class="mb-3">
      <label class="form-label">Beneficiary Name</label>
      <input name="name" class="form-control" placeholder="Full name" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Contact</label>
      <input name="contact" class="form-control" placeholder="Phone or alternate contact">
    </div>

    <div class="mb-3">
      <label class="form-label">Address</label>
      <textarea name="address" class="form-control" rows="3" placeholder="Address details"></textarea>
    </div>

    <div class="mb-4">
      <label class="form-label">Request Date</label>
      <input type="date" name="request_date" class="form-control">
    </div>

    <h6 class="fw-semibold mb-3">Items Needed</h6>
    <div class="row g-2 mb-4">
      <div class="col-12 col-md-5">
        <input name="items[0][category]" class="form-control" placeholder="Category (Shirt/Pants)" required>
      </div>
      <div class="col-12 col-md-3">
        <input name="items[0][size]" class="form-control" placeholder="Size (S/M/L)" required>
      </div>
      <div class="col-12 col-md-4">
        <input type="number" name="items[0][quantity]" class="form-control" placeholder="Quantity" min="1" required>
      </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2">Submit Request</button>
  </form>
@endsection
