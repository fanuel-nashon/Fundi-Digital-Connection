<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted — Fundi Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#f1f5f9; display:flex; align-items:center; justify-content:center; min-height:100vh; }
        .card { border:none; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); max-width:480px; width:100%; }
        .icon-wrap { width:72px; height:72px; border-radius:50%; background:#f0fdf4; display:flex; align-items:center; justify-content:center; margin:0 auto 1.25rem; }
    </style>
</head>
<body>
<div class="card p-5 text-center">
    <div class="icon-wrap">
        <i class="bi bi-clock-history fs-2 text-success"></i>
    </div>
    <h4 class="fw-bold mb-2">Application Submitted!</h4>
    <p class="text-muted mb-4">
        Your account is currently <strong>pending admin review</strong>.<br>
        Once approved, you will receive an email with your <strong>login credentials</strong>.
    </p>

    <div class="rounded-3 p-3 mb-4 text-start" style="background:#f8fafc;border:1px solid #e2e8f0;font-size:.84rem">
        <div class="d-flex gap-2 mb-2">
            <i class="bi bi-check-circle-fill text-success mt-1"></i>
            <span>Application received and queued for review</span>
        </div>
        <div class="d-flex gap-2 mb-2">
            <i class="bi bi-hourglass-split text-warning mt-1"></i>
            <span>Admin reviews and approves your account</span>
        </div>
        <div class="d-flex gap-2">
            <i class="bi bi-envelope-fill text-primary mt-1"></i>
            <span>Credentials sent to your email — you can log in</span>
        </div>
    </div>

    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Homepage
    </a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
