<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <?php $user = \Support\Session::user(); ?>
            <?php echo \Support\Session::user()->username ?>
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
        </div>
    </div>
</section>