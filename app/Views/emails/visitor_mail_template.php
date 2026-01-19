<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Visitor Pass | Ramoji Film City</title>
</head>

<body style="margin:0; padding:0; background:#eef2f7; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:25px; background:#eef2f7;">
<tr>
<td align="center">

    <!-- Email Card -->
    <table width="600" cellpadding="0" cellspacing="0"
           style="
               background:#ffffff;
               border-radius:14px;
               box-shadow:0 8px 25px rgba(0,0,0,0.15);
               overflow:hidden;
               border: 2px solid #0056a6;   /* OUTER CARD BORDER */
           ">

        <!-- HEADER -->
        <tr>
            <td style="
                background: linear-gradient(135deg, #001f3f, #0056a6);
                padding:20px;
                text-align:center;
            ">
                <img src="https://www.nicepng.com/png/detail/37-376583_ramoji-film-city-hyderabad-logo.png"
                     alt="Ramoji Logo"
                     style="width:160px; margin-bottom:5px;">

                <h2 style="margin:0; font-size:20px; color:#ffffff;">Visitor Pass Confirmation</h2>
                <p style="margin:6px 0 0; font-size:14px; color:#dde7f7;">
                    Your visit has been officially registered
                </p>
            </td>
        </tr>

        <!-- BODY -->
        <tr>
            <td style="padding:30px;">

                <p style="font-size:16px; color:#222; margin-top:0;">
                    Hello <strong><?= esc($name) ?></strong>,
                </p>

                <p style="font-size:14px; color:#555; line-height:1.6; margin-top:10px;">
                    Thank you for scheduling your visit. Below are your visitor details and QR code.
                    Present this QR at the security gate for entry into
                    <strong>Ramoji Film City</strong>.
                </p>

                <!-- DETAILS BOX -->
                <table width="100%" cellpadding="10" cellspacing="0"
                       style="
                           background:#f7f9fc;
                           border:1px solid #cfd6e4;
                           border-radius:10px;
                           margin-top:18px;
                           font-size:14px;
                       ">

                    <!-- NAME -->
                    <tr>
                        <td style="font-weight:bold; color:#001f3f; width:35%; text-align:right; padding-right:10px;">
                            Name:
                        </td>
                        <td style="color:#333;">
                            <?= esc($name) ?>
                        </td>
                    </tr>

                    <!-- PHONE -->
                    <tr>
                        <td style="font-weight:bold; color:#001f3f; text-align:right; padding-right:10px;">
                            Phone:
                        </td>
                        <td style="color:#333;">
                            <?= esc($phone) ?>
                        </td>
                    </tr>

                    <!-- PURPOSE -->
                    <tr>
                        <td style="font-weight:bold; color:#001f3f; text-align:right; padding-right:10px;">
                            Purpose:
                        </td>
                        <td style="color:#333;">
                            <?= esc($purpose) ?>
                        </td>
                    </tr>

                    <!-- V-CODE -->
                    <tr>
                        <td style="font-weight:bold; color:#001f3f; text-align:right; padding-right:10px;">
                            V-Code:
                        </td>
                        <td style="color:#333;">
                            <?= esc($v_code) ?>
                        </td>
                    </tr>

                </table>

                <!-- QR CODE -->
                <div style="text-align:center; margin-top:28px;">
                    <h3 style="color:#001f3f; margin-bottom:6px; font-size:18px;">
                        Entry QR Code
                    </h3>

                    <p style="font-size:13px; color:#777; margin-top:0;">
                        Show this QR at the entrance
                    </p>

                    <img src="https://quickchart.io/qr?text=TEST123&size=200"
                         alt="QR Code"
                         style="
                             width:180px;
                             height:180px;
                             border-radius:10px;
                             border:2px solid #0056a6;
                             padding:6px;
                             background:white;
                         ">
                </div>

            </td>
        </tr>

        <!-- FOOTER -->
        <tr>
            <td style="
                background:#e53935;
                padding:14px;
                text-align:center;
                color:#ffffff;
                font-size:12px;
            ">
                © 2025 Ramoji Film City • Visitor Management System
            </td>
        </tr>

    </table>

</td>
</tr>
</table>

</body>
</html> -->
