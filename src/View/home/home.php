<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <?php $user = \Support\Session::user(); ?>
            <?php echo \Support\Session::user()->username ?>
        </div>
    </div>
</section>