@extends('layouts.guest')

@section('content')
    <p class="text-muted">نسيت كلمة المرور؟ أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين.</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">إرسال رابط إعادة التعيين</button>
        </div>
    </form>
@endsection
