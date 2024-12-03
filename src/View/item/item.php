<section class="section">
    <div class="section-header">
        <h1>Item</h1>
    </div>

    <div class="section-body">
        <b>Item Expenses</b>
    </div>
    <?php $user = \Support\Session::user(); ?>
    <div class="card-body">
        <?php foreach($user->menus as $menu): ?>
        <?= $menu->menu_id == 4 && $menu->can_create == 1 ? '<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add +</button> <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalImport">Import +</button>' : '' ?>
        <?= $menu->menu_id == 4 && $menu->can_update == 1 ? '<button class="btn btn-warning" data-toggle="modal" data-target="" id="modalupdateitem">Edit +</button>' : '' ?>
        <?= $menu->menu_id == 4 && $menu->can_delete == 1 ? '<button class="btn btn-danger" type="submit" id="deleteitem">Delete +</button>' : '' ?>
        <?php endforeach; ?>
    </div>
    <div class="card-body">
        <table id="datatable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item Name</th>
                    <th>Group</th>
                    <th>Harga</th>
                    <th>Code Category</th>
                    <th>Unit</th>
                    <th>Validity</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Item Name</th>
                    <th>Group</th>
                    <th>Harga</th>
                    <th>Code Category</th>
                    <th>Unit</th>
                    <th>Validity</th>
                </tr>
            </tfoot>
        </table>
    </div>
</section>
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="POST" id="formadditem" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <?= csrf() ?>
                            <label>Item Name</label>
                            <input type="text" name="item_name" id="item_name" class="form-control">
                            <label>Group Item</label>
                            <input type="text" name="group_item" id="group_item" class="form-control">
                            <label>Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control">
                            <label>Code Category</label>
                            <input list="datalist" name="code_category" id="code_category" class="form-control">
                            <datalist id="datalist">
                                <option value="" disabled selected hidden> Select </option>
                                <?php foreach($code as $data):?>
                                    <option value="<?= $data->code_category?>"><?= $data->code_category?></option>
                                <?php endforeach; ?>
                            </datalist>
                            <label>Unit</label>
                            <select name="unit" id="unit" class="form-control">
                                <option value="" disabled selected hidden> Select </option>
                                <?php foreach($unit as $data):?>
                                    <option value="<?= $data->unit?>"><?= $data->unit?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row-body">
                            <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="additem">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModalImport">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="POST" id="formimportitem" enctype="multipart/form-data">
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
                            <label>Masukkan File Import Item</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                        <div class="row-body">
                            <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="importitem">Save changes</button>
                    <button type="button" class="btn btn-disabled btn-primary btn-progress" id="loading" style="display:none">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModalEdit">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="POST" id="formupdateitem" enctype="multipart/form-data">
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
                            <label>Item Name</label>
                            <input type="text" name="item_name" id="uitem_name" class="form-control">
                            <label>Group Item</label>
                            <input type="text" name="group_item" id="ugroup_item" class="form-control">
                            <label>Harga</label>
                            <input type="number" name="harga" id="uharga" class="form-control">
                            <label>Code Category</label>
                            <input list="datalist" name="code_category" id="ucode_category" class="form-control">
                            <datalist id="datalist">
                                <!-- <option value="" id=""> </option> -->
                                <?php foreach($code as $data):?>
                                    <option value="<?= $data->code_category?>"><?= $data->code_category?></option>
                                <?php endforeach; ?>
                            </datalist>
                            <label>Unit</label>
                            <select name="unit" id="uunit" class="form-control">
                                <!-- <option value="" disabled selected hidden> Select </option> -->
                                <?php foreach($unit as $data):?>
                                    <option value="<?= $data->unit?>"><?= $data->unit?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row-body">
                            <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" id="updateitem">Save changes</button>
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
            ajax: '<?= base_url() ?>/getitem',
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
                    data: 'item_name',
                    name: 'item_name'
                },
                {
                    data: 'group_item',
                    name: 'group_item'
                },
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'code_category',
                    name: 'code_category'
                },
                {
                    data: 'unit',
                    name: 'unit'
                },
                {
                    data: 'validity',
                    name: 'validity',
                    render: function(data, type, row) {
                        return row.validity == 1 ? '<span class="badge badge-success">active</span>' : '<span class="badge badge-danger">inactive</span>';
                    }
                },
            ]
        });
    }

    function crudItem() {
        var table = $('#datatable').DataTable();
        $('#additem').on('click', function(e) {
            e.preventDefault();
            var url = '<?= base_url() . '/item' ?>';
            var formData = new FormData($('#formadditem')[0]);
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
                            text: 'Item Added',
                        });
                        $('#formadditem')[0].reset();
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
        $('#importitem').on('click', function(e){
            e.preventDefault();
            var url = '<?= base_url() . '/import-item' ?>';
            var formData = new FormData($('#formimportitem')[0]);
            $('#importitem').hide();
            $('#loading').show();
            if(($('#file').val() === '')){
                Swal.fire({
                    title: 'Warning',
                    icon: 'warning',
                    text: 'File Import is Empty',
                })
                $('#importitem').show();
                $('#loading').hide();
            }
            
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
                            text: 'Item Added',
                        });
                        $('#importitem').show();
                        $('#loading').hide();
                        $('#formimportitem')[0].reset();
                        initDataTable().DataTable.ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            title: 'Error',
                            icon: 'error',
                            text: 'Error import',
                        });
                    }
                }
            })
        })
        $('#modalupdateitem').on('click', function(e) {
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
        $('#updateitem').on('click', function(e) {
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
            var updateItem = "<?= base_url() . '/uitem/' ?>" + uID;
            var formID = '#formupdateitem';
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
                        var formUpItem = new FormData($(formID)[0]);
                        $.ajax({
                            type: 'POST',
                            url: updateItem,
                            data: formUpItem,
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
                                    $('#formupdateitem')[0].reset();
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
        $('#deleteitem').on('click', function(e) {
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
                                url: "<?= base_url() . '/item/' ?>" + uuid,
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
        crudItem();
    });
</script>
