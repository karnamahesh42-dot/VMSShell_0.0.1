<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Professional Visitor Gate Pass</title>
<style>
/* === Page Styles === */
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #ffffff; /* page background */
    text-align: center;
}
/* === Container/Card === */
.container {
    width: 440px;
    /* margin: 50px auto; */
    background-color: #e4f0f1; /* light card */
    border: 3px solid #0f3b3f; /* corporate border */
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    position: relative;
    padding: 0;
}

/* === Watermark Logo inside Card === */
.watermark {
    position: absolute;
    top: 225px;
    left: 50%;
    transform: translateX(-50%);
    width: 400px;
    opacity: 0.2;
    z-index: 0;
}

/* === Header === */
.header {
    background: #0f3b3f;
    color: #fff;
    padding: 20px;
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 1px;
    position: relative;
    z-index: 1;
    border-radius: 17px 17px 0 0;
}

/* === Content === */
.content {
    padding: 25px 20px;
    position: relative;
    z-index: 1;
}

.title {
    font-size: 18px;
    font-weight: 600;
    color: #123b3d;
    margin-bottom: 5px;
}

.subtitle {
    font-size: 13px;
    color: #555;
    margin-bottom: 15px;
}

/* === QR Code === */
.qr-wrapper {
    margin-bottom: 15px;
}

.qr-wrapper img {
    width: 160px;
    height: 160px;
    border: 4px solid #f0f0f0;
    border-radius: 16px;
    background: #fff;
}

/* === OTP Ticket === */
.otp-ticket {
    display: inline-block;
    background-color: #145a61;
    color: #fff;
    font-size: 28px;
    font-weight: 700;
    padding: 12px 40px;
    position: relative;
    margin-bottom: 18px;
    border-radius: 20px;
}

/* Notch edges for OTP */
.otp-ticket::before,
.otp-ticket::after {
    content: "";
    position: absolute;
    width: 20px;
    height: 20px;
    top: 6%;
    background: #e4f0f1;
    border-radius: 50%;
    transform: translateY(-50%);
}

.otp-ticket::before { left: -10px; }
.otp-ticket::after { right: -10px; }

/* === Date/Time & Address === */
.datetime {
    font-size: 13px;
    font-weight: 600;
    color: #7a5b2e;
    margin-bottom: 10px;
}
.visitordetails{
    font-size: 12px;
    font-weight: 600;
    color: #145a61;
    margin-bottom: 5px;
}
.address {
    font-size: 12px;
    color: #333;
    line-height: 1.5;
    margin-bottom: 20px;
}

/* === Footer === */
.footer {
    font-size: 10px;
    color: #888;
    border-top: 1px dashed #4d4343;
    padding: 10px 0;
}
</style>
</head>

<body>

<div class="container">

    <!-- Watermark Logo -->
    <!-- <img src="<?= base_url('/public/dist/rfc_log_hight.png') ?>" class="watermark" alt="Watermark Logo"> -->
    <img src="file://<?= realpath(FCPATH . 'public/dist/rfc_log_hight.png') ?>" class="watermark">
    <!-- Header -->
    <div class="header">
       AUTHORIZED VISITOR PASS
    </div>

    <!-- Content -->
    <div class="content">
        <div class="title"><?= $mailData['referred_by_name']?> has invited you</div>
        <div class="subtitle">Present this QR code or Visitor ID at the security gate</div>

        <!-- QR Code -->
        <div class="qr-wrapper">
            <!-- <img src="<?= base_url('/public/uploads/qr_codes/').$mailData['qr_code'] ?>" alt="QR Code"> -->
         <img src="file://<?= realpath(FCPATH . 'public/uploads/qr_codes/' . $mailData['qr_code']) ?>" alt="QR Code">
    
        </div>

        <!-- OTP -->
        <div class="otp-ticket"><?= $mailData['v_code']?></div>
        <div class="visitordetails">Visitor: <?= $mailData['visitor_name']?> - Purpose : <?= $mailData['purpose']?></div>
        <!-- Date/Time -->
        <div class="datetime">Date: <?= $mailData['visit_date']?> - Time : <?= $mailData['visit_time']?></div>

        <!-- Address -->
        <div class="address">
            <?= $mailData['company']?>-<?= $mailData['department_name']?>, Ramoji Film City <br>
             Hyderabad, Telangana, 501512<br>
        </div>

        <!-- Footer -->
        <div class="footer">
            This pass is system generated and valid only for the specified date & time.
        </div>
    </div>

</div>

</body>
</html>
