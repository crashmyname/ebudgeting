<section class="section">
    <div class="section-header">
        <h1>Users</h1>
    </div>

    <div class="section-body">
        <b>User Management</b>
    </div>
    <div class="card-body">
        <?php $user = \Support\Session::user();?>
        <?php foreach($user->menus as $menu):?>
        <?= ($menu->menu_id == 1 && $menu->can_create == 1) ? '<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add +</button>' : null ?>
        <?= ($menu->menu_id == 1 && $menu->can_update == 1) ? '<button class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">Update +</button>' : null ?>
        <?= ($menu->menu_id == 1 && $menu->can_delete == 1) ? '<button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Delete +</button>' : null ?>
        <?php endforeach;?>
    </div>
    <div class="card-body">
        <table id="datatable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Dept</th>
                    <th>Email</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Dept</th>
                    <th>Email</th>
                    <th>Level</th>
                </tr>
            </tfoot>
        </table>
    </div>
</section>
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="POST" id="formadduser" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <?= csrf();?>
                            <label>Username</label>
                            <input type="text" name="username" id="username" class="form-control">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <label>Departement</label>
                            <input type="text" name="departement" id="departement" class="form-control">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <label>Level</label>
                            <input type="text" name="level" id="level" class="form-control">
                            <label>Role</label>
                            <input type="text" name="role_id" id="role_id" class="form-control">
                        </div>
                        <div class="row-body">
                            <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="adduser">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    // Fungsi inisialisasi DataTables khusus untuk halaman ini
    function initDataTable() {
        if ($.fn.dataTable.isDataTable('#datatable')) {
            $('#datatable').DataTable().clear().destroy(); // Hancurkan DataTable yang sudah ada
        }
        $('#datatable').DataTable({
            ajax: '<?= base_url() ?>/getusers',
            processing: true,
            serverSide: true,
            columns: [{
                    data: 'uuid',
                    name: 'uuid',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'dept',
                    name: 'dept'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'level',
                    name: 'level'
                },
            ]
        });
    }

    function crudUser() {
        $('#adduser').on('click', function(e) {
            e.preventDefault();
            var url = '<?= base_url() . '/users' ?>';
            var formData = new FormData($('#formadduser')[0]);
            $.ajax({
                type: 'POST',
                url: url,
                processData: false,
                contentType: false,
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire({
                            title: 'Success',
                            icon: 'success',
                            text: 'User Added',
                        });
                        initDataTable().DataTable.ajax.reload();
                        $('#formadduser')[0].reset();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            icon: 'error',
                            text: 'Error Added',
                        });
                    }
                }
            })
        })
    }

    // Panggil initDataTable saat halaman Products dimuat
    $(document).ready(function() {
        initDataTable();
        crudUser();
    });
</script>
