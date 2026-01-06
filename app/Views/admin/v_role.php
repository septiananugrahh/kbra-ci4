<div class="row">


  <div class="col-xxl-12 mb-6 order-0">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-sm-12">
          <div class="card-body">

            <div class="d-flex justify-content-end">
              <button type="button" id="btn-tambah-role" class="btn btn-success mb-10">
                <i class="ri-add-line"></i> &nbsp;Tambah Data
              </button>
            </div>

            <div class="d-flex align-items-start row">
              <div class="table-responsive">
                <table id="table-role" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama Jabatan</th>
                      <th>Ket</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Delmodalrole" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-pegawai">Hapus Pegawai</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="delRole">

          <div class="form-group">
            <input type="hidden" id="delID" name="delIdRole" readonly>
            <h2>
              <div id="delNama"></div>
            </h2>
          </div>

          <div class="d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-danger"
              id="btn-hapus-role">Iya !</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </form>


      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalRole" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="dataForm-role">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-role">Modal title</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <input
          type="hidden"
          id="id"
          name="id"
          class="form-control"
          placeholder="Masukan id" />

        <div class="row">
          <div class="col mb-6">
            <label for="nama" class="form-label">Nama</label>
            <input
              type="text"
              id="nama"
              name="nama"
              class="form-control"
              placeholder="Masukan Nama" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="ket" class="form-label">Keterangan</label>
            <input
              type="text"
              id="ket"
              name="ket"
              class="form-control"
              placeholder="Masukan Keterangan" />
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary" id="btn-simpan-role">Tombol</button>
          <!-- <button type="button" class="btn btn-primary">Save</button> -->
        </div>
    </form>
  </div>
</div>



<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/just-validate@4.2.0/dist/just-validate.production.min.js"></script>
<script type="text/javascript" language="javascript">
  $(document).ready(function() {

    const modal_role = $('#modalRole');
    const del_modal_role = $('#Delmodalrole');
    const form_role = $('#dataForm-role');
    const submitButton_role = $('#btn-simpan-role');
    const delButton_role = $('#btn-hapus-role');

    function resetModalRole() {
      form_role[0].reset();
    }

    const validasiPegawai = new JustValidate('#dataForm-role');

    validasiPegawai.addField('#nama', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]);



    validasiPegawai.onValidate(() => {
      // Form valid jika semua validasi terpenuhi
      isValidDataPegawai = true;
    }).onFail(() => {
      // Form tidak valid jika ada validasi yang gagal
      isValidDataPegawai = false;
    });

    var dataTable_role = $('#table-role').DataTable({
      processing: true,
      serverSide: false,
      scrollX: true,
      responsive: true,
      ajax: {
        url: "<?= site_url('role/ambil_data_role'); ?>", // URL API server
        type: "POST",
      },
      columns: [

        {
          data: "id",
          className: "none",
          visible: false
        },
        {
          data: "nama",
          className: "all"
        },
        {
          data: "ket",
          className: "all"
        },
        {
          data: null,
          className: "all",
          render: function(data, type, row) {
            return `<button class="btn btn-sm btn-info editBtn"
            data-id="${row.id}"
            data-nama="${row.nama}"
            data-ket="${row.ket}"
            ><i class="ri-pencil-line"></i></button>

            <button class="btn btn-sm btn-danger delBtn" 
            data-id="${row.id}"
            data-nama="${row.nama}"
            ><i class="ri-delete-bin-2-line"></i></button>`;
          }
        }
      ]
    });

    $('#table-role').on('click', '.delBtn', function() {
      var id = $(this).data('id');
      var nama = $(this).data('nama');

      $('#delID').val(id);

      document.getElementById("delNama").innerText = nama;
      // Show the modal
      del_modal_role.modal('show');
    });

    $('#table-role').on('click', '.editBtn', function() {
      resetModalRole();
      // Ambil data dari atribut data-*
      const id = $(this).data('id');
      const nama = $(this).data('nama');
      const ket = $(this).data('ket');

      // alert(nama)

      $('#id').val(id);
      $('#nama').val(nama);
      $('#ket').val(ket);


      $('#modalTitle-role').text('Ubah Data Hak Akses'); // Judul Modal

      submitButton_role.text('Perbarui');
      submitButton_role.data('action', 'edit');

      // Tampilkan modal
      modal_role.modal('show');
    });

    $('#btn-tambah-role').on('click', function() {
      resetModalRole();
      $('#modalTitle-role').text('Tambah Data Hak Akses'); // Judul Modal
      submitButton_role.text('Tambah Hak Akses'); // Tombol Save
      submitButton_role.data('action', 'add'); // Tandai sebagai Add

      modal_role.modal('show');
    });

    $(document).on('click', '#btn-hapus-role', function() { // Ketika tombol simpan di klik
      //alert('aaa')
      var originalText = delButton_role.text(); // Simpan teks asli tombol
      // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
      delButton_role.prop('disabled', true).text('Deleting...');
      $.ajax({
        url: "<?= site_url('role/hapusdata_soft'); ?>", // URL tujuan
        type: 'POST', // Tentukan type nya POST atau GET
        data: $("#delRole").serialize(), // Ambil semua data yang ada didalam tag form
        dataType: 'json',
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType('application/jsoncharset=UTF-8')
          }
        },
        success: function(response) { // Ketika proses pengiriman berhasil
          $('#loading-simpan').hide() // Sembunyikan loading simpan

          if (response.status == 'sukses') {
            dataTable_role.ajax.reload(null, false);
            del_modal_role.modal('hide') // Close / Tutup Modal Dialog
          } else {
            $('#pesan-error').html(response.pesan).show()
          }
        },
        error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
          alert(xhr.responseText) // munculkan alert
        },
        complete: function() {
          // Aktifkan kembali tombol dan kembalikan teks aslinya
          delButton_role.prop('disabled', false).text(originalText);
        }
      })
    })

    form_role.on('submit', function(e) {
      e.preventDefault();

      if (isValidDataPegawai) {
        var originalText = submitButton_role.text(); // Simpan teks asli tombol
        // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
        submitButton_role.prop('disabled', true).text('Saving...');
        var formData = new FormData(this);

        const action = submitButton_role.data('action');
        const url = action === 'add' ?
          "<?php echo site_url('role/simpandata'); ?>" :
          "<?php echo site_url('role/ubahdata'); ?>";

        $.ajax({
          url: url,
          type: "POST",
          data: formData,
          processData: false, // Jangan proses data sebagai string query
          contentType: false,
          success: function(res) {
            console.log("Success response:", res);
            // alert(res.message);
            // alert(`Data berhasil ${action === 'add' ? 'ditambahkan' : 'diperbarui'}!`);
            modal_role.modal('hide');
            dataTable_role.ajax.reload();
          },
          error: function(xhr) {
            console.error("Error:", xhr.responseText); // tambahkan ini
            alert('Gagal menyimpan data!');
          },
          complete: function() {
            // Aktifkan kembali tombol dan kembalikan teks aslinya
            submitButton_role.prop('disabled', false).text(originalText);
          }
        });
      }
    });
  });
</script>