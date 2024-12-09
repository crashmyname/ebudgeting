<section class="section">
    <div class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url().'/home'?>">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">Hi, <?= $user->username?></h2>
        <p class="section-lead">
            Change information about yourself on this page.
        </p>

        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <?php if(!$user->profile):?>
                        <img alt="image" src="<?= asset('stisla-1-2.2.0/dist/assets/img/avatar/avatar-1.png')?>"
                            class="rounded-circle profile-widget-picture">
                        <?php else: ?>
                        <img alt="image" src="<?= asset('profile-users/'.$user->profile)?>"
                            class="rounded-circle profile-widget-picture">
                        <?php endif; ?>
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Posts</div>
                                <div class="profile-widget-item-value">187</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Followers</div>
                                <div class="profile-widget-item-value">6,8K</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Following</div>
                                <div class="profile-widget-item-value">2,1K</div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name"><?= $user->name?> <div
                                class="text-muted d-inline font-weight-normal">
                                <div class="slash"></div> <?= $user->level?>
                            </div>
                        </div>
                        <?= $user->name?> is a <?= $user->level?> in <b>Indonesia Stanley Electric</b>.
                    </div>
                    <div class="card-footer text-center">
                        <div class="font-weight-bold mb-2">Follow <?= $user->name?> On</div>
                        <a href="#" class="btn btn-social-icon btn-facebook mr-1">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-social-icon btn-twitter mr-1">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-social-icon btn-github mr-1">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="btn btn-social-icon btn-instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                    <form method="post" action="<?= base_url().'/user/profile/'.$user->uuid ?>" enctype="multipart/form-data">
                        <?= csrf()?>
                        <div class="card-header">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Username</label>
                                    <input type="text" class="form-control" value="<?= $user->username?>" name="username" readonly>
                                    <div class="invalid-feedback">
                                        Please fill in the username
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Name</label>
                                    <input type="text" class="form-control" value="<?= $user->name?>" name="name">
                                    <div class="invalid-feedback">
                                        Please fill in the name
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="<?= $user->email?>" name="email">
                                    <div class="invalid-feedback">
                                        Please fill in the email
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Dept</label>
                                    <input type="text" class="form-control" value="<?= $user->dept?>" name="dept">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password">
                                    <div class="invalid-feedback">
                                        Please fill in the password
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Profile</label>
                                    <input type="file" class="form-control" name="foto">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
