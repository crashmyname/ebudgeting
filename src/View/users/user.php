<section class="section">
    <div class="section-header">
        <h1>Users</h1>
    </div>

    <div class="section-body">
        <b>User Management</b>
    </div>
    <div class="card-body">
        <?php $user = \Support\Session::user(); ?>
        <?php foreach($user->menus as $menu):?>
        <?= $menu->menu_id == 1 && $menu->can_create == 1 ? '<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add +</button> <button class="btn btn-dark" data-toggle="modal" data-target="" id="modalrolemanagement">Role Management +</button>' : null ?>
        <?= $menu->menu_id == 1 && $menu->can_update == 1 ? '<button class="btn btn-warning" data-toggle="modal" data-target="" id="modalupdateuser">Update +</button>' : null ?>
        <?= $menu->menu_id == 1 && $menu->can_delete == 1 ? '<button class="btn btn-danger" type="submit" id="deleteuser">Delete +</button>' : '' ?>
        <?= $menu->menu_id == 1 && $menu->can_view == 1 ? '<button class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModalImport">Import Excel <i class="far fa-file-excel"></i></button> <button class="btn btn-success" type="submit" id="exportexcel">Export Excel <i class="fas fa-file-excel"></i></button> <button class="btn btn-dark" id="print">Print <i class="fas fa-print"></i></button> <button class="btn btn-outline-danger" id="exportpdf">Export PDF <i class="far fa-file-pdf"></i></button>' : '' ?>
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
                            <?= csrf() ?>
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
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModalEdit">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="POST" id="formupdateuser" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <?= csrf() ?>
                            <?= method('PUT') ?>
                            <label>Username</label>
                            <input type="text" name="username" id="uusername" class="form-control" readonly>
                            <label>Name</label>
                            <input type="text" name="name" id="uname" class="form-control">
                            <label>Departement</label>
                            <input type="text" name="departement" id="udepartement" class="form-control">
                            <label>Email</label>
                            <input type="email" name="email" id="uemail" class="form-control">
                            <label>Password</label>
                            <input type="text" name="password" id="upassword" class="form-control">
                            <label>Level</label>
                            <input type="text" name="level" id="ulevel" class="form-control">
                            <label>Role</label>
                            <input type="text" name="role_id" id="urole_id" class="form-control">
                        </div>
                        <div class="row-body">
                            <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" id="updateuser">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModalRole">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="POST" id="formrolemanagement" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Role Management</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <?= csrf() ?>
                            <label>Username</label>
                            <input type="text" name="username" id="roleuser" class="form-control" readonly>
                            <!-- <label>Menu User</label> -->
                            <div class="form-group">
                                <h6><label class="d-block">Menu User</label></h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_user_view"
                                        name="menu_user[]" value="view">
                                    <label class="form-check-label" for="menu_user_view">View</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_user_add"
                                        name="menu_user[]" value="add">
                                    <label class="form-check-label" for="menu_user_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_user_edit"
                                        name="menu_user[]" value="edit">
                                    <label class="form-check-label" for="menu_user_edit">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_user_delete"
                                        name="menu_user[]" value="delete">
                                    <label class="form-check-label" for="menu_user_delete">Delete</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6><label class="d-block">Menu Category Expenses</label></h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_category_view"
                                        name="menu_category[]" value="view">
                                    <label class="form-check-label" for="menu_category_view">View</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_category_add"
                                        name="menu_category[]" value="add">
                                    <label class="form-check-label" for="menu_category_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_category_edit"
                                        name="menu_category[]" value="edit">
                                    <label class="form-check-label" for="menu_category_edit">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_category_delete"
                                        name="menu_category[]" value="delete">
                                    <label class="form-check-label" for="menu_category_delete">Delete</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6><label class="d-block">Menu Timer Expenses</label></h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_timer_view"
                                        name="menu_timer[]" value="view">
                                    <label class="form-check-label" for="menu_timer_view">View</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_timer_add"
                                        name="menu_timer[]" value="add">
                                    <label class="form-check-label" for="menu_timer_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_timer_edit"
                                        name="menu_timer[]" value="edit">
                                    <label class="form-check-label" for="menu_timer_edit">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_timer_delete"
                                        name="menu_timer[]" value="delete">
                                    <label class="form-check-label" for="menu_timer_delete">Delete</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6><label class="d-block">Menu Item & Price</label></h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_item_view"
                                        name="menu_item[]" value="view">
                                    <label class="form-check-label" for="menu_item_view">View</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_item_add"
                                        name="menu_item[]" value="add">
                                    <label class="form-check-label" for="menu_item_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_item_edit"
                                        name="menu_item[]" value="edit">
                                    <label class="form-check-label" for="menu_item_edit">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_item_delete"
                                        name="menu_item[]" value="delete">
                                    <label class="form-check-label" for="menu_item_delete">Delete</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6><label class="d-block">Menu Cost Center</label></h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_type_view"
                                        name="menu_type[]" value="view">
                                    <label class="form-check-label" for="menu_type_view">View</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_type_add"
                                        name="menu_type[]" value="add">
                                    <label class="form-check-label" for="menu_type_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_type_edit"
                                        name="menu_type[]" value="edit">
                                    <label class="form-check-label" for="menu_type_edit">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_type_delete"
                                        name="menu_type[]" value="delete">
                                    <label class="form-check-label" for="menu_type_delete">Delete</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6><label class="d-block">Menu Unit Data</label></h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_unit_view"
                                        name="menu_unit[]" value="view">
                                    <label class="form-check-label" for="menu_unit_view">View</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_unit_add"
                                        name="menu_unit[]" value="add">
                                    <label class="form-check-label" for="menu_unit_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_unit_edit"
                                        name="menu_unit[]" value="edit">
                                    <label class="form-check-label" for="menu_unit_edit">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_unit_delete"
                                        name="menu_unit[]" value="delete">
                                    <label class="form-check-label" for="menu_unit_delete">Delete</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6><label class="d-block">Menu Dept</label></h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_dept_view"
                                        name="menu_dept[]" value="view">
                                    <label class="form-check-label" for="menu_dept_view">View</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_dept_add"
                                        name="menu_dept[]" value="add">
                                    <label class="form-check-label" for="menu_dept_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_dept_edit"
                                        name="menu_dept[]" value="edit">
                                    <label class="form-check-label" for="menu_dept_edit">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_dept_delete"
                                        name="menu_dept[]" value="delete">
                                    <label class="form-check-label" for="menu_dept_delete">Delete</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6><label class="d-block">Menu Fiscal</label></h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_fiscal_view"
                                        name="menu_fiscal[]" value="view">
                                    <label class="form-check-label" for="menu_fiscal_view">View</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_fiscal_add"
                                        name="menu_fiscal[]" value="add">
                                    <label class="form-check-label" for="menu_fiscal_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_fiscal_edit"
                                        name="menu_fiscal[]" value="edit">
                                    <label class="form-check-label" for="menu_fiscal_edit">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_fiscal_delete"
                                        name="menu_fiscal[]" value="delete">
                                    <label class="form-check-label" for="menu_fiscal_delete">Delete</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6><label class="d-block">Menu Plan Expenses</label></h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_plan_view"
                                        name="menu_plan[]" value="view">
                                    <label class="form-check-label" for="menu_plan_view">View</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_plan_add"
                                        name="menu_plan[]" value="add">
                                    <label class="form-check-label" for="menu_plan_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_plan_edit"
                                        name="menu_plan[]" value="edit">
                                    <label class="form-check-label" for="menu_plan_edit">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_plan_delete"
                                        name="menu_plan[]" value="delete">
                                    <label class="form-check-label" for="menu_plan_delete">Delete</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6><label class="d-block">Menu Forecast Expenses</label></h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_forecast_view"
                                        name="menu_forecast[]" value="view">
                                    <label class="form-check-label" for="menu_forecast_view">View</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_forecast_add"
                                        name="menu_forecast[]" value="add">
                                    <label class="form-check-label" for="menu_forecast_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_forecast_edit"
                                        name="menu_forecast[]" value="edit">
                                    <label class="form-check-label" for="menu_forecast_edit">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_forecast_delete"
                                        name="menu_forecast[]" value="delete">
                                    <label class="form-check-label" for="menu_forecast_delete">Delete</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6><label class="d-block">Menu Actual Expenses</label></h6>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_actual_view"
                                        name="menu_actual[]" value="view">
                                    <label class="form-check-label" for="menu_actual_view">View</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_actual_add"
                                        name="menu_actual[]" value="add">
                                    <label class="form-check-label" for="menu_actual_add">Add</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_actual_edit"
                                        name="menu_actual[]" value="edit">
                                    <label class="form-check-label" for="menu_actual_edit">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="menu_actual_delete"
                                        name="menu_actual[]" value="delete">
                                    <label class="form-check-label" for="menu_actual_delete">Delete</label>
                                </div>
                            </div>
                        </div>
                        <div class="row-body">
                            <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" id="rolemanagement">Save changes</button>
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
            select: true,
            responsive: true,
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
        var table = $('#datatable').DataTable();
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
                        var errorMessage = '';

                        // Memastikan bahwa response.status adalah objek dan memiliki pesan error
                        if (response.status && typeof response.status === 'object') {
                            // Loop untuk setiap field dan pesan errornya
                            for (var field in response.status) {
                                if (response.status.hasOwnProperty(field)) {
                                    response.status[field].forEach(function(message) {
                                        // Menambahkan pesan error untuk field tertentu
                                        errorMessage += message +
                                        '\n'; // Gabungkan pesan dengan enter
                                    });
                                }
                            }
                        } else {
                            errorMessage = "An unexpected error occurred.";
                        }

                        // Menampilkan pesan error di SweetAlert
                        Swal.fire({
                            title: 'Error',
                            icon: 'error',
                            text: errorMessage
                        .trim(), // Menghapus spasi ekstra sebelum menampilkan
                        });
                    }
                }
            })
        })
        $('#modalupdateuser').on('click', function(e) {
            e.preventDefault();
            var selectedData = table.rows({
                selected: true
            }).data();
            var username = $('#uusername');
            var name = $('#uname');
            var dept = $('#udepartement');
            var email = $('#uemail');
            var password = $('#upassword');
            var level = $('#ulevel');
            var role_id = $('#urole_id');
            if (selectedData.length > 0) {
                username.val(selectedData[0].username);
                name.val(selectedData[0].name);
                dept.val(selectedData[0].dept);
                email.val(selectedData[0].email);
                password.val(selectedData[0].password);
                level.val(selectedData[0].level);
                role_id.val(selectedData[0].role_id);
                $('#exampleModalEdit').modal('show');
            } else {
                $('#exampleModalEdit').modal('hide');
                Swal.fire({
                    title: 'info',
                    icon: 'info',
                    text: 'No data selected',
                });
            }
        });
        $('#updateuser').on('click', function(e) {
            e.preventDefault();
            var selectedData = table.rows({
                selected: true
            }).data();
            if (selectedData.length == 0) {
                Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: 'Tidak ada data yang dipilih!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                });
                return;
            }
            var row = selectedData[0];
            var uID = row.uuid;
            var updateUser = "<?= base_url() . '/uuser/' ?>" + uID;
            var formID = '#formupdateuser';
            $('#modalwarning').modal('hide');
            if (selectedData.length > 0) {
                Swal.fire({
                    title: 'Update',
                    icon: 'warning',
                    text: 'Yakin data ingin diubah?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Ubah!!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formUpUser = new FormData($(formID)[0]);
                        $.ajax({
                            type: 'POST',
                            url: updateUser,
                            data: formUpUser,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.status == 200) {
                                    Swal.fire({
                                        title: 'success',
                                        icon: 'success',
                                        text: 'Data berhasil diupdate',
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true,
                                    })
                                    table.ajax.reload(null, false);
                                    $('#formupdateuser')[0].reset();
                                } else {
                                    Swal.fire({
                                        title: 'error',
                                        icon: 'error',
                                        text: 'Data gagal diupdate',
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true,
                                    })
                                }
                            }
                        })
                    }
                })
            }
        })
        $('#modalrolemanagement').on('click', function(e) {
            e.preventDefault();
            var selectedData = table.rows({
                selected: true
            }).data();
            var username = $('#roleuser');
            if (selectedData.length > 0) {
                username.val(selectedData[0].username);
                $('#exampleModalRole').modal('show');
            } else {
                $('#exampleModalRole').modal('hide');
                Swal.fire({
                    title: 'info',
                    icon: 'info',
                    text: 'No data selected',
                });
            }
        });
        $('#rolemanagement').on('click', function(e) {
            e.preventDefault();
            var selectedData = table.rows({
                selected: true
            }).data();
            if (selectedData.length == 0) {
                Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: 'Tidak ada data yang dipilih!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                });
                return;
            }
            var row = selectedData[0];
            var uID = row.uuid;
            var urlRole = "<?= base_url() . '/role-management/' ?>" + uID;
            var formID = '#formrolemanagement';
            $('#modalwarning').modal('hide');
            if (selectedData.length > 0) {
                Swal.fire({
                    title: 'Add Role',
                    icon: 'warning',
                    text: 'Yakin data sudah benar?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Tambah!!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formRole = new FormData($(formID)[0]);
                        $.ajax({
                            type: 'POST',
                            url: urlRole,
                            data: formRole,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.status == 200) {
                                    Swal.fire({
                                        title: 'success',
                                        icon: 'success',
                                        text: 'Role berhasil ditambah',
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true,
                                    })
                                    table.ajax.reload(null, false);
                                    $('#formupdateuser')[0].reset();
                                } else {
                                    Swal.fire({
                                        title: 'error',
                                        icon: 'error',
                                        text: 'Role gagal ditambah',
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true,
                                    })
                                }
                            }
                        })
                    }
                })
            }
        })
        $('#deleteuser').on('click', function(e) {
            e.preventDefault();
            var selectedData = table.rows({
                selected: true
            }).data();
            if (selectedData.length > 0) {
                Swal.fire({
                    title: 'Delete',
                    icon: 'warning',
                    text: 'Yakin ingin dihapus?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        selectedData.each(function(data) {
                            const uuid = data.uuid;
                            $.ajax({
                                type: 'DELETE',
                                url: "<?= base_url() . '/user/' ?>" + uuid,
                                success: function(response) {
                                    if (response.status == 200) {
                                        Swal.fire({
                                            title: 'Success',
                                            icon: 'success',
                                            text: 'Data Berhasil dihapus',
                                            timer: 1500,
                                            timerProgressBar: true,
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Error',
                                            icon: 'error',
                                            text: 'Data Error',
                                            timer: 1500,
                                            timerProgressBar: true,
                                        });
                                    }
                                }
                            })
                        })
                    }
                })

            }
        })
    }

    // Panggil initDataTable saat halaman Products dimuat
    $(document).ready(function() {
        initDataTable();
        crudUser();
    });
</script>
