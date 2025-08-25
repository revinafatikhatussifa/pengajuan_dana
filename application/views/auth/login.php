<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-primary">

<div class="container mt-5">
    <div class="card mx-auto shadow" style="max-width: 400px;">
        <div class="card-body">
            <h4 class="text-center mb-4">Login</h4>

            <!-- Tampilkan pesan flashdata (success/error) -->
            <?php if ($this->session->flashdata('message')): ?>
                <?= $this->session->flashdata('message'); ?>
            <?php endif; ?>

            <form action="<?= base_url('auth'); ?>" method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input 
                        type="text" 
                        name="email" 
                        class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" 
                        value="<?= set_value('email'); ?>">
                    <div class="invalid-feedback">
                        <?= form_error('email'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('password'); ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

            <div class="text-center mt-3">
                <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Forgot Password?</a>
            </div>
            <div class="text-center">
                <a class="small" href="<?= base_url('auth/registration'); ?>">Create an Account!</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
