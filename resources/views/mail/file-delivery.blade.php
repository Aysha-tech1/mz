<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->title }}</title>
</head>
<body style="margin:0;padding:0;background:#f6f5f3;font-family:'IBM Plex Sans Arabic',Tahoma,Arial,sans-serif;color:#121212;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f5f3;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellpadding="0" cellspacing="0" style="max-width:560px;width:100%;background:#ffffff;border:1px solid #e7e5e4;border-radius:24px;overflow:hidden;">
                    <tr>
                        <td style="background:#121212;padding:22px 28px;text-align:center;">
                            <img src="{{ asset('images/logo.png') }}" alt="M7ZZ" width="48" height="48" style="display:inline-block;border-radius:12px;">
                            <p style="margin:10px 0 0;color:#f59e0b;font-weight:700;font-size:14px;">محمود الدرعي</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 28px 8px;text-align:right;">
                            <p style="margin:0 0 8px;color:#f59e0b;font-size:13px;font-weight:700;">شكرًا لك</p>
                            <h1 style="margin:0 0 16px;font-size:22px;line-height:1.5;">وصلك الملف، ونتمنى يفيدك في مشروعك</h1>
                            <p style="margin:0 0 18px;color:#57534e;font-size:15px;line-height:1.9;">
                                شكرًا لثقتك. طلبك لملف <strong style="color:#121212;">{{ $product->title }}</strong> تم بنجاح.
                            </p>
                            @if($attachFile)
                                <p style="margin:0 0 18px;color:#57534e;font-size:15px;line-height:1.9;">
                                    الملف مرفق مع هذه الرسالة، ويمكنك تحميله أيضًا من الزر أدناه.
                                </p>
                                <p style="margin:0 0 24px;">
                                    <a href="{{ $product->signedDownloadUrl($email) }}" style="display:inline-block;background:#f59e0b;color:#121212;text-decoration:none;font-weight:700;padding:12px 22px;border-radius:999px;">تحميل الملف</a>
                                </p>
                            @else
                                <p style="margin:0 0 18px;color:#57534e;font-size:15px;line-height:1.9;">
                                    سنعود إليك قريبًا لإتمام الطلب. إن أحببت، يمكنك حجز استشارة مباشرة من الموقع.
                                </p>
                                <p style="margin:0 0 24px;">
                                    <a href="{{ url('/#consult') }}" style="display:inline-block;background:#f59e0b;color:#121212;text-decoration:none;font-weight:700;padding:12px 22px;border-radius:999px;">حجز استشارة</a>
                                </p>
                            @endif
                            <p style="margin:0;color:#6b6560;font-size:13px;line-height:1.8;">
                                إن واجهت أي مشكلة في فتح الملف، راسلنا على
                                <a href="mailto:{{ config('services.email') }}" style="color:#d97706;">{{ config('services.email') }}</a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 28px 28px;text-align:center;color:#6b6560;font-size:12px;">
                            محمود الدرعي · التجارة الإلكترونية بثقة
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
