<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <?php if (\Support\Session::hasFlash('success')): ?>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: "<?= \Support\Session::flash('success') ?>",
                        showConfirmButton: false,
                        timer: 1000
                    });
                </script>
            <?php endif; ?>
            <div class="col-12 mb-4">
                <div class="hero bg-primary text-white">
                  <div class="hero-inner">
                  <?php $user = \Support\Session::user(); ?>
                  
                    <h2>Welcome Back, <?php echo \Support\Session::user()->username ?>!</h2>
                    <p class="lead">This page is a place to manage dashboard and more.</p>
                  </div>
                </div>
              </div>
              <a href="<?= base_url().'/kirim-email'?>">Test Kirim EMail</a>
        </div>
    </div>
</section>