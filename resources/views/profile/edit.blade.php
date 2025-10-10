@extends('layouts.app')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 mb-0">الملف الشخصي</h1>
  </div>

  <div class="row g-3">
    <div class="col-12 col-lg-8">
      <div class="card mb-3">
        <div class="card-body">
          @include('profile.partials.update-profile-information-form')
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-body">
          @include('profile.partials.update-password-form')
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          @include('profile.partials.delete-user-form')
        </div>
      </div>
    </div>
  </div>
@endsection
