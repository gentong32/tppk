<?= $this->extend('layout/default') ?>

<?= $this->section('header') ?>
<style>
    body,
    html {
        height: 100%;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .login-form {
        width: 300px;
        padding: 20px;
        background-color: #f2f2f2;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .input-group {
        margin-bottom: 20px;
    }

    .input-group label {
        display: block;
        margin-bottom: 5px;
    }

    .input-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    .btn {
        width: 100%;
        padding: 10px;
        border: none;
        background-color: #4caf50;
        color: white;
        cursor: pointer;
        border-radius: 3px;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #45a049;
    }

    .alert-danger {
        color: red;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<div class="content-wrap">
    <div class="container">
        <form class="login-form" action="<?= base_url() ?>login/ceklogin" method="post">
            <?= csrf_field() ?>
            <h2>Login</h2>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>