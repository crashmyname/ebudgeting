<section class="section">
    <div class="section-header">
        <h1>Fiscal</h1>
    </div>

    <div class="section-body">
        <b>Fiscal</b>
    </div>
    <?php $user = \Support\Session::user(); ?>
    <div class="card-body">
        <?php foreach($user->menus as $menu): ?>
        <?= $menu->menu_id == 2 && $menu->can_create == 1 ? '<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add +</button>' : '' ?>
        <?= $menu->menu_id == 2 && $menu->can_update == 1 ? '<button class="btn btn-warning" data-toggle="modal" data-target="" id="modalupdatecategory">Edit +</button>' : '' ?>
        <?= $menu->menu_id == 2 && $menu->can_delete == 1 ? '<button class="btn btn-danger" type="submit" id="deletecategory">Delete +</button>' : '' ?>
        <?php endforeach; ?>
    </div>
    <div class="card-body">
        <table id="datatable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Fiscal</th>
                    <th>Descriptopn</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Fiscal</th>
                    <th>Descriptopn</th>
                </tr>
            </tfoot>
        </table>
    </div>
</section>
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="POST" id="formaddcategory" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <?= csrf() ?>
                            <label>Code Category</label>
                            <input type="text" name="code_category" id="code_category" class="form-control">
                            <label>Category</label>
                            <input type="text" name="category" id="category" class="form-control">
                            <label>Group</label>
                            <input type="text" name="group" id="group" class="form-control">
                            <label>Sub</label>
                            <input type="text" name="sub" id="sub" class="form-control">
                            <label>Validity</label>
                            <input type="text" name="validity" id="validity" class="form-control">
                        </div>
                        <div class="row-body">
                            <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="addcategory">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModalEdit">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="POST" id="formupdatecategory" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <?= csrf() ?>
                            <?= method('PUT') ?>
                            <label>Code Category</label>
                            <input type="text" name="code_category" id="ucode_category" class="form-control"
                                readonly>
                            <label>Category</label>
                            <input type="text" name="category" id="ucategory" class="form-control">
                            <label>Group</label>
                            <input type="text" name="group" id="ugroup" class="form-control">
                            <label>Sub</label>
                            <input type="text" name="sub" id="usub" class="form-control">
                            <label>Validity</label>
                            <input type="text" name="validity" id="uvalidity" class="form-control">
                        </div>
                        <div class="row-body">
                            <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" id="updatecategory">Save changes</button>
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
            ajax: '<?= base_url() ?>/getfiscal',
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
                    data: 'fiscal',
                    name: 'fiscal'
                },
                {
                    data: 'description',
                    name: 'description'
                }
            ]
        });
    }

    function crudCategory() {
        var table = $('#datatable').DataTable();
        $('#addcategory').on('click', function(e) {
            e.preventDefault();
            var url = '<?= base_url() . '/category' ?>';
            var formData = new FormData($('#formaddcategory')[0]);
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
                            text: 'Category Added',
                        });
                        $('#formaddcategory')[0].reset();
                        initDataTable().DataTable.ajax.reload(null, false);
                    } else if (response.status == 409) {
                        Swal.fire({
                            title: 'Error. Conflict!!',
                            icon: 'error',
                            text: 'The data already exists in the database.',
                        });
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
        $('#modalupdatecategory').on('click', function(e) {
            e.preventDefault();
            var selectedData = table.rows({
                selected: true
            }).data();
            var code_category = $('#ucode_category');
            var category = $('#ucategory');
            var group = $('#ugroup');
            var sub = $('#usub');
            var validity = $('#uvalidity');
            if (selectedData.length > 0) {
                code_category.val(selectedData[0].code_category);
                category.val(selectedData[0].category);
                group.val(selectedData[0].group_category);
                sub.val(selectedData[0].sub);
                validity.val(selectedData[0].validity);
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
        $('#updatecategory').on('click', function(e) {
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
            var updateCategory = "<?= base_url() . '/ucategory/' ?>" + uID;
            var formID = '#formupdatecategory';
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
                        var formUpCategory = new FormData($(formID)[0]);
                        $.ajax({
                            type: 'POST',
                            url: updateCategory,
                            data: formUpCategory,
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
                                    table.ajax.reload(null,false);
                                    $('#formupdatecategory')[0].reset();
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
        $('#deletecategory').on('click', function(e) {
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
                                url: "<?= base_url() . '/category/' ?>" + uuid,
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
        crudCategory();
    });
</script>
