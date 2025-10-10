@extends('layouts.guest')

@section('content')
    <p class="text-muted">هذه منطقة آمنة. يرجى تأكيد كلمة المرور للمتابعة.</p>

    <form method="POST" action="{{ route('password.confirm') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">تأكيد</button>
        </div>
    </form>
@endsection
