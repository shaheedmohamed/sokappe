@extends('layouts.guest')

@section('content')
    <p class="text-muted">شكرًا لتسجيلك! من فضلك فعّل بريدك الإلكتروني عبر الرابط المرسل إلى بريدك. لم يصلك البريد؟ يمكنك إعادة إرسال رابط التفعيل.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">تم إرسال رابط تحقق جديد إلى بريدك الإلكتروني.</div>
    @endif

    <div class="d-flex justify-content-between align-items-center">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">إعادة إرسال رابط التفعيل</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">تسجيل الخروج</button>
        </form>
    </div>
@endsection
