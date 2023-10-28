<!--

=========================================================
* Argon Design System - v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-design-system
* Copyright 2019 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================-->
<!DOCTYPE html>
<html lang="id-ID">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SSO</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"> -->
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
    <!-- <meta name="google-signin-client_id" content="http://616197515670-6inuseg2s847qpqnhd4617cc77mblcmq.apps.googleusercontent.com"> -->

    <!-- <meta name="google-signin-client_id" content="616197515670-6inuseg2s847qpqnhd4617cc77mblcmq.apps.googleusercontent.com"> -->
    <!-- <meta name="google-signin-client_id" content="http://616197515670-6inuseg2s847qpqnhd4617cc77mblcmq"> -->
    <!-- <meta name="google-signin-client_id" content="341532050914-djnhe3bbf35dln4tv880urjj2ljfaamc.apps.googleusercontent.com"> -->

    <meta name="csrf-param" content="_csrf">
    <meta name="csrf-token" content="ng4cDMJoN_9pa4oG6Kk-6FvGvn73Oyoy7q2lQqK_RYDtTEZOiiBUuxknulSm-w-saJ-NO7R0dXCP3cwSltk1xA==">

    <link href="<?= base_url() . 'css_dummy/authchoice.css' ?>" rel="stylesheet">
    <link href="<?= base_url() . 'css_dummy/bootstrap.css' ?>" rel="stylesheet">
    <link href="<?= base_url() . 'css_dummy/argon_ori.css' ?>" rel="stylesheet">
    <link href="<?= base_url() . 'css_dummy/nucleo.css' ?>" rel="stylesheet">
    <link href="<?= base_url() . 'css_dummy/font-awesome.css' ?>" rel="stylesheet">
    <style>
        div.required label.control-label:after {
            content: " *";
            color: red;
        }
    </style>
</head>

<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>

<body>
    <header class="header-global">
        <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand mr-lg-5" href="/">
                    <img alt="sdm" src="<?= base_url() . 'css_dummy/logo-tutwuri.png' ?>">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse" id="navbar_global">
                    <div class="navbar-collapse-header">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a href="/">
                                    <img alt="sdm" src="<?= base_url() . 'css_dummy/logo-tutwuri.png' ?>">
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section class="section  pb-0">
            <div class="container">

                <div class="text-center">
                    <div class="">

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- Berita -->
                        <div class="card bg-secondary shadow border-1">
                            <div class="card-body bg-white">
                                <div class="pengguna-form small">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <!-- Login -->
                        <div class="card bg-secondary shadow border-1">
                            <div class="card-body px-lg-5 py-lg-5">
                                <div class="card-title text-center">
                                    <h3>Login</h3>
                                </div>
                                <div class="pengguna-form">
                                    <form id="w0" action="<?= base_url() . 'login/cek_dummy' ?>" method="post" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <div id="ket">
                                            <?php if (!empty($flashMessage)) : ?>
                                                <p style="font-weight:bold;color:red;font-style:italic;"><?= $flashMessage ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group field-pengguna-email required">
                                                    <label for="pengguna-email">Email</label>
                                                    <input type="text" id="pengguna-email" class="form-control" name="Pengguna[email]" aria-required="true">

                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group field-pengguna-password required">
                                                    <label for="pengguna-password">Password</label>
                                                    <input type="password" id="pengguna-password" class="form-control" name="Pengguna[password]" aria-required="true">

                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn btn-success mt-3 text-center">Login</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="text-muted text-center mb-3">
                                    <small>atau masuk dengan</small>
                                </div>
                                <div id="w1">
                                    <ul>
                                        <a class="btn btn-outline-info btn-block auth-link" href="/sys/auth?authclient=google&amp;appkey=4cade60a-2f9f-4946-8839-a4df754b1621" title="Google"><span class=""></span> Belajar.Id</a>
                                    </ul>
                                </div>
                            </div>
                            <div class="text-muted text-center">
                                <small><a href="/dokumen/term-of-service">Ketentuan</a></small> |
                                <small><a href="/dokumen/privacy-policy">Privasi</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer section pt-5 pt-md-5 pt-lg-8 pb-4 mt-4">
        <div class="pattern  top"></div>
        <div class="container">
            <div class="row">
                <div class="col mb-4">
                    <div class="row justify-content-md-center">
                        <div class="col-3 justify-content-md-center">
                            <a class="mr-lg-5" href="/">
                                <img class="img-fluid" src="/web/logo-tutwuri.png" alt="Kemdikbud">
                            </a>
                        </div>
                        <div class="col">
                            <h6>
                                Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi
                            </h6>
                            <h6>Republik Indonesia</h6>
                        </div>
                    </div>
                </div>
                <div class="col mb-4 mb-lg-0">
                    <h5 class="">Tautan Terkait</h5>
                    <ul class="links-vertical">
                        <li><a target="_blank" href="https://referensi.data.kemdikbud.go.id">Referensi</a></li>
                        <li><a target="_blank" href="https://sekolah.data.kemdikbud.go.id">Sekolah Kita</a>
                        <li><a target="_blank" href="https://jendela.data.kemdikbud.go.id">Jendela Pendidikan</a>
                        <li><a target="_blank" href="https://rumahbelajar.kemdikbud.go.id">Rumah Belajar</a></li>
                        </li>
                    </ul>
                </div>
                <div class="col text-right">
                    <h5>Hubungi Kami</h5>
                    <div class="font-small">Layanan Terpadu Kemendikbud Ristek</div>
                    <div class="font-small">Gedung C Lantai 1 Kompleks Kemendikbud Ristek Senayan Jakarta, 10270</div>

                    <div class="font-small">Contact Center : 177<br>
                        Live Chat via : ult.kemdikbud.go.id</div>
                    <p><i class="fa fa-envelope"></i> <a href="mailto:pengaduan@kemdikbud.go.id">pengaduan@kemdikbud.go.id</a></p>

                </div>
            </div>
            <hr class="m-3">
            <div class="text-center font-small">&#169; PUSDATIN</div>
        </div>
    </footer>
    <script>
        setTimeout(function() {
            var ket = document.getElementById('ket');
            ket.style.display = 'none';
        }, 3000);
    </script>
</body>

</html>