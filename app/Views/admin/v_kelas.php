<style>
  .table-responsive {
    width: 100%;
    overflow-x: auto;
    /* Penting untuk responsivitas jika tabel terlalu lebar */
  }

  .my-swal {
    z-index: 1500;
  }
</style>

<div class="row">
  <div class="col-xxl-12 mb-6 order-0">
    <div class="card">

      <div class="d-flex align-items-start row">
        <div class="col-sm-12">
          <div class="card-body">



            <div class="d-flex justify-content-between mb-3">
              <div class="d-flex gap-2">
                <select id="filter-tahun" class="form-select" style="width: auto;">
                  <option value="">-- Semua Tahun --</option>
                </select>
                <select id="filter-jenjang" class="form-select" style="width: auto;">
                  <option value="">-- Semua Jenjang --</option>
                  <option value="KB">KB</option>
                  <option value="RA">RA</option>
                </select>
              </div>
              <button type="button" id="btn-tambah-kelas" class="btn btn-success">
                <i class="ri-add-line"></i> &nbsp;Tambah Data
              </button>
            </div>

            <div class="d-flex align-items-start row">
              <div class="table-responsive">
                <table id="table-kelas" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Jenjang</th>
                      <th>Tingkat</th>
                      <th>Nama Kelas</th>
                      <th>Tahun</th>
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

<div class="modal fade" id="modalPilihSantri" tabindex="-1" data-bs-backdrop="static" style="z-index: 1095;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Santri</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table id="tablePilihSantri" class="table table-striped"></table>
      </div>
      <button type="button" class="btn btn-success" id="btnSimpanSantri">Simpan Santri</button>

    </div>
  </div>
</div>

<div class="modal fade" id="modalPilihGuru" tabindex="-1" data-bs-backdrop="static" style="z-index: 1095;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Guru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table id="tablePilihGuru" class="table table-striped"></table>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalAturKelas" tabindex="-1" style="z-index: 1090;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Atur Kelas: <span id="namaKelasModal"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="tabKelas" role="tablist">
          <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabSantri" type="button">Santri</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabGuru" type="button">Guru</button>
          </li>
        </ul>
        <div class="tab-content mt-3">
          <div class="tab-pane fade show active" id="tabSantri">
            <button id="btnTambahSantri" class="btn btn-success mb-2">+ Tambah Santri</button>

            <div class="table-responsive">
              <table id="tableSantriKelas" style="width:100%" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>

          </div>
          <div class="tab-pane fade" id="tabGuru">
            <button id="btnTambahGuru" class="btn btn-success mb-2">+ Tambah Guru</button>

            <div class="table-responsive">
              <table id="tableGuruKelas" style="width:100%" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Wali</th>
                    <th>Nama</th>
                    <th>Aksi</th>
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



<!-- Modal -->
<div class="modal fade" id="DelmodalKelas" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-hapus-kelas">Hapus Kelas</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="delKelas">

          <div class="form-group">
            <input type="hidden" id="delID" name="delIdKelas" readonly>
            <h2>
              <span id="delJenjang"></span>-
              <span id="delTingkat"></span>-
              <span id="delNama"></span>
            </h2>
          </div>

          <div class="d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-danger"
              id="btn-hapus-kelas">Iya !</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </form>


      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalKelas" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="dataForm-kelas">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-kelas">Modal title</h5>
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
            <label for="jenjang" class="form-label">Jenjang</label>
            <select id="jenjang" name="jenjang" class="form-select">
              <option value="">-- Pilih Jenjang --</option>
              <option value="KB">KB</option>
              <option value="RA">RA</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="tingkat" class="form-label">Tingkat</label>
            <select id="tingkat" name="tingkat" class="form-select">
              <option value="A">A</option>
              <option value="B">B</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="tahun" class="form-label">Tahun Pelajaran</label>
            <input
              type="text"
              id="tahun"
              name="tahun"
              class="form-control"
              placeholder="Contoh: 2024/2025"
              maxlength="9" />
            <small class="text-muted">Format: YYYY/YYYY</small>
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="nama" class="form-label">Nama Kelas</label>
            <input
              type="text"
              id="nama"
              name="nama"
              class="form-control"
              placeholder="Masukan Nama Kelas . ." />
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary" id="btn-simpan-kelas">Simpan</button>
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

    // Ambil tahun dari data row jika ada
    $.ajax({
      url: "<?= site_url('kelas/get_tahun_by_kelas'); ?>",
      type: "POST",
      data: {
        id: id
      },
      dataType: "json",
      success: function(response) {
        if (response.tahun) {
          $('#tahun').val(response.tahun);
        }
      }
    });

    const modal_kelas = $('#modalKelas');
    const del_modal_kelas = $('#DelmodalKelas');
    const form_kelas = $('#dataForm-kelas');
    const delButton_kelas = $('#btn-hapus-kelas');
    const submitButton_kelas = $('#btn-simpan-kelas');

    function resetModalKelas() {
      form_kelas[0].reset();
    }

    const validasiKelas = new JustValidate('#dataForm-kelas');

    validasiKelas.addField('#nama', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]).addField('#jenjang', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]).addField('#tingkat', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]).addField('#tahun', [{
        rule: 'required',
        errorMessage: 'wajib diisi!',
      },
      {
        rule: 'customRegexp',
        value: /^\d{4}\/\d{4}$/,
        errorMessage: 'Format harus YYYY/YYYY (contoh: 2024/2025)',
      }
    ]);

    // Load opsi tahun
    $.ajax({
      url: "<?= site_url('kelas/get_tahun_list'); ?>",
      type: "GET",
      success: function(response) {
        response.data.forEach(function(item) {
          $('#filter-tahun').append(`<option value="${item.tahun}">${item.tahun}</option>`);
        });
      }
    });

    // Event listener untuk filter
    $('#filter-tahun, #filter-jenjang').on('change', function() {
      dataTable_kelas.ajax.reload();
    });

    validasiKelas.onValidate(() => {
      // Form valid jika semua validasi terpenuhi
      isValidDataKelas = true;
    }).onFail(() => {
      // Form tidak valid jika ada validasi yang gagal
      isValidDataKelas = false;
    });

    var dataTable_kelas = $('#table-kelas').DataTable({
      processing: true,
      serverSide: false,
      scrollX: true,
      responsive: true,
      ajax: {
        url: "<?= site_url('kelas/ambil_data_kelas'); ?>", // URL API server
        type: "POST",
        data: function(d) {
          d.tahun = $('#filter-tahun').val();
          d.jenjang = $('#filter-jenjang').val();
        }
      },
      columns: [

        {
          data: "id",
          className: "none",
          visible: false
        },
        {
          data: "jenjang",
          className: "all"
        },
        {
          data: "kelas_tingkat",
          className: "all"
        },
        {
          data: "nama",
          className: "all"
        },
        {
          data: "tahun",
          className: "all"
        },
        {
          data: null,
          className: "all",
          render: function(data, type, row) {
            return `<button class="btn btn-sm btn-info editBtn"
            data-id="${row.kelas_id}"
            data-nama="${row.nama}"
            data-jenjang="${row.jenjang}"
            data-tingkat="${row.kelas_tingkat}"
            data-tahun="${row.tahun}"
            ><i class="ri-pencil-line"></i></button>

            <button class="btn btn-sm btn-warning aturkelasBtn" 
            data-id="${row.kelas_id}"
            data-nama="${row.nama}"
            ><i class="ri-settings-3-line"></i></button>

            <button class="btn btn-sm btn-danger delBtn" 
            data-id="${row.kelas_id}"
            data-jenjang="${row.jenjang}"
            data-tingkat="${row.kelas_tingkat}"
            data-tahun="${row.tahun}"
            data-nama="${row.nama}"
            ><i class="ri-delete-bin-2-line"></i></button>`;
          }
        }
      ]
    });

    $('#table-kelas').on('click', '.aturkelasBtn', function() {
      const kelasId = $(this).data('id');
      const nama = $(this).data('nama');
      $('#namaKelasModal').text(nama);

      // Simpan kelasId jika perlu
      $('#modalAturKelas').data('kelas-id', kelasId);

      // Load Santri
      $('#tableSantriKelas').DataTable({
        destroy: true,
        responsive: true,
        ajax: `<?= site_url('kelas/get_santri_by_kelas') ?>/${kelasId}`,
        columns: [{
            data: 'nama'
          },
          {
            data: null,
            render: data => `<button class="btn btn-sm btn-danger btnHapusSantri" data-id="${data.id}">Hapus</button>`
          }
        ]
      });

      // Load Guru
      $('#tableGuruKelas').DataTable({
        destroy: true,
        responsive: true,
        ajax: `<?= site_url('kelas/get_guru_by_kelas') ?>/${kelasId}`,
        columns: [{
            "data": null, // Kolom ini tidak langsung dari data, akan dirender manual
            "orderable": false, // Tidak bisa diurutkan
            "searchable": false, // Tidak bisa dicari
            "width": "30px",
            "render": function(data, type, row) {
              // Asumsikan 'kelasId' adalah variabel JavaScript yang sudah didefinisikan
              const currentKelasId = kelasId; // Gunakan nama variabel yang jelas

              // Tentukan apakah radio button ini harus checked
              // Misalnya, jika 'row.is_selected_wali' bernilai true (dari data server)
              // Atau jika 'row.id' (ID guru) cocok dengan ID wali yang sudah tersimpan untuk kelas ini
              let isChecked = row.is_selected_wali ? 'checked' : '';
              // Atau, jika Anda punya ID wali kelas yang sudah terpilih di sisi client-side
              // if (row.id == selectedWaliIdForKelas) { // 'selectedWaliIdForKelas' adalah ID wali yang sudah ada
              //     isChecked = 'checked';
              // }


              return '<input type="radio" name="wali_guru" class="radio-select" data-kelas-id="' + currentKelasId + '" value="' + row.guru_id + '" ' + isChecked + '>';
            }
          },
          {
            data: 'nama'
          },
          {
            data: null,
            render: data => `<button class="btn btn-sm btn-danger btnHapusGuru" data-id="${data.id}">Hapus</button>`
          }
        ]
      });

      $('#modalAturKelas').modal('show');
    });

    $('#tableGuruKelas tbody').on('change', 'input.radio-select', function() {
      var selectedId = $(this).val(); // Dapatkan nilai (ID) dari radio yang dipilih
      var kelasId = $(this).data('kelas-id');

      $.ajax({
        url: "<?php echo base_url('kelas/simpandata_wali'); ?>", // Endpoint CI4 untuk memproses pilihan
        type: "POST",
        data: {
          guru_id: selectedId,
          kelas_id: kelasId,
        },
        dataType: "json", // Harapkan respons JSON dari server
        success: function(response) {
          if (response.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Wali Kelas',
              text: `data tersimpan`,
              timer: 1500,
              showConfirmButton: false,
              customClass: {
                container: 'my-swal'
              }
            });
          } else {
            alert('Gagal menyimpan pilihan: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error:", status, error);
          alert('Terjadi kesalahan saat mengirim data.');
        }
      });
    });

    $('#btnTambahSantri').on('click', function() {
      const kelasId = $('#modalAturKelas').data('kelas-id');

      $('#tablePilihSantri').DataTable({
        destroy: true,
        ajax: `<?= site_url('kelas/get_santri_tanpa_kelas') ?>/${kelasId}`,
        columns: [{
            data: null,
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
              return `<input type="checkbox" class="checkboxSantri" value="${row.id}">`;
            }
          },
          {
            data: 'nama'
          }
        ]
      });

      $('#modalPilihSantri').modal('show');
    });

    $('#btnSimpanSantri').on('click', function() {
      const kelasId = $('#modalAturKelas').data('kelas-id');

      // Ambil semua checkbox yang dicentang
      const selectedIds = [];
      $('.checkboxSantri:checked').each(function() {
        selectedIds.push($(this).val());
      });

      if (selectedIds.length === 0) {
        alert('Pilih setidaknya satu santri');
        return;
      }

      $.ajax({
        url: `<?= site_url('kelas/tambah_santri_ke_kelas_batch') ?>`,
        method: 'POST',
        data: {
          kelas_id: kelasId,
          santri_ids: selectedIds
        },
        success: function(res) {
          $('#modalPilihSantri').modal('hide');
          $('#tableSantriKelas').DataTable().ajax.reload();
        },
        error: function(xhr) {
          alert('Gagal menambahkan santri');
        }
      });
    });



    $('#btnTambahGuru').on('click', function() {
      const kelasId = $('#modalAturKelas').data('kelas-id');

      $('#tablePilihGuru').DataTable({
        destroy: true,
        responsive: true,
        ajax: `<?= site_url('kelas/get_guru') ?>/${kelasId}`,
        columns: [{
            data: 'nama'
          },
          {
            data: null,
            render: data => `<button class="btn btn-sm btn-primary btnPilihGuru" data-id="${data.id}">Pilih</button>`
          }
        ]
      });

      $('#modalPilihGuru').modal('show');
    });

    $('#tableSantriKelas').on('click', '.btnHapusSantri', function() {
      const id = $(this).data('id');
      const kelasId = $('#modalAturKelas').data('kelas-id');
      if (confirm('Yakin hapus santri dari kelas?')) {
        $.post(`<?= site_url('kelas/hapus_santri') ?>`, {
          kelas_id: kelasId,
          santri_id: id
        }, function() {
          $('#tableSantriKelas').DataTable().ajax.reload();
        });
      }
    });


    $('#tableGuruKelas').on('click', '.btnHapusGuru', function() {
      const id = $(this).data('id');
      if (confirm('Yakin hapus santri dari kelas?')) {
        $.post(`<?= site_url('kelas/hapus_guru') ?>`, {
          id_data: id
        }, function() {
          $('#tableGuruKelas').DataTable().ajax.reload();
        });
      }
    });


    // Tambah santri ke kelas
    $('#tablePilihSantri').on('click', '.btnPilihSantri', function() {
      const santriId = $(this).data('id');
      const kelasId = $('#modalAturKelas').data('kelas-id');

      $.post("<?= site_url('kelas/tambah_santri_ke_kelas') ?>", {
        santri_id: santriId,
        kelas_id: kelasId
      }, function(res) {
        console.log(res);
        $('#modalPilihSantri').modal('hide');
        $('#tableSantriKelas').DataTable().ajax.reload();
      });
    });

    $('#tablePilihGuru').on('click', '.btnPilihGuru', function() {
      const guruId = $(this).data('id');
      const kelasId = $('#modalAturKelas').data('kelas-id');

      $.post("<?= site_url('kelas/tambah_guru_ke_kelas') ?>", {
        guru_id: guruId,
        kelas_id: kelasId
      }, function(res) {
        console.log(res);
        $('#modalPilihGuru').modal('hide');
        $('#tableGuruKelas').DataTable().ajax.reload();
      });
    });


    $('#table-kelas').on('click', '.delBtn', function() {
      var id = $(this).data('id');
      var nama = $(this).data('nama');
      var tingkat = $(this).data('tingkat');
      var jenjang = $(this).data('jenjang');

      $('#delID').val(id);

      document.getElementById("delNama").innerText = nama;
      document.getElementById("delTingkat").innerText = tingkat;
      document.getElementById("delJenjang").innerText = jenjang;
      // Show the modal
      del_modal_kelas.modal('show');
    });

    $('#table-kelas').on('click', '.editBtn', function() {
      resetModalKelas();
      // Ambil data dari atribut data-*
      const id = $(this).data('id');
      const nama = $(this).data('nama');
      const tingkat = $(this).data('tingkat');
      const jenjang = $(this).data('jenjang');
      const tahun = $(this).data('tahun');


      $('#id').val(id);
      $('#nama').val(nama);
      $('#tingkat').val(tingkat);
      $('#jenjang').val(jenjang);
      $('#tahun').val(tahun);

      $('#modalTitle-kelas').text('Ubah Data Kelas'); // Judul Modal

      submitButton_kelas.text('Perbarui');
      submitButton_kelas.data('action', 'edit');

      // Tampilkan modal
      modal_kelas.modal('show');
    });

    $('#btn-tambah-kelas').on('click', function() {
      resetModalKelas();
      $('#modalTitle-kelas').text('Tambah Data Kelas'); // Judul Modal
      submitButton_kelas.text('Tambah Kelas'); // Tombol Save
      submitButton_kelas.data('action', 'add'); // Tandai sebagai Add

      modal_kelas.modal('show');
    });

    $(document).on('click', '#btn-hapus-kelas', function() { // Ketika tombol simpan di klik
      //alert('aaa')
      var originalText = delButton_kelas.text(); // Simpan teks asli tombol
      // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
      delButton_kelas.prop('disabled', true).text('Deleting...');
      $.ajax({
        url: "<?= site_url('kelas/hapusdata_soft'); ?>", // URL tujuan
        type: 'POST', // Tentukan type nya POST atau GET
        data: $("#delKelas").serialize(), // Ambil semua data yang ada didalam tag form
        dataType: 'json',
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType('application/jsoncharset=UTF-8')
          }
        },
        success: function(response) { // Ketika proses pengiriman berhasil
          $('#loading-simpan').hide() // Sembunyikan loading simpan

          if (response.status == 'sukses') {
            dataTable_kelas.ajax.reload(null, false);
            del_modal_kelas.modal('hide') // Close / Tutup Modal Dialog
          } else {
            $('#pesan-error').html(response.pesan).show()
          }
        },
        error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
          alert(xhr.responseText) // munculkan alert
        },
        complete: function() {
          // Aktifkan kembali tombol dan kembalikan teks aslinya
          delButton_kelas.prop('disabled', false).text(originalText);
        }
      })
    })

    form_kelas.on('submit', function(e) {
      e.preventDefault();

      if (isValidDataKelas) {
        var originalText = submitButton_kelas.text(); // Simpan teks asli tombol
        // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
        submitButton_kelas.prop('disabled', true).text('Saving...');
        var formData = new FormData(this);

        const action = submitButton_kelas.data('action');
        const url = action === 'add' ?
          "<?php echo site_url('kelas/simpandata'); ?>" :
          "<?php echo site_url('kelas/ubahdata'); ?>";

        $.ajax({
          url: url,
          type: "POST",
          data: formData,
          processData: false, // Jangan proses data sebagai string query
          contentType: false,
          success: function(res) {
            console.log("Success response:", res);
            alert(res.message);
            // alert(`Data berhasil ${action === 'add' ? 'ditambahkan' : 'diperbarui'}!`);
            modal_kelas.modal('hide');
            dataTable_kelas.ajax.reload();
          },
          error: function(xhr) {
            console.error("Error:", xhr.responseText); // tambahkan ini
            alert('Gagal menyimpan data!');
          },
          complete: function() {
            // Aktifkan kembali tombol dan kembalikan teks aslinya
            submitButton_kelas.prop('disabled', false).text(originalText);
          }
        });
      }
    });
  });
</script>