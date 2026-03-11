<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow"> 
    <title>RFC Access360</title>
    <link rel="icon" type="image/png" href="<?= base_url('public/dist/ramoji-logo-3.png') ?>">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
    /* ─── RESET ─────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ─── PAGE ──────────────────────────────── */
    html, body {
        height: 100%;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        overflow: hidden;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: linear-gradient(180deg, #3f80c5ff 20%, #3a6491ff 100%, #355374ff 90%);
        position: relative;
    }

    /* ─── WAVE BACKGROUND ───────────────────── */
    .wave-scene {
        position: fixed;
        inset: 0;
        z-index: 0;
        overflow: hidden;
    }

    /* Layer 1 – slow deep wave */
    .wave-scene .wave {
        position: absolute;
        bottom: 0;
        left: -200px;
        width: calc(100% + 400px);
        height: 260px;
        border-radius: 50% 60% 55% 50% / 40% 40% 60% 60%;
        opacity: 0.18;
        animation: waveRoll linear infinite;
    }

    .w1 {
        bottom: -40px;
        height: 320px;
        background: linear-gradient(135deg, #4158d0, #c850c0);
        animation-duration: 9s;
        animation-delay: 0s;
        opacity: 0.22;
    }
    .w2 {
        bottom: -10px;
        height: 270px;
        background: linear-gradient(135deg, #0093e9, #80d0c7);
        animation-duration: 12s;
        animation-delay: -3s;
        opacity: 0.18;
    }
    .w3 {
        bottom: 20px;
        height: 230px;
        background: linear-gradient(135deg, #8836e0ff, #2575fc);
        animation-duration: 15s;
        animation-delay: -6s;
        opacity: 0.15;
    }
    .w4 {
        bottom: 50px;
        height: 200px;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        animation-duration: 18s;
        animation-delay: -9s;
        opacity: 0.12;
    }

    /* TOP waves (mirror) */
    .w-top {
        bottom: auto !important;
        top: -60px;
        transform: scaleX(-1) scaleY(-1);
    }
    .wt1 {
        height: 160px;
        background: linear-gradient(135deg, #c850c0, #4158d0);
        animation-duration: 11s;
        animation-delay: -2s;
        opacity: 0.12;
    }
    .wt2 {
        height: 100px;
        background: linear-gradient(135deg, #3a1c71, #d76d77);
        animation-duration: 16s;
        animation-delay: -5s;
        opacity: 0.09;
    }

    @keyframes waveRoll {
        0%   { transform: translateX(0)    scaleY(1); }
        40%  { transform: translateX(-80px) scaleY(1.04); }
        60%  { transform: translateX(40px)  scaleY(0.97); }
        100% { transform: translateX(0)    scaleY(1); }
    }

    /* Floating radial blobs for depth */
    .blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(90px);
        animation: floatBlob linear infinite;
    }
    .b1 { width:420px; height:420px; background:radial-gradient(circle,#4158d0,#c850c0); top:-80px; left:-80px; opacity:.3; animation-duration:20s; }
    .b2 { width:360px; height:360px; background:radial-gradient(circle,#0093e9,#80d0c7); bottom:-60px; right:-60px; opacity:.25; animation-duration:24s; animation-delay:-8s; }
    .b3 { width:280px; height:280px; background:radial-gradient(circle,#f7971e,#ffd200); top:40%; left:65%; opacity:.15; animation-duration:28s; animation-delay:-14s; }

    @keyframes floatBlob {
        0%   { transform: translate(0,0); }
        30%  { transform: translate(25px,-35px); }
        60%  { transform: translate(-20px,20px); }
        100% { transform: translate(0,0); }
    }

    /* Dot-grid overlay */
    .wave-scene::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
        background-size: 36px 36px;
    }

    /* ─── CARD WRAPPER ───────────────────────── */
    .login-wrapper {
        position: relative;
        z-index: 10;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 16px;
    }

    /* ─── GLASS CARD ─────────────────────────── */
    .login-card {
        width: 430px;
        max-width: 100%;
        padding: 44px 40px 38px;
        border-radius: 26px;
        /* Merge from frosted glass top → pure white bottom */
        background: #ffffff;
        backdrop-filter: blur(28px) saturate(140%);
        -webkit-backdrop-filter: blur(28px) saturate(140%);
        border: 1px solid rgba(200,210,255,0.45);
        box-shadow:
            0 12px 50px rgba(30,50,140,0.22),
            0 2px 8px rgba(65,88,208,0.1),
            0 1px 0 rgba(255,255,255,0.95) inset;
        position: relative;
        overflow: hidden;
        animation: cardIn 0.75s cubic-bezier(0.22,0.61,0.36,1) both;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .login-card:hover {
        box-shadow:
            0 24px 64px rgba(30,50,140,0.28),
            0 4px 16px rgba(65,88,208,0.14),
            0 1px 0 rgba(255,255,255,0.95) inset;
        transform: translateY(-4px);
    }

    @keyframes cardIn {
        from { opacity:0; transform: translateY(32px) scale(0.96); }
        to   { opacity:1; transform: translateY(0)    scale(1); }
    }

    /* Rainbow accent bar */
    .login-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 6px;
        background: linear-gradient(90deg, #4158d0, #c850c0, #ff6b6b, #ffd200, #0093e9, #38ef7d, #4158d0);
        background-size: 400% 100%;
        animation: rainbowBar 5s linear infinite;
        border-radius: 4px 4px 0 0;
    }
    @keyframes rainbowBar {
        0%   { background-position: 0% 50%; }
        100% { background-position: 400% 50%; }
    }

    /* Soft pastel glow corner */
    .login-card::after {
        content: '';
        position: absolute;
        bottom: -60px; right: -60px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(65,88,208,0.08), transparent 70%);
        pointer-events: none;
    }

    /* ─── LOGOS ──────────────────────────────── */
    .logos-row {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
        margin-bottom: 8px;
    }

    .login-logo img {
        width: 95px; height: auto;
        filter: drop-shadow(0 2px 10px rgba(0,0,0,0.4));
        transition: transform 0.35s ease, filter 0.35s ease;
    }
    .login-logo img:hover {
        transform: scale(1.1) rotate(-2deg);
        filter: drop-shadow(0 4px 18px rgba(255,255,255,0.25));
    }

    .logo img {
        width: 230px; height: auto;
  
        transition: transform 0.35s ease, filter 0.35s ease;
    }
    .logo img:hover {
        transform: scale(1.05);
        filter: drop-shadow(0 4px 18px rgba(255,255,255,0.2)) brightness(1.2);
    }

    /* ─── DIVIDER ────────────────────────────── */
    .card-divider {
        border: none;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(100,120,220,0.25), transparent);
        margin: 14px 0 10px;
    }

    /* ─── HEADING ────────────────────────────── */
    .login-title {
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        color: rgba(40,55,130,0.6);
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 22px;
    }

    /* ─── FLASH ERROR ────────────────────────── */
    .alert-danger {
        background: rgba(220,53,69,0.08) !important;
        border: 1px solid rgba(220,53,69,0.35) !important;
        color: #c0392b !important;
        border-radius: 12px !important;
        font-size: 13px !important;
        padding: 10px 14px !important;
        margin-bottom: 18px !important;
        animation: shake 0.45s ease;
    }
    @keyframes shake {
        0%,100% { transform: translateX(0); }
        20%      { transform: translateX(-7px); }
        60%      { transform: translateX(7px); }
    }

    /* ─── LABELS ─────────────────────────────── */
    .form-label {
        font-size: 11px !important;
        font-weight: 700 !important;
        color: rgba(30,45,110,0.55) !important;
        letter-spacing: 1px !important;
        text-transform: uppercase !important;
        margin-bottom: 7px !important;
    }

    /* ─── INPUTS WITH ICONS ──────────────────── */
    .field-wrap {
        position: relative;
    }
    .field-wrap .fi {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(60,80,180,0.4);
        font-size: 13px;
        pointer-events: none;
        transition: color 0.25s ease;
        z-index: 2;
    }
    .field-wrap:focus-within .fi {
        color: #4158d0;
    }

    .form-control {
        background: rgba(255,255,255,0.9) !important;
        border: 1px solid rgba(180,195,255,0.6) !important;
        border-radius: 13px !important;
        color: #1a2050 !important;
        font-size: 14px !important;
        padding: 12px 40px 12px 40px !important;
        transition: border-color 0.25s, box-shadow 0.25s, background 0.25s !important;
        caret-color: #4158d0;
    }
    .form-control::placeholder {
        color: rgba(60,80,160,0.35) !important;
    }
    .form-control:focus {
        background: #ffffff !important;
        border-color: #4158d0 !important;
        box-shadow: 0 0 0 3px rgba(65,88,208,0.15) !important;
        outline: none !important;
        color: #0f1a50 !important;
    }

    /* pw toggle */
    .pw-eye {
        position: absolute;
        right: 13px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none; padding: 0;
        color: rgba(60,80,180,0.4);
        font-size: 13px;
        cursor: pointer;
        transition: color 0.2s;
        z-index: 2;
    }
    .pw-eye:hover { color: #4158d0; }

    /* ─── BUTTON ─────────────────────────────── */
    .btn-login {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 13px;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.6px;
        color: #fff;
        cursor: pointer;
        margin-top: 22px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #4158d0 0%, #c850c0 55%, #0093e9 100%);
        background-size: 220% 220%;
        background-position: 0% 50%;
        box-shadow: 0 6px 24px rgba(65,88,208,0.5);
        transition: background-position 0.55s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-login:hover {
        background-position: 100% 50%;
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(65,88,208,0.65);
    }
    .btn-login:active {
        transform: scale(0.97) translateY(0);
        box-shadow: 0 4px 16px rgba(65,88,208,0.4);
    }
    /* Shine sweep */
    .btn-login::after {
        content: '';
        position: absolute;
        top: 0; left: -80%;
        width: 55%; height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.24), transparent);
        transform: skewX(-18deg);
        transition: left 0.6s ease;
    }
    .btn-login:hover::after { left: 135%; }

    /* ─── FOOTER ─────────────────────────────── */
    .card-footer-txt {
        text-align: center;
        margin-top: 20px;
        font-size: 11px;
        color: rgba(255,255,255,0.25);
        letter-spacing: 0.3px;
    }

    /* ─── RESPONSIVE ─────────────────────────── */
    @media (max-width: 500px) {
        .login-card { padding: 34px 22px 28px; border-radius: 20px; }
        .logo img { width: 180px; }
        .login-logo img { width: 72px; }
    }


    .cursor-ripple {
    position: fixed;
    border-radius: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
    width: 18px;
    height: 18px;
    border: 2px solid rgba(255,255,255,0.5);
    animation: rippleWave 0.7s ease-out forwards;
    z-index: 9999;
}

@keyframes rippleWave {
    0% {
        opacity: 1;
        transform: translate(-50%, -50%) scale(0.2);
    }
    100% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(4);
    }
}

    </style>
</head>
<body>

<!-- ══ Wave / Blob Background ═════════════════════════════ -->
<div class="wave-scene">
    <!-- Blobs -->
    <div class="blob b1"></div>
    <div class="blob b2"></div>
    <div class="blob b3"></div>
    <!-- Bottom waves -->
    <div class="wave w1"></div>
    <div class="wave w2"></div>
    <div class="wave w3"></div>
    <div class="wave w4"></div>
    <!-- Top waves (mirrored) -->
    <div class="wave w-top wt1"></div>
    <div class="wave w-top wt2"></div>
</div>

<!-- ══ Login Card ═════════════════════════════════════════ -->
<div class="login-wrapper">
<div class="login-card">

    <!-- Logos -->
    <div class="logos-row">
        <div class="login-logo">
            <img src="<?= base_url('public/dist/ramoji-logo.png') ?>" alt="Logo">
        </div>
        <div class="logo">
            <img src="<?= base_url('public/dist/access360logo.png') ?>" alt="Logo">
        </div>
    </div>

    <hr class="card-divider">
    <div class="login-title">Access Your Account</div>

    <!-- ── PHP Flash Error (UNCHANGED) ── -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- ── Form (action / CSRF / names UNCHANGED) ── -->
    <form action="<?= base_url('login') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="field-wrap">
                <i class="fas fa-user fi"></i>
                <input type="text" name="username" class="form-control"
                       placeholder="Enter your username" required>
            </div>
        </div>

        <div class="mb-2">
            <label class="form-label">Password</label>
            <div class="field-wrap">
                <i class="fas fa-lock fi"></i>
                <input type="password" name="password" id="pwField"
                       class="form-control" placeholder="Enter your password" required>
                <button type="button" class="pw-eye" onclick="togglePw()" title="Show/Hide">
                    <i class="fas fa-eye" id="pwIcon"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt me-2"></i> Sign In
        </button>
    </form>

    <div class="card-footer-txt">
        &copy; <?= date('Y') ?> RFC Access360 &nbsp;·&nbsp; Secured &amp; Encrypted
    </div>

</div>
</div>

<script>
function togglePw() {
    const f = document.getElementById('pwField');
    const i = document.getElementById('pwIcon');
    if (f.type === 'password') {
        f.type = 'text';
        i.classList.replace('fa-eye','fa-eye-slash');
    } else {
        f.type = 'password';
        i.classList.replace('fa-eye-slash','fa-eye');
    }
}
/* ─── SMOOTH CURSOR WATER RIPPLE HOVER EFFECT ───────────────── */

let lastTime = 0;

document.addEventListener("mousemove", function(e) {

    const now = Date.now();

    if (now - lastTime < 80) return; // limit ripple creation

    lastTime = now;

    const ripple = document.createElement("span");
    ripple.className = "cursor-ripple";

    ripple.style.left = e.clientX + "px";
    ripple.style.top = e.clientY + "px";

    document.body.appendChild(ripple);

    setTimeout(() => {
        ripple.remove();
    }, 700);

});
</script>
</body>
</html>
