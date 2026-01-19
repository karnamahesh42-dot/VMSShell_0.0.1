<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Group Visitor Gate Pass</title>

<style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #ffffff;
}


/* === HEADER === */
.header {
    background: #0f3b3f;
    color: #fff;
    padding: 14px;
    text-align: center;
    font-size: 18px;
    font-weight: 700;
    border-radius: 14px 14px 0 0;
}

/* === TITLE === */
.title {
    text-align: center;
    font-size: 14px;
    font-weight: 600;
    color: #123b3d;
    margin: 10px 0;
}

/* === QR GRID (DOMPDF SAFE) === */
.qr-grid {
    display: table;
    width: 100%;
}

.qr-row {
    display: table-row;
}

.qr-item {
    display: table-cell;
    width: 50%;
    text-align: center;
    padding: 10px;
    vertical-align: top;
}

/* QR IMAGE */
.qr-item img {
    width: 120px;
    height: 120px;
    border: 3px solid #fff;
    border-radius: 12px;
    background: #fff;
    margin-bottom: 6px;
}

/* TEXT */
.qr-code {
    font-size: 14px;
    font-weight: bold;
    color: #145a61;
}

.qr-name {
    font-size: 11px;
    font-weight: 600;
    color: #333;
}

.footer {
    margin-top: 10px;
    padding-top: 6px;
    font-size: 9px;
    text-align: center;
    border-top: 1px dashed #444;
}

.address {
    text-align: center;
    font-size: 12px;
    color: #333;
    line-height: 1.5;
    margin-bottom: 20px;
}


/* === CARD === */
.container {
    width: 100%;
    border: 3px solid #0f3b3f;
    border-radius: 18px;
    background: #e4f0f1;
    padding: 12px;
    position: relative;   /* 🔥 REQUIRED */
    overflow: hidden;
}

/* === WATERMARK === */
.watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 420px;
    opacity: 0.12;
    z-index: 1;
}

/* === CONTENT ABOVE WATERMARK === */
.header,
.title,
.qr-grid,
.address,
.footer {
    position: relative;
    z-index: 5;
}
</style>
</head>

<body>

<div class="container">
   <!-- Watermark Logo -->
    <img src="file://<?= realpath(FCPATH . 'public/dist/rfc_log_hight.png') ?>" class="watermark">

    <div class="header">
        AUTHORIZED VISITOR PASSES
    </div>

    <div class="title">
        <?= esc($visitors[0]['referred_by_name']) ?> has invited the following visitors
    </div>

    <div class="qr-grid">

        <?php
        $count = 0;
        foreach ($visitors as $v):

            if ($count % 2 === 0) echo '<div class="qr-row">';
        ?>

            <div class="qr-item">
                <img src="file://<?= realpath(FCPATH . 'public/uploads/qr_codes/' . $v['qr_code']) ?>" alt="QR Code">
                <div class="qr-code"><?= esc($v['v_code']) ?></div>
                <div class="qr-name"><?= esc($v['visitor_name']) ?></div>

            </div>

        <?php
            $count++;
            if ($count % 2 === 0) echo '</div>';
        endforeach;

        if ($count % 2 !== 0) echo '</div>';
        ?>

    </div>
    <div class="address">
        <?= $v['company']?>-<?= $v['department_name']?>, Ramoji Film City <br>
            Hyderabad, Telangana, 501512<br>
    </div>
    <div class="footer">
        This pass is system generated and valid only for the specified date & time.
    </div>

</div>

</body>
</html>
