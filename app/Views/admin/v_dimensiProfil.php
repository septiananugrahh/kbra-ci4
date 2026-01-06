<style>
  #progressContainer {
    width: 100%;
    background: #ddd;
    margin-top: 10px;
  }

  #progressBar {
    width: 0%;
    height: 20px;
    background: green;
    text-align: center;
    color: white;
  }
</style>

<div class="row">
  <div class="col-xxl-12 mb-6 order-0">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-sm-12">
          <div class="card-body">

            <div class="d-flex justify-content-end">
              <button type="button" id="btn-tambah-dimensiprofil" class="btn btn-success mb-10">
                <i class="ri-add-line"></i> &nbsp;Tambah Data
              </button>
            </div>

            <div class="d-flex align-items-start row">
              <div class="table-responsive">
                <table id="table-dimensiprofil" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Dimensi Profil</th>
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
<div class="modal fade" id="Delmodaldimensiprofil" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-hapus-dimensiprofil">Hapus Dimensi Profil Lulusan</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="deldimensiprofil">

          <div class="form-group">
            <input type="hidden" id="delID" name="delIddimensiprofil" readonly>

            <h2>
              <div id="delNama"></div>
            </h2>
          </div>

          <div class="d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-danger"
              id="btn-hapus-dimensiprofil">Iya !</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </form>


      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modaldimensiprofil" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="dataForm-dimensiprofil" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-dimensiprofil">Modal title</h5>
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
            <label for="nama" class="form-label">Nama Dimensi Profil Lulusan</label>
            <input type="text" id="nama" name="nama" class="form-control" />
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary" id="btn-simpan-dimensiprofil">Simpan</button>
        <!-- <button type="button" class="btn btn-primary">Save</button> -->
      </div>

      <div id="progressContainer">
        <div id="progressBar">0%</div>
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

    const modal_dimensiprofil = $('#modaldimensiprofil');
    const del_modal_dimensiprofil = $('#Delmodaldimensiprofil');
    const form_dimensiprofil = $('#dataForm-dimensiprofil');
    const delButton_dimensiprofil = $('#btn-hapus-dimensiprofil');
    const submitButton_dimensiprofil = $('#btn-simpan-dimensiprofil');

    function resetModaldimensiprofil() {
      form_dimensiprofil[0].reset();
    }

    const validasidimensiprofil = new JustValidate('#dataForm-dimensiprofil');

    validasidimensiprofil.addField('#nama', [{
      rule: 'required',
      errorMessage: 'Tanggal wajib diisi!',
    }]);

    validasidimensiprofil.onValidate(() => {
      // Form valid jika semua validasi terpenuhi
      isValidasiDatadimensiprofil = true;
    }).onFail(() => {
      // Form tidak valid jika ada validasi yang gagal
      isValidasiDatadimensiprofil = false;
    });

    const baseUrl = "<?= site_url() ?>";

    var ajaxUrl = "<?= site_url('dimensiprofil/ambil_data'); ?>";

    var dataTable_dimensiprofil = $('#table-dimensiprofil').DataTable({
      processing: true,
      serverSide: false,
      responsive: true,
      scrollX: true,
      ajax: {
        url: ajaxUrl, // URL API server
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
          data: null,
          className: "all",
          render: function(data, type, row) {
            const escapeAttr = str => (str || "").toString().replace(/'/g, "&#039;");


            const editBtn = `
            <button class="btn btn-sm btn-info editBtn"
              data-id="${escapeAttr(row.id)}"
              data-nama="${escapeAttr(row.nama)}"
            >Edit</button>`;

            const delBtn = `
            <button class="btn btn-sm btn-danger delBtn"
              data-id="${escapeAttr(row.id)}"
              data-nama="${escapeAttr(row.nama)}"
            >Delete</button>`;

            return editBtn + ' ' + delBtn;
          }
        }


      ]
    });

    $('#table-dimensiprofil').on('click', '.editBtn', function() {
      resetModaldimensiprofil();

      $('#id').val($(this).data('id'));
      $('#nama').val($(this).data('nama'));
      $('#urut').val($(this).data('urut'));

      $('#modalTitle-dimensiprofil').text('Ubah Data Capaian Pembelajaran');
      $('#btn-simpan-dimensiprofil').text('Perbarui');
      $('#btn-simpan-dimensiprofil').data('action', 'edit');

      modal_dimensiprofil.modal('show');
    });


    $('#table-dimensiprofil').on('click', '.delBtn', function() {
      var id = $(this).data('id');
      var nama = $(this).data('nama');

      $('#delID').val(id);

      document.getElementById("delNama").innerText = nama;
      // Show the modal
      del_modal_dimensiprofil.modal('show');
    });


    $('#btn-tambah-dimensiprofil').on('click', function() {
      resetModaldimensiprofil();
      $('#modalTitle-dimensiprofil').text('Tambah Dimensi Profil Lulusan'); // Judul Modal
      submitButton_dimensiprofil.text('Tambah Dimensi Profil Lulusan'); // Tombol Save
      submitButton_dimensiprofil.data('action', 'add'); // Tandai sebagai Add

      modal_dimensiprofil.modal('show');
    });

    $(document).on('click', '#btn-hapus-dimensiprofil', function() { // Ketika tombol simpan di klik
      //alert('aaa')
      var originalText = delButton_dimensiprofil.text(); // Simpan teks asli tombol
      // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
      delButton_dimensiprofil.prop('disabled', true).text('Deleting...');
      $.ajax({
        url: "<?= site_url('dimensiprofil/hapusdata_soft'); ?>", // URL tujuan
        type: 'POST', // Tentukan type nya POST atau GET
        data: $("#deldimensiprofil").serialize(), // Ambil semua data yang ada didalam tag form
        dataType: 'json',
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType('application/jsoncharset=UTF-8')
          }
        },
        success: function(response) { // Ketika proses pengiriman berhasil

          if (response.status == 'sukses') {
            dataTable_dimensiprofil.ajax.reload(null, false);
            del_modal_dimensiprofil.modal('hide') // Close / Tutup Modal Dialog
          } else {
            $('#pesan-error').html(response.pesan).show()
          }
        },
        error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
          alert(xhr.responseText) // munculkan alert
        },
        complete: function() {
          // Aktifkan kembali tombol dan kembalikan teks aslinya
          delButton_dimensiprofil.prop('disabled', false).text(originalText);
        }
      })
    })

    form_dimensiprofil.on('submit', function(e) {
      e.preventDefault();

      if (isValidasiDatadimensiprofil) {
        var originalText = submitButton_dimensiprofil.text(); // Simpan teks asli tombol
        // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
        submitButton_dimensiprofil.prop('disabled', true).text('Saving...');
        var formData = new FormData(this);

        const action = submitButton_dimensiprofil.data('action');
        const url = action === 'add' ?
          "<?php echo site_url('dimensiprofil/simpandata'); ?>" :
          "<?php echo site_url('dimensiprofil/ubahdata'); ?>";

        $.ajax({
          url: url,
          type: "POST",
          data: formData,
          processData: false, // Jangan proses data sebagai string query
          contentType: false,
          success: function(res) {
            console.log("Success response:", res);
            Swal.fire('Peringatan', res.message, 'success');
            // alert(`Data berhasil ${action === 'add' ? 'ditambahkan' : 'diperbarui'}!`);
            modal_dimensiprofil.modal('hide');
            dataTable_dimensiprofil.ajax.reload();
          },
          error: function(xhr) {
            console.error("Error:", xhr.responseText); // tambahkan ini
            Swal.fire('Peringatan', 'Gagal Menyimpan Data.', 'warning');

          },
          complete: function() {
            // Aktifkan kembali tombol dan kembalikan teks aslinya
            submitButton_dimensiprofil.prop('disabled', false).text(originalText);
          }
        });
      }
    });

  });
</script>