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
              <button type="button" id="btn-tambah-capaianpembelajaran" class="btn btn-success mb-10">
                <i class="ri-add-line"></i> &nbsp;Tambah Data
              </button>
            </div>

            <div class="d-flex align-items-start row">
              <div class="table-responsive">
                <table id="table-capaianpembelajaran" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Capaian</th>
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
<div class="modal fade" id="Delmodalcapaianpembelajaran" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-hapus-capaianpembelajaran">Hapus Capaian Pembelajaran</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="delcapaianpembelajaran">

          <div class="form-group">
            <input type="hidden" id="delID" name="delIdcapaianpembelajaran" readonly>

            <h2>
              <div id="delNama"></div>
            </h2>
          </div>

          <div class="d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-danger"
              id="btn-hapus-capaianpembelajaran">Iya !</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </form>


      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalcapaianpembelajaran" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="dataForm-capaianpembelajaran" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-capaianpembelajaran">Modal title</h5>
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
            <label for="nama" class="form-label">Nama Capaian Pembelajaran</label>
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
        <button type="submit" class="btn btn-primary" id="btn-simpan-capaianpembelajaran">Simpan</button>
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

    const modal_capaianpembelajaran = $('#modalcapaianpembelajaran');
    const del_modal_capaianpembelajaran = $('#Delmodalcapaianpembelajaran');
    const form_capaianpembelajaran = $('#dataForm-capaianpembelajaran');
    const delButton_capaianpembelajaran = $('#btn-hapus-capaianpembelajaran');
    const submitButton_capaianpembelajaran = $('#btn-simpan-capaianpembelajaran');

    $('#foto_capaianpembelajaran').on('change', function(event) {
      const input = event.target;
      const reader = new FileReader();

      reader.onload = function(e) {
        $('#imagePreview').attr('src', e.target.result).show();
      };

      if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
      }
    });

    function resetModalcapaianpembelajaran() {
      form_capaianpembelajaran[0].reset();
    }

    const validasicapaianpembelajaran = new JustValidate('#dataForm-capaianpembelajaran');

    validasicapaianpembelajaran.addField('#nama', [{
      rule: 'required',
      errorMessage: 'Tanggal wajib diisi!',
    }]);

    validasicapaianpembelajaran.onValidate(() => {
      // Form valid jika semua validasi terpenuhi
      isValidasiDatacapaianpembelajaran = true;
    }).onFail(() => {
      // Form tidak valid jika ada validasi yang gagal
      isValidasiDatacapaianpembelajaran = false;
    });

    const baseUrl = "<?= site_url() ?>";

    var ajaxUrl = "<?= site_url('tujuanpembelajaran/ambil_data_capaianpembelajaran'); ?>";

    var dataTable_capaianpembelajaran = $('#table-capaianpembelajaran').DataTable({
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

            const tpBtn = `
            <a href="${baseUrl}/tujuanpembelajaran/tp/${row.id}" 
              class="btn btn-sm btn-primary">
              Lihat TP
            </a>`;

            const delBtn = `
            <button class="btn btn-sm btn-danger delBtn"
              data-id="${escapeAttr(row.id)}"
              data-nama="${escapeAttr(row.nama)}"
            >Delete</button>`;

            return editBtn + ' ' + tpBtn + ' ' + delBtn;
          }
        }


      ]
    });

    $('#table-capaianpembelajaran').on('click', '.editBtn', function() {
      resetModalcapaianpembelajaran();

      $('#id').val($(this).data('id'));
      $('#nama').val($(this).data('nama'));
      $('#urut').val($(this).data('urut'));

      $('#modalTitle-capaianpembelajaran').text('Ubah Data Capaian Pembelajaran');
      $('#btn-simpan-capaianpembelajaran').text('Perbarui');
      $('#btn-simpan-capaianpembelajaran').data('action', 'edit');

      modal_capaianpembelajaran.modal('show');
    });


    $('#table-capaianpembelajaran').on('click', '.delBtn', function() {
      var id = $(this).data('id');
      var nama = $(this).data('nama');

      $('#delID').val(id);

      document.getElementById("delNama").innerText = nama;
      // Show the modal
      del_modal_capaianpembelajaran.modal('show');
    });


    $('#btn-tambah-capaianpembelajaran').on('click', function() {
      resetModalcapaianpembelajaran();
      $('#modalTitle-capaianpembelajaran').text('Tambah Capaian Pembelajaran'); // Judul Modal
      submitButton_capaianpembelajaran.text('Tambah Capaian Pembelajaran'); // Tombol Save
      submitButton_capaianpembelajaran.data('action', 'add'); // Tandai sebagai Add

      modal_capaianpembelajaran.modal('show');
    });

    $(document).on('click', '#btn-hapus-capaianpembelajaran', function() { // Ketika tombol simpan di klik
      //alert('aaa')
      var originalText = delButton_capaianpembelajaran.text(); // Simpan teks asli tombol
      // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
      delButton_capaianpembelajaran.prop('disabled', true).text('Deleting...');
      $.ajax({
        url: "<?= site_url('tujuanpembelajaran/hapusdata_soft'); ?>", // URL tujuan
        type: 'POST', // Tentukan type nya POST atau GET
        data: $("#delcapaianpembelajaran").serialize(), // Ambil semua data yang ada didalam tag form
        dataType: 'json',
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType('application/jsoncharset=UTF-8')
          }
        },
        success: function(response) { // Ketika proses pengiriman berhasil

          if (response.status == 'sukses') {
            dataTable_capaianpembelajaran.ajax.reload(null, false);
            del_modal_capaianpembelajaran.modal('hide') // Close / Tutup Modal Dialog
          } else {
            $('#pesan-error').html(response.pesan).show()
          }
        },
        error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
          alert(xhr.responseText) // munculkan alert
        },
        complete: function() {
          // Aktifkan kembali tombol dan kembalikan teks aslinya
          delButton_capaianpembelajaran.prop('disabled', false).text(originalText);
        }
      })
    })

    form_capaianpembelajaran.on('submit', function(e) {
      e.preventDefault();

      if (isValidasiDatacapaianpembelajaran) {
        var originalText = submitButton_capaianpembelajaran.text(); // Simpan teks asli tombol
        // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
        submitButton_capaianpembelajaran.prop('disabled', true).text('Saving...');
        var formData = new FormData(this);

        const action = submitButton_capaianpembelajaran.data('action');
        const url = action === 'add' ?
          "<?php echo site_url('tujuanpembelajaran/simpandata'); ?>" :
          "<?php echo site_url('tujuanpembelajaran/ubahdata'); ?>";

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
            modal_capaianpembelajaran.modal('hide');
            dataTable_capaianpembelajaran.ajax.reload();
          },
          error: function(xhr) {
            console.error("Error:", xhr.responseText); // tambahkan ini
            Swal.fire('Peringatan', 'Gagal Menyimpan Data.', 'warning');

          },
          complete: function() {
            // Aktifkan kembali tombol dan kembalikan teks aslinya
            submitButton_capaianpembelajaran.prop('disabled', false).text(originalText);
          }
        });
      }
    });

  });
</script>