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
              <button type="button" id="btn-tambah-tujuanpembelajaran" class="btn btn-success mb-10">
                <i class="ri-add-line"></i> &nbsp;Tambah Data
              </button>
            </div>

            <div class="d-flex align-items-start row">
              <div class="table-responsive">
                <table id="table-tujuanpembelajaran" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Tujuan Pembelajaran</th>
                      <th>No. Urut</th>
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
<div class="modal fade" id="Delmodaltujuanpembelajaran" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-hapus-tujuanpembelajaran">Hapus Tujuan Pembelajaran</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="deltujuanpembelajaran">

          <div class="form-group">
            <input type="hidden" id="delID" name="delIdtujuanpembelajaran" readonly>
            <h2>
              <div id="delNama"></div>
            </h2>
          </div>

          <div class="d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-danger"
              id="btn-hapus-tujuanpembelajaran">Iya !</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </form>


      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modaltujuanpembelajaran" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="dataForm-tujuanpembelajaran" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-tujuanpembelajaran">Modal title</h5>
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

        <input
          type="hidden"
          id="capaian"
          name="capaian"
          value="<?= $cpid; ?>"
          class="form-control"
          placeholder="Masukan id" />


        <div class="row">
          <div class="col mb-6">
            <label for="nama" class="form-label">Nama Tujuan Pembelajaran</label>
            <input type="text" id="nama" name="nama" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="urut" class="form-label">No urut</label>
            <select id="urut" name="urut" class="form-select">
              <?php for ($i = 1; $i <= 17; $i++) { ?>
                <option value="<?= $i; ?>"><?= $i ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary" id="btn-simpan-tujuanpembelajaran">Simpan</button>
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

    const modal_tujuanpembelajaran = $('#modaltujuanpembelajaran');
    const del_modal_tujuanpembelajaran = $('#Delmodaltujuanpembelajaran');
    const form_tujuanpembelajaran = $('#dataForm-tujuanpembelajaran');
    const delButton_tujuanpembelajaran = $('#btn-hapus-tujuanpembelajaran');
    const submitButton_tujuanpembelajaran = $('#btn-simpan-tujuanpembelajaran');

    $('#foto_tujuanpembelajaran').on('change', function(event) {
      const input = event.target;
      const reader = new FileReader();

      reader.onload = function(e) {
        $('#imagePreview').attr('src', e.target.result).show();
      };

      if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
      }
    });

    function resetModaltujuanpembelajaran() {
      form_tujuanpembelajaran[0].reset();
    }

    const validasitujuanpembelajaran = new JustValidate('#dataForm-tujuanpembelajaran');

    validasitujuanpembelajaran.addField('#nama', [{
      rule: 'required',
      errorMessage: 'Tanggal wajib diisi!',
    }]);

    validasitujuanpembelajaran.onValidate(() => {
      // Form valid jika semua validasi terpenuhi
      isValidasiDatatujuanpembelajaran = true;
    }).onFail(() => {
      // Form tidak valid jika ada validasi yang gagal
      isValidasiDatatujuanpembelajaran = false;
    });

    const baseUrl = "<?= site_url() ?>";

    var ajaxUrl = "<?= site_url('tujuanpembelajaran/ambil_data_tujuanpembelajaran') . '/' . $cpid; ?>";

    var dataTable_tujuanpembelajaran = $('#table-tujuanpembelajaran').DataTable({
      processing: true,
      serverSide: false,
      scrollX: true,
      responsive: true,
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
          data: "urut",
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
              data-urut="${escapeAttr(row.urut)}"
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

    $('#table-tujuanpembelajaran').on('click', '.editBtn', function() {
      resetModaltujuanpembelajaran();

      $('#id').val($(this).data('id'));
      $('#nama').val($(this).data('nama'));
      $('#urut').val($(this).data('urut'));

      $('#modalTitle-tujuanpembelajaran').text('Ubah Data Tujuan Pembelajaran');
      $('#btn-simpan-tujuanpembelajaran').text('Perbarui');
      $('#btn-simpan-tujuanpembelajaran').data('action', 'edit');

      modal_tujuanpembelajaran.modal('show');
    });


    $('#table-tujuanpembelajaran').on('click', '.delBtn', function() {
      var id = $(this).data('id');
      var nama = $(this).data('nama');

      $('#delID').val(id);

      document.getElementById("delNama").innerText = nama;
      // Show the modal
      del_modal_tujuanpembelajaran.modal('show');
    });


    $('#btn-tambah-tujuanpembelajaran').on('click', function() {
      resetModaltujuanpembelajaran();
      $('#modalTitle-tujuanpembelajaran').text('Tambah Tujuan Pembelajaran'); // Judul Modal
      submitButton_tujuanpembelajaran.text('Tambah Tujuan Pembelajaran'); // Tombol Save
      submitButton_tujuanpembelajaran.data('action', 'add'); // Tandai sebagai Add

      modal_tujuanpembelajaran.modal('show');
    });

    $(document).on('click', '#btn-hapus-tujuanpembelajaran', function() { // Ketika tombol simpan di klik
      //alert('aaa')
      var originalText = delButton_tujuanpembelajaran.text(); // Simpan teks asli tombol
      // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
      delButton_tujuanpembelajaran.prop('disabled', true).text('Deleting...');
      $.ajax({
        url: "<?= site_url('tujuanpembelajaran/tp/hapusdata_soft'); ?>", // URL tujuan
        type: 'POST', // Tentukan type nya POST atau GET
        data: $("#deltujuanpembelajaran").serialize(), // Ambil semua data yang ada didalam tag form
        dataType: 'json',
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType('application/jsoncharset=UTF-8')
          }
        },
        success: function(response) { // Ketika proses pengiriman berhasil

          if (response.status == 'sukses') {
            dataTable_tujuanpembelajaran.ajax.reload(null, false);
            del_modal_tujuanpembelajaran.modal('hide') // Close / Tutup Modal Dialog
          } else {
            $('#pesan-error').html(response.pesan).show()
          }
        },
        error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
          alert(xhr.responseText) // munculkan alert
        },
        complete: function() {
          // Aktifkan kembali tombol dan kembalikan teks aslinya
          delButton_tujuanpembelajaran.prop('disabled', false).text(originalText);
        }
      })
    })

    form_tujuanpembelajaran.on('submit', function(e) {
      e.preventDefault();

      if (isValidasiDatatujuanpembelajaran) {
        var originalText = submitButton_tujuanpembelajaran.text(); // Simpan teks asli tombol
        // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
        submitButton_tujuanpembelajaran.prop('disabled', true).text('Saving...');
        var formData = new FormData(this);

        const action = submitButton_tujuanpembelajaran.data('action');
        const url = action === 'add' ?
          "<?php echo site_url('tujuanpembelajaran/tp/simpandata'); ?>" :
          "<?php echo site_url('tujuanpembelajaran/tp/ubahdata'); ?>";

        $.ajax({
          url: url,
          type: "POST",
          data: formData,
          processData: false, // Jangan proses data sebagai string query
          contentType: false,
          success: function(res) {
            console.log("Success response:", res);
            Swal.fire({
              icon: 'success',
              title: 'Peringatan',
              text: res.message,
              timer: 1500,
              showConfirmButton: false
            });
            // alert(`Data berhasil ${action === 'add' ? 'ditambahkan' : 'diperbarui'}!`);
            modal_tujuanpembelajaran.modal('hide');
            dataTable_tujuanpembelajaran.ajax.reload();
          },
          error: function(xhr) {
            console.error("Error:", xhr.responseText); // tambahkan ini
            Swal.fire('Peringatan', 'Gagal Menyimpan Data.', 'warning');

          },
          complete: function() {
            // Aktifkan kembali tombol dan kembalikan teks aslinya
            submitButton_tujuanpembelajaran.prop('disabled', false).text(originalText);
          }
        });
      }
    });

  });
</script>