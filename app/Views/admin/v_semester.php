<div class="row">


  <div class="col-xxl-12 mb-6 order-0">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-sm-12">
          <div class="card-body">

            <div class="d-flex justify-content-end">
              <button type="button" id="btn-tambah-semester" class="btn btn-success mb-10">
                <i class="ri-add-line"></i> &nbsp;Tambah Data
              </button>
            </div>

            <div class="d-flex align-items-start row">
              <div class="table-responsive">
                <table id="table-semester" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Semester</th>
                      <th>Tahun</th>
                      <th>Tingkat</th>
                      <th>Kepala</th>
                      <th>Tanggal Rapor</th>
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

<!-- Modal Role -->
<div class="modal fade" id="modalRole" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Kelola Role User: <span id="namaUserRole"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="listRoleUser" class="mb-3"></div>

        <form id="formTambahRole">
          <input type="hidden" name="user_id" id="inputUserIdRole">
          <div class="input-group">
            <select name="level_id" id="selectRole" class="form-select">
              <!-- Option akan diisi dari JS -->
            </select>
            <button type="submit" class="btn btn-primary">Tambah Role</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalSemester" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="dataForm-semester">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-semester">Modal title</h5>
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
          <div class="mb-6">
            <label for="semester" class="form-label">Semester</label>
            <select id="semester" name="semester" class="form-select">
              <option value="GANJIL">Ganjil</option>
              <option value="GENAP">Genap</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="mb-6">
            <label for="tahun" class="form-label">Tahun Ajar</label>
            <select id="tahun" name="tahun" class="form-select">
              <option value="2024/2025">2024/2025</option>
              <option value="2025/2026">2025/2026</option>
              <option value="2026/2027">2026/2027</option>
              <option value="2027/2028">2027/2028</option>
              <option value="2028/2029">2028/2029</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="mb-6">
            <label for="tingkat" class="form-label">Tingkat</label>
            <select id="tingkat" name="tingkat" class="form-select">
              <option value="KB">KB</option>
              <option value="RA">RA</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="mb-6">
            <label for="kepala" class="form-label">Kepala</label>
            <select id="kepala" name="kepala" class="form-select">
              <?php foreach ($gurus as $guru): ?>
                <option value="<?= $guru['id'] ?>"><?= esc($guru['nama']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="tanggal_rapor" class="form-label">Tanggal Rapor</label>
            <input
              type="text"
              id="tanggal_rapor"
              name="tanggal_rapor"
              class="form-control"
              placeholder="Masukan Tanggal Rapor" />
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary" id="btn-simpan-semester">Simpan</button>
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

    const modal_semester = $('#modalSemester');
    const form_semester = $('#dataForm-semester');
    const submitButton_semester = $('#btn-simpan-semester');

    function resetModalSemester() {
      form_semester[0].reset();
    }

    const validasiSemester = new JustValidate('#dataForm-semester');

    validasiSemester.addField('#semester', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]).addField('#tahun', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]).addField('#tingkat', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]).addField('#kepala', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]).addField('#tanggal_rapor', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]);



    validasiSemester.onValidate(() => {
      // Form valid jika semua validasi terpenuhi
      isValidasiSemester = true;
    }).onFail(() => {
      // Form tidak valid jika ada validasi yang gagal
      isValidasiSemester = false;
    });

    var dataTable = $('#table-semester').DataTable({
      processing: true,
      serverSide: false,
      scrollX: true,
      responsive: true,
      ajax: {
        url: "<?= site_url('semester/ambil_data_semester'); ?>", // URL API server
        type: "POST",
      },
      columns: [

        {
          data: "id",
          className: "none",
          visible: false
        },
        {
          data: "semester",
          className: "all"
        },
        {
          data: "tahun",
          className: "all"
        },
        {
          data: "tingkat",
          className: "all"
        },
        {
          data: "nama_kepala",
          className: "all"
        },
        {
          data: "tanggal_rapor",
          className: "all"
        },
        {
          data: null,
          className: "all",
          render: function(data, type, row) {
            return `<button class="btn btn-sm btn-info editBtn"
            data-id="${row.id}"
            data-semester="${row.semester}"
            data-tahun="${row.tahun}"
            data-tingkat="${row.tingkat}"
            data-tanggal="${row.tanggal_rapor}"
            data-kepala="${row.kepala}"
            ><i class="ri-pencil-line"></i></button>`;
          }
        }
      ]
    });

    $('#table-semester').on('click', '.editBtn', function() {
      resetModalSemester();
      // Ambil data dari atribut data-*
      const id = $(this).data('id');
      const semester = $(this).data('semester');
      const tahun = $(this).data('tahun');
      const tingkat = $(this).data('tingkat');
      const tanggal = $(this).data('tanggal');
      const kepala = $(this).data('kepala');

      // alert(nama)

      $('#id').val(id);
      $('#semester').val(semester);
      $('#tahun').val(tahun);
      $('#tingkat').val(tingkat);
      $('#tanggal_rapor').val(tanggal);
      $('#kepala').val(kepala);

      $('#modalTitle-semester').text('Ubah Data Semester'); // Judul Modal

      submitButton_semester.text('Perbarui');
      submitButton_semester.data('action', 'edit');

      // Tampilkan modal
      modal_semester.modal('show');
    });

    $('#btn-tambah-semester').on('click', function() {
      resetModalSemester();
      $('#modalTitle-semester').text('Tambah Data Senester'); // Judul Modal
      submitButton_semester.text('Tambah Semester'); // Tombol Save
      submitButton_semester.data('action', 'add'); // Tandai sebagai Add

      modal_semester.modal('show');
    });

    form_semester.on('submit', function(e) {
      e.preventDefault();

      if (isValidasiSemester) {
        var originalText = submitButton_semester.text(); // Simpan teks asli tombol
        // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
        submitButton_semester.prop('disabled', true).text('Saving...');
        var formData = new FormData(this);

        const action = submitButton_semester.data('action');
        const url = action === 'add' ?
          "<?php echo site_url('semester/simpandata'); ?>" :
          "<?php echo site_url('semester/ubahdata'); ?>";

        $.ajax({
          url: url,
          type: "POST",
          data: formData,
          processData: false, // Jangan proses data sebagai string query
          contentType: false,
          success: function(res) {
            if (res.status === 'success') {
              // console.log("Success response:", res);
              Swal.fire('Peringatan', res.message, 'success');
            } else {
              // console.log("Success response:", res);
              Swal.fire('Peringatan', res.message, 'warning');
            }

            // alert(`Data berhasil ${action === 'add' ? 'ditambahkan' : 'diperbarui'}!`);
            modal_semester.modal('hide');
            dataTable.ajax.reload();
          },
          error: function(xhr) {
            console.error("Error:", xhr.responseText); // tambahkan ini
            Swal.fire('Peringatan', 'Gagal menyimpan data!', 'warning');

          },
          complete: function() {
            // Aktifkan kembali tombol dan kembalikan teks aslinya
            submitButton_semester.prop('disabled', false).text(originalText);
          }
        });
      }
    });
  });
</script>