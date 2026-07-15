<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حالة طلب المشاركة</title>
</head>

<body style="margin:0;padding:0;background:#F5F6F8;font-family:'Cairo',Tahoma,Arial,sans-serif;direction:rtl;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
       style="background:#F5F6F8;padding:30px 15px;">

    <tr>
        <td align="center">

            <table role="presentation"
                   cellpadding="0"
                   cellspacing="0"
                   border="0"
                   width="100%"
                   style="max-width:600px;background:#FFFFFF;border:1px solid #E5E7EB;border-radius:12px;overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td align="center"
                        style="background:#FFFFFF;border-bottom:4px solid #F36A10;padding:35px 25px;">

                        <img src="{{ config('app.url') }}/images/logo.png"
                             alt="Exhibition System"
                             width="120"
                             style="display:block;border:0;outline:none;text-decoration:none;height:auto;max-width:120px;width:100%;margin-bottom:20px;">

                        <h1 style="margin:0;color:#000D3F;font-size:26px;font-weight:bold;">
                            حالة طلب الانضمام كعارض
                        </h1>

                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:40px 30px;">

                        <p style="margin:0 0 25px;font-size:18px;font-weight:bold;color:#000D3F;">
                             مرحباً {{ $userName }}،
                        </p>

                        <p style="margin:0 0 25px;font-size:16px;line-height:30px;color:#4B5563;">
                            نود إعلامك بأنه تم تحديث حالة طلبك للانضمام كعارض في
                            <strong style="color:#000D3F;">نظام إدارة المعارض</strong>.
                        </p>

                        <table role="presentation"
                               width="100%"
                               cellpadding="0"
                               cellspacing="0"
                               style="background:#F9FAFB;border-right:4px solid #F36A10;border-radius:6px;">

                            <tr>
                                <td style="padding:20px;">

                                    <p style="margin:0;font-size:16px;line-height:30px;color:#374151;">
                                        {{ $statusMessage }}
                                    </p>

                                </td>
                            </tr>

                        </table>

                        <p style="margin:30px 0 0;font-size:15px;line-height:28px;color:#6B7280;">
                            في حال كان لديك أي استفسار، يمكنك التواصل مع فريق الدعم وسنكون سعداء بمساعدتك.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center"
                        style="background:#000D3F;padding:25px;">

                        <p style="margin:0;color:#FFFFFF;font-size:16px;font-weight:bold;">
                            فريق نظام إدارة المعارض
                        </p>

                        <p style="margin:10px 0 0;color:#C9D1D9;font-size:13px;">
                            © {{ date('Y') }} جميع الحقوق محفوظة
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>

</table>

</body>

</html>
