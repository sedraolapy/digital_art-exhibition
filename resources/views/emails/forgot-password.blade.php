
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور</title>
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
                            إعادة تعيين كلمة المرور
                        </h1>

                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:40px 30px;">

                        <p style="margin:0 0 25px;font-size:18px;font-weight:bold;color:#000D3F;">
                            مرحباً {{ $user->first_name }}،
                        </p>

                        <p style="margin:0 0 20px;font-size:16px;line-height:30px;color:#4B5563;">
                            تلقينا طلبًا لإعادة تعيين كلمة المرور الخاصة بحسابك في
                            <strong style="color:#000D3F;">معرض الفنون الرقمية</strong>.
                        </p>

                        <p style="margin:0 0 35px;font-size:16px;line-height:30px;color:#4B5563;">
                            لإكمال العملية، يرجى الضغط على الزر التالي لإنشاء كلمة مرور جديدة.
                        </p>

                        <!-- Button -->
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center">

                                    <a href="{{ $resetUrl }}"
                                       style="
                                            background:#F36A10;
                                            color:#FFFFFF;
                                            text-decoration:none;
                                            display:inline-block;
                                            padding:15px 35px;
                                            border-radius:8px;
                                            font-size:16px;
                                            font-weight:bold;">
                                        إعادة تعيين كلمة المرور
                                    </a>

                                </td>
                            </tr>
                        </table>

                        <!-- Notice -->
                        <table role="presentation"
                               width="100%"
                               cellpadding="0"
                               cellspacing="0"
                               style="margin-top:40px;background:#F9FAFB;border-right:4px solid #000D3F;border-radius:6px;">

                            <tr>
                                <td style="padding:18px;">

                                    <p style="margin:0;font-size:15px;line-height:28px;color:#4B5563;">
                                        <strong style="color:#000D3F;">تنبيه:</strong><br>
                                        صلاحية رابط إعادة تعيين كلمة المرور هي
                                        <strong style="color:#F36A10;">10 دقائق</strong>.
                                    </p>

                                </td>
                            </tr>

                        </table>

                        <p style="margin:30px 0 0;font-size:15px;line-height:28px;color:#6B7280;">
                            إذا لم تقم بطلب إعادة تعيين كلمة المرور، يمكنك تجاهل هذه الرسالة بأمان،
                            ولن يتم إجراء أي تغيير على حسابك.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center"
                        style="background:#000D3F;padding:25px;">

                        <p style="margin:0;color:#FFFFFF;font-size:16px;font-weight:bold;">
                            فريق معرض الفنون الرقمية
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

