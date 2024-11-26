<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <?php $user = \Support\Session::user();
            echo $user->menu_id?>
        </div>
    </div>
</section>