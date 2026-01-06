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
              <button type="button" id="btn-tambah-kurikulumcinta" class="btn btn-success mb-10">
                <i class="ri-add-line"></i> &nbsp;Tambah Data
              </button>
            </div>

            <div class="d-flex align-items-start row">
              <div class="table-responsive">
                <table id="table-kurikulumcinta" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Kurikulum Berbasis Cinta</th>
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
<div class="modal fade" id="Delmodalkurikulumcinta" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-hapus-kurikulumcinta">Hapus Kurikulum Berbasis Cinta</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="delkurikulumcinta">

          <div class="form-group">
            <input type="hidden" id="delID" name="delIdkurikulumcinta" readonly>

            <h2>
              <div id="delNama"></div>
            </h2>
          </div>

          <div class="d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-danger"
              id="btn-hapus-kurikulumcinta">Iya !</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </form>


      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalkurikulumcinta" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="dataForm-kurikulumcinta" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-kurikulumcinta">Modal title</h5>
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
            <label for="nama" class="form-label">Nama Kurikulum Berbasis Cinta</label>
            <input type="text" id="nama" name="nama" class="form-control" />
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary" id="btn-simpan-kurikulumcinta">Simpan</button>
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

    const modal_kurikulumcinta = $('#modalkurikulumcinta');
    const del_modal_kurikulumcinta = $('#Delmodalkurikulumcinta');
    const form_kurikulumcinta = $('#dataForm-kurikulumcinta');
    const delButton_kurikulumcinta = $('#btn-hapus-kurikulumcinta');
    const submitButton_kurikulumcinta = $('#btn-simpan-kurikulumcinta');

    function resetModalkurikulumcinta() {
      form_kurikulumcinta[0].reset();
    }

    const validasikurikulumcinta = new JustValidate('#dataForm-kurikulumcinta');

    validasikurikulumcinta.addField('#nama', [{
      rule: 'required',
      errorMessage: 'Tanggal wajib diisi!',
    }]);

    validasikurikulumcinta.onValidate(() => {
      // Form valid jika semua validasi terpenuhi
      isValidasiDatakurikulumcinta = true;
    }).onFail(() => {
      // Form tidak valid jika ada validasi yang gagal
      isValidasiDatakurikulumcinta = false;
    });

    const baseUrl = "<?= site_url() ?>";

    var ajaxUrl = "<?= site_url('kurikulumcinta/ambil_data'); ?>";

    var dataTable_kurikulumcinta = $('#table-kurikulumcinta').DataTable({
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

    $('#table-kurikulumcinta').on('click', '.editBtn', function() {
      resetModalkurikulumcinta();

      $('#id').val($(this).data('id'));
      $('#nama').val($(this).data('nama'));
      $('#urut').val($(this).data('urut'));

      $('#modalTitle-kurikulumcinta').text('Ubah Data Capaian Pembelajaran');
      $('#btn-simpan-kurikulumcinta').text('Perbarui');
      $('#btn-simpan-kurikulumcinta').data('action', 'edit');

      modal_kurikulumcinta.modal('show');
    });


    $('#table-kurikulumcinta').on('click', '.delBtn', function() {
      var id = $(this).data('id');
      var nama = $(this).data('nama');

      $('#delID').val(id);

      document.getElementById("delNama").innerText = nama;
      // Show the modal
      del_modal_kurikulumcinta.modal('show');
    });


    $('#btn-tambah-kurikulumcinta').on('click', function() {
      resetModalkurikulumcinta();
      $('#modalTitle-kurikulumcinta').text('Tambah Kurikulum Berbasis Cinta'); // Judul Modal
      submitButton_kurikulumcinta.text('Tambah Kurikulum Berbasis Cinta'); // Tombol Save
      submitButton_kurikulumcinta.data('action', 'add'); // Tandai sebagai Add

      modal_kurikulumcinta.modal('show');
    });

    $(document).on('click', '#btn-hapus-kurikulumcinta', function() { // Ketika tombol simpan di klik
      //alert('aaa')
      var originalText = delButton_kurikulumcinta.text(); // Simpan teks asli tombol
      // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
      delButton_kurikulumcinta.prop('disabled', true).text('Deleting...');
      $.ajax({
        url: "<?= site_url('kurikulumcinta/hapusdata_soft'); ?>", // URL tujuan
        type: 'POST', // Tentukan type nya POST atau GET
        data: $("#delkurikulumcinta").serialize(), // Ambil semua data yang ada didalam tag form
        dataType: 'json',
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType('application/jsoncharset=UTF-8')
          }
        },
        success: function(response) { // Ketika proses pengiriman berhasil

          if (response.status == 'sukses') {
            dataTable_kurikulumcinta.ajax.reload(null, false);
            del_modal_kurikulumcinta.modal('hide') // Close / Tutup Modal Dialog
          } else {
            $('#pesan-error').html(response.pesan).show()
          }
        },
        error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
          alert(xhr.responseText) // munculkan alert
        },
        complete: function() {
          // Aktifkan kembali tombol dan kembalikan teks aslinya
          delButton_kurikulumcinta.prop('disabled', false).text(originalText);
        }
      })
    })

    form_kurikulumcinta.on('submit', function(e) {
      e.preventDefault();

      if (isValidasiDatakurikulumcinta) {
        var originalText = submitButton_kurikulumcinta.text(); // Simpan teks asli tombol
        // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
        submitButton_kurikulumcinta.prop('disabled', true).text('Saving...');
        var formData = new FormData(this);

        const action = submitButton_kurikulumcinta.data('action');
        const url = action === 'add' ?
          "<?php echo site_url('kurikulumcinta/simpandata'); ?>" :
          "<?php echo site_url('kurikulumcinta/ubahdata'); ?>";

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
            modal_kurikulumcinta.modal('hide');
            dataTable_kurikulumcinta.ajax.reload();
          },
          error: function(xhr) {
            console.error("Error:", xhr.responseText); // tambahkan ini
            Swal.fire('Peringatan', 'Gagal Menyimpan Data.', 'warning');

          },
          complete: function() {
            // Aktifkan kembali tombol dan kembalikan teks aslinya
            submitButton_kurikulumcinta.prop('disabled', false).text(originalText);
          }
        });
      }
    });

  });
</script>