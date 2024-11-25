<section class="section">
    <div class="section-header">
        <h1>Category</h1>
    </div>

    <div class="section-body">
        <b>Category Expenses</b>
    </div>
    <div class="card-body">
        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add +</button>
    </div>
    <div class="card-body">
        <table id="datatable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code Category</th>
                    <th>Category</th>
                    <th>Group</th>
                    <th>Sub</th>
                    <th>Validity</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Code Category</th>
                    <th>Category</th>
                    <th>Group</th>
                    <th>Sub</th>
                    <th>Validity</th>
                </tr>
            </tfoot>
        </table>
    </div>
</section>
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog modal-lg" role="document">
    <form action="" method="POST" id="formaddcategory" enctype="multipart/form-data">
        <?= csrf()?>
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
<script>
    // Fungsi inisialisasi DataTables khusus untuk halaman ini
  function initDataTable() {
    if ($.fn.dataTable.isDataTable('#datatable')) {
    $('#datatable').DataTable().clear().destroy(); // Hancurkan DataTable yang sudah ada
  }
    $('#datatable').DataTable({
      ajax: '<?= base_url()?>/getcategory',
      processing: true,
      serverSide: true,
      columns: [
        { data: 'uuid', name: 'uuid', render:function(data,type,row,meta){
            return meta.row+meta.settings._iDisplayStart+1;
        } },
        { data: 'code_category', name: 'code_category' },
        { data: 'category', name: 'category' },
        { data: 'group_category', name: 'group_category' },
        { data: 'sub', name: 'sub' },
        { data: 'validity', name: 'validity', render:function(data,type,row){
            return row.validity == 1 ? 'active' : 'inactive';
        } },
      ]
    });
  }

  function crudCategory(){
    $('#addcategory').on('click', function(e){
        e.preventDefault();
        var url = '<?= base_url().'/category'?>';
        var formData = new FormData($('#formaddcategory')[0]);
        $.ajax({
            type:'POST',
            url: url,
            processData: false,
            contentType:false,
            data:formData,
            dataType: 'json',
            success:function(response){
                if(response.status == 200){
                    Swal.fire({
                        title: 'Success',
                        icon: 'success',
                        text: 'Category Added',
                    });
                    initDataTable().DataTable.ajax.reload();
                    $('#formaddcategory')[0].reset();
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
  $(document).ready(function(){
    initDataTable();
    crudCategory();
  });
</script>