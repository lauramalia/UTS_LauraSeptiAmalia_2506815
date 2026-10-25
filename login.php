<?php
session_start();

if (isset($_SESSION['id_user'], $_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: main_admin.php");
    } else {
        header("Location: main_petugas.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | TambakCare</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body style="min-height:100vh; margin:0; font-family:'Segoe UI', Arial, sans-serif; background:#F3F8FD;">

    <div class="container-fluid p-2" style="min-height:100vh;">

        <div class="row g-0 h-100" style="min-height:calc(100vh - 16px);">

            <!-- BAGIAN KIRI: FOTO DAN IDENTITAS TAMBAKCARE -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center text-center"
                 style="position:relative; min-height:350px; padding:40px; background:linear-gradient(rgba(225,241,255,0.40),rgba(225,241,255,0.20)),url('tambak.jpg') center center/cover no-repeat; border:1px solid #D6E4F2; border-radius:6px 0 0 6px;">

                <div style="max-width:480px;">

                    <div class="mb-3" style="font-size:65px; color:#1675D1;">
                        <i class="bi bi-water"></i>
                    </div>

                    <h1 class="fw-bold mb-3"
                        style="font-size:clamp(36px,4vw,52px); letter-spacing:-1.8px; color:#0B315B;">
                        Tambak<span style="color:#1687A8;">Care</span>
                    </h1>

                    <h5 class="fw-bold mb-3"
                        style="font-size:17px; line-height:1.5; color:#082747;">
                        Pantau Kualitas Air, Jaga Kesehatan Ikan
                    </h5>

                    <p class="mb-0"
                       style="font-size:14px; line-height:1.8; color:#082747;">
                        Sistem monitoring kualitas air tambak ikan bandeng
                        untuk budidaya yang lebih optimal.
                    </p>

                </div>

            </div>


            <!-- BAGIAN KANAN: FORM LOGIN -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center"
                 style="padding:40px 24px; background:linear-gradient(135deg,#FFFFFF 0%,#F8FBFE 100%); border:1px solid #D6E4F2; border-left:none; border-radius:0 6px 6px 0;">

                <div class="card border-0 p-4 p-md-5"
                     style="width:100%; max-width:390px; border-radius:9px; background:#FFFFFF; border:1px solid #D6E4F2 !important; box-shadow:0 8px 25px rgba(11,49,91,0.06);">


                    <div class="text-center mb-4">

                        <h3 class="fw-bold mb-2"
                            style="font-size:23px; color:#0B315B;">
                            Welcome Back
                        </h3>

                        <p class="mb-0"
                           style="font-size:13px; color:#607B99;">
                            Sign in to your TambakCare dashboard
                        </p>

                    </div>


                    <form action="proses_login.php" method="post">

                        <!-- USERNAME -->
                        <div class="mb-3">

                            <label for="id_akun" class="form-label fw-semibold"
                                   style="font-size:13px; color:#0B315B;">
                                Username
                            </label>

                            <div class="input-group">

                                <span class="input-group-text"
                                      style="color:#0B315B; background:#FFFFFF; border:1px solid #D6E4F2; border-radius:6px 0 0 6px;">
                                    <i class="bi bi-person"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="username"
                                    name="username"
                                    placeholder="Enter username"
                                    autocomplete="username"
                                    style="padding:12px; font-size:13px; color:#0B315B; border:1px solid #D6E4F2; border-radius:0 6px 6px 0;"
                                    required>

                            </div>

                        </div>


                        <!-- PASSWORD -->
                        <div class="mb-4">

                            <label for="password" class="form-label fw-semibold"
                                   style="font-size:13px; color:#0B315B;">
                                Password
                            </label>

                            <div class="input-group">

                                <span class="input-group-text"
                                      style="color:#0B315B; background:#FFFFFF; border:1px solid #D6E4F2; border-radius:6px 0 0 6px;">
                                    <i class="bi bi-lock"></i>
                                </span>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Enter password"
                                    autocomplete="current-password"
                                    style="padding:12px; font-size:13px; color:#0B315B; border:1px solid #D6E4F2; border-radius:0;"
                                    required>

                                <button
                                    type="button"
                                    class="input-group-text"
                                    id="togglePassword"
                                    aria-label="Tampilkan password"
                                    style="cursor:pointer; color:#0B315B; background:#FFFFFF; border:1px solid #D6E4F2; border-radius:0 6px 6px 0;">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>

                            </div>

                        </div>


                        <!-- TOMBOL LOGIN -->
                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn fw-semibold text-white"
                                style="padding:12px 16px; border:1px solid #1675D1; border-radius:6px; background:#1675D1; font-size:14px;">

                                Login
                                <i class="bi bi-arrow-right ms-2"></i>

                            </button>

                        </div>

                    </form>


                    <div class="text-center mt-4"
                         style="font-size:12px; color:#607B99;">
                        Sistem Monitoring Kualitas Air Tambak
                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>