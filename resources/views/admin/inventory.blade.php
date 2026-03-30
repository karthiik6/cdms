@extends('layouts.dashboard')

@section('title','Admin - Inventory')
@section('page_title','Inventory')
@section('page_subtitle','View and update available clothing stock.')

@section('sidebar')
  <a class="nav-link" href="{{ url('/admin/dashboard') }}">Overview</a>
  <a class="nav-link" href="{{ url('/admin/donations') }}">Donations</a>
  <a class="nav-link active" href="{{ url('/admin/inventory') }}">Inventory</a>
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

  <div class="card-glass p-4">
    <div class="fw-semibold mb-3">Current Stock</div>

    @if($inventory->count() === 0)
      <div class="muted">No inventory items yet. Stock will update after pickup tasks are completed.</div>
    @else
      <div style="overflow:auto;">
        <table class="table table-dark table-borderless align-middle" style="min-width:820px;">
          <thead>
            <tr class="muted">
              <th>ID</th>
              <th>Category</th>
              <th>Size</th>
              <th>Condition</th>
              <th>Available Qty</th>
              <th>Location</th>
              <th style="width:220px;">Update</th>
            </tr>
          </thead>
          <tbody>
          @foreach($inventory as $inv)
            <tr>
              <td>{{ $inv->id }}</td>
              <td>{{ $inv->item->category ?? '-' }}</td>
              <td>{{ $inv->item->size ?? '-' }}</td>
              <td>{{ $inv->item->condition ?? '-' }}</td>
              <td><b>{{ $inv->available_quantity }}</b></td>
              <td>{{ $inv->location }}</td>
              <td>
                <form method="POST" action="{{ url('/admin/inventory/'.$inv->id) }}" style="display:flex; gap:8px;">
                  @csrf
                  <input type="number" min="0" name="available_quantity" value="{{ $inv->available_quantity }}"
                         style="padding:6px 10px; width:110px;">
                  <input type="text" name="location" value="{{ $inv->location }}"
                         style="padding:6px 10px; width:140px;">
                  <button class="btn btn-success btn-sm">Save</button>
                </form>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

@endsection