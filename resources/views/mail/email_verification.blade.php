@extends('base')

@section('content')
    <p style="margin-top: 0; font-size: 16px;">Hi <strong>{{ $data['name'] ?? 'there' }}</strong>,</p>

    <p style="font-size: 15px; line-height: 1.6; color: #3f3f46;">
        Thank you for registering. Use the verification code below to confirm your email address.
        This code expires in <strong>10 minutes</strong>.
    </p>

    <div
        style="
        display: inline-block;
        margin: 24px 0;
        padding: 16px 32px;
        background-color: #18181b;
        border-radius: 6px;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: 8px;
        color: #f59e0b;
    ">
        {{ $data['otp'] }}
    </div>

    <p style="font-size: 13px; color: #71717a;">
        If you did not create an account, no further action is required.
    </p>
@endsection
