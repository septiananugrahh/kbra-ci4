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


            <?php if (array_intersect(['3'], session('roles'))) : ?>
              <div class="d-flex justify-content-end">
                <button type="button" id="btn-tambah-santri" class="btn btn-success mb-10 me-5">
                  <i class="ri-add-line"></i> &nbsp;Tambah Data
                </button>

                <button type="button" id="btn-upload-santri" class="btn btn-success mb-10">
                  <i class="ri-upload-2-line"></i> &nbsp;Upload Data
                </button>
              </div>

            <?php endif; ?>


            <?php if (
              (array_intersect(['4'], session('roles')) && !empty(session('kelas_id'))) ||
              (array_intersect(['3'], session('roles')))
            ) : ?>
              <div class="d-flex align-items-start row">
                <div class="table-responsive">
                  <table id="table-santri" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Foto Santri</th>
                        <th>Nama Santri</th>
                        <th>NISN</th>
                        <th>Usia</th>
                        <th>Jenjang</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>

              </div>
            <?php else: ?>
              Silahkan Pilih Kelas
            <?php endif; ?>


          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="UploadSantri" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-hapus-santri">Upload Santri</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('santri/import_excel') ?>" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>Import File Excel</label>
            <input type="file" name="excel_file" class="form-control" required accept=".xls,.xlsx">
          </div>
          <p></p>
          <button type="submit" class="btn btn-success">Import</button>
          <button class="btn btn-success">Download Template</button>
        </form>


      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="DelmodalSantri" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-hapus-santri">Hapus Santri</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="delSantri">

          <div class="form-group">
            <input type="hidden" id="delID" name="delIdSantri" readonly>
            <h2>
              <div id="delNama"></div>
            </h2>
          </div>

          <div class="d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-danger"
              id="btn-hapus-santri">Iya !</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </form>


      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalSantri" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="dataForm-santri">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-santri">Modal title</h5>
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
            <input type="text" id="nama" name="nama" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-4">
            <label for="nis_lokal" class="form-label">NIS Lokal</label>
            <input type="text" id="nis_lokal" name="nis_lokal" class="form-control" />
          </div>

          <div class="col mb-4">
            <label for="nisn" class="form-label">NISN</label>
            <input type="text" id="nisn" name="nisn" class="form-control" />
          </div>

          <div class="col mb-4">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" id="nik" name="nik" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" />
          </div>

          <div class="col mb-6">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="telp" class="form-label">Telepon</label>
            <input type="text" id="telp" name="telp" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" id="alamat" name="alamat" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="nama_ayah" class="form-label">Nama Ayah</label>
            <input type="text" id="nama_ayah" name="nama_ayah" class="form-control" />
          </div>

          <div class="col mb-6">
            <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
            <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="nama_ibu" class="form-label">Nama Ibu</label>
            <input type="text" id="nama_ibu" name="nama_ibu" class="form-control" />
          </div>

          <div class="col mb-6">
            <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
            <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="jenjang" class="form-label">Jenjang</label>
            <select id="jenjang" name="jenjang" class="form-select">
              <option value="KB">KB</option>
              <option value="RA">RA</option>
              <option value="LULUS">LULUS</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="foto_santri" class="form-label">Foto Santri</label>
            <input type="file" id="foto_santri" name="foto_santri" class="form-control" accept="image/*" />
            <img id="imagePreview" src="#" alt="Preview Foto" style="max-width: 120px; margin-top: 10px; display: none;">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary" id="btn-simpan-santri">Simpan</button>
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


    const modal_santri = $('#modalSantri');
    const del_modal_santri = $('#DelmodalSantri');
    const form_santri = $('#dataForm-santri');
    const delButton_santri = $('#btn-hapus-santri');
    const submitButton_santri = $('#btn-simpan-santri');

    $('#foto_santri').on('change', function(event) {
      const input = event.target;
      const reader = new FileReader();

      reader.onload = function(e) {
        $('#imagePreview').attr('src', e.target.result).show();
      };

      if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
      }
    });

    function resetModalSantri() {
      form_santri[0].reset();
    }

    const validasiSantri = new JustValidate('#dataForm-santri');

    validasiSantri.addField('#nama', [{
        rule: 'required',
        errorMessage: 'Nama wajib diisi!',
      }])
      .addField('#nis_lokal', [{
        rule: 'required',
        errorMessage: 'NIS Lokal wajib diisi!',
      }])
      .addField('#nisn', [{
        rule: 'required',
        errorMessage: 'NISN wajib diisi!',
      }])
      .addField('#nik', [{
        rule: 'required',
        errorMessage: 'NIK wajib diisi!',
      }])
      .addField('#jenis_kelamin', [{
        rule: 'required',
        errorMessage: 'Pilih jenis kelamin!',
      }])
      .addField('#tempat_lahir', [{
        rule: 'required',
        errorMessage: 'Tempat lahir wajib diisi!',
      }])
      .addField('#tanggal_lahir', [{
        rule: 'required',
        errorMessage: 'Tanggal lahir wajib diisi!',
      }])
      .addField('#telp', [{
        rule: 'required',
        errorMessage: 'No. Telepon wajib diisi!',
      }])
      .addField('#alamat', [{
        rule: 'required',
        errorMessage: 'Alamat wajib diisi!',
      }])
      .addField('#nama_ayah', [{
        rule: 'required',
        errorMessage: 'Nama ayah wajib diisi!',
      }])
      .addField('#pekerjaan_ayah', [{
        rule: 'required',
        errorMessage: 'Pekerjaan ayah wajib diisi!',
      }])
      .addField('#nama_ibu', [{
        rule: 'required',
        errorMessage: 'Nama ibu wajib diisi!',
      }])
      .addField('#pekerjaan_ibu', [{
        rule: 'required',
        errorMessage: 'Pekerjaan ibu wajib diisi!',
      }])
      .addField('#foto_santri', [{
          rule: "custom",
          validator: (files) => {
            if (files.length > 0) {
              return files[0].size <= 2048000; // 1.5MB dalam byte
            }
            return true; // Tidak ada file = valid
          },
          errorMessage: "Ukuran file tidak boleh lebih dari 2MB!",
        },
        {
          rule: "files",
          value: {
            files: {
              extensions: ["jpg", "jpeg", "png"],
            },
          },
          errorMessage: "Format file tidak valid!",
        },
      ]);

    validasiSantri.onValidate(() => {
      // Form valid jika semua validasi terpenuhi
      isValidasiDataSantri = true;
    }).onFail(() => {
      // Form tidak valid jika ada validasi yang gagal
      isValidasiDataSantri = false;
    });

    var userRole = <?= session('roles') ? json_encode(session('roles')) : '[]' ?>;
    var kelasId = <?= session('kelas_id') ?? 'null' ?>;

    console.log(userRole + " - " + kelasId)

    var ajaxUrl = "<?= site_url('santri/ambil_data_santri'); ?>";

    // Jika role 4 (misal 'guru') dan kelas_id ada, gunakan URL khusus
    if (userRole.includes("4") && kelasId) {
      ajaxUrl = "<?= site_url('santri/ambil_data_santri_by_kelas'); ?>/" + kelasId;
      console.log("guru kelas")
    }

    var dataTable_santri = $('#table-santri').DataTable({
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
          data: 'foto_santri',
          render: function(data, type, row) {
            if (data) {
              return `<img src="uploads/foto_santri/${data}" alt="Foto" class="img-thumbnail" style="height: 50px;">`;
            } else {
              return `<span class="text-muted">Tidak ada</span>`;
            }
          },
          orderable: false,
          searchable: false
        },
        {
          data: "nama",
          className: "all"
        },
        {
          data: "nisn",
          className: "all"
        },
        {
          data: "tanggal_lahir",
          className: "all",
          render: function(data, type, row) {
            if (!data) return '-';

            const birthDate = new Date(data);
            const today = new Date();

            let years = today.getFullYear() - birthDate.getFullYear();
            let months = today.getMonth() - birthDate.getMonth();

            if (months < 0 || (months === 0 && today.getDate() < birthDate.getDate())) {
              years--;
              months += 12;
            }

            // Koreksi jumlah bulan jika tanggal belum lewat
            if (today.getDate() < birthDate.getDate()) {
              months--;
              if (months < 0) {
                months += 12;
                years--;
              }
            }

            return `${years} tahun ${months} bulan`;
          }
        },
        {
          data: "jenjang",
          className: "all"
        },
        {
          data: null,
          className: "all",
          render: function(data, type, row) {
            let html = `<button class="btn btn-sm btn-info editBtn me-2"
                        data-id="${row.id}"
                        data-nama="${row.nama}"
                        data-nis_lokal="${row.nis_lokal}"
                        data-nisn="${row.nisn}"
                        data-nik="${row.nik}"
                        data-jenis_kelamin="${row.jenis_kelamin}"
                        data-tempat_lahir="${row.tempat_lahir}"
                        data-tanggal_lahir="${row.tanggal_lahir}"
                        data-telp="${row.telp}"
                        data-alamat="${row.alamat}"
                        data-nama_ayah="${row.nama_ayah}"
                        data-pekerjaan_ayah="${row.pekerjaan_ayah}"
                        data-nama_ibu="${row.nama_ibu}"
                        data-pekerjaan_ibu="${row.pekerjaan_ibu}"
                        data-foto_santri="${row.foto_santri}"
                      > <i class="ri-pencil-line"></i></button>`;

            // Cek apakah user memiliki role 3
            if (userRole.includes("3")) {
              html += `<button class="btn btn-sm btn-danger delBtn" 
                          data-id="${row.id}"
                          data-nama="${row.nama}"
                        ><i class="ri-delete-bin-2-line"></i></button>`;
            }

            return html;
          }

        }
      ]
    });

    $('#table-santri').on('click', '.editBtn', function() {
      resetModalSantri();

      $('#id').val($(this).data('id'));
      $('#nama').val($(this).data('nama'));
      $('#nis_lokal').val($(this).data('nis_lokal'));
      $('#nisn').val($(this).data('nisn'));
      $('#nik').val($(this).data('nik'));
      $('#jenis_kelamin').val($(this).data('jenis_kelamin'));
      $('#tempat_lahir').val($(this).data('tempat_lahir'));
      $('#tanggal_lahir').val($(this).data('tanggal_lahir'));
      $('#telp').val($(this).data('telp'));
      $('#alamat').val($(this).data('alamat'));
      $('#nama_ayah').val($(this).data('nama_ayah'));
      $('#pekerjaan_ayah').val($(this).data('pekerjaan_ayah'));
      $('#nama_ibu').val($(this).data('nama_ibu'));
      $('#pekerjaan_ibu').val($(this).data('pekerjaan_ibu'));

      // Optional: preview foto santri jika ada elemen img di modal
      const foto = $(this).data('foto_santri');
      if (foto) {
        $('#imagePreview').attr('src', '/uploads/foto_santri/' + foto).show();
      } else {
        $('#imagePreview').hide();
      }


      $('#modalTitle-santri').text('Ubah Data Santri');
      submitButton_santri.text('Perbarui');
      submitButton_santri.data('action', 'edit');

      modal_santri.modal('show');
    });

    $('#table-santri').on('click', '.delBtn', function() {
      var id = $(this).data('id');
      var nama = $(this).data('nama');

      $('#delID').val(id);

      document.getElementById("delNama").innerText = nama;
      // Show the modal
      del_modal_santri.modal('show');
    });


    $('#btn-upload-santri').on('click', function() {
      const modal_upload_santri = $('#UploadSantri');
      modal_upload_santri.modal('show');
    });

    $('#btn-tambah-santri').on('click', function() {
      resetModalSantri();
      $('#modalTitle-santri').text('Tambah Data Santri'); // Judul Modal
      submitButton_santri.text('Tambah Santri'); // Tombol Save
      submitButton_santri.data('action', 'add'); // Tandai sebagai Add

      modal_santri.modal('show');
    });

    $(document).on('click', '#btn-hapus-santri', function() { // Ketika tombol simpan di klik
      //alert('aaa')
      var originalText = delButton_santri.text(); // Simpan teks asli tombol
      // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
      delButton_santri.prop('disabled', true).text('Deleting...');
      $.ajax({
        url: "<?= site_url('santri/hapusdata_soft'); ?>", // URL tujuan
        type: 'POST', // Tentukan type nya POST atau GET
        data: $("#delSantri").serialize(), // Ambil semua data yang ada didalam tag form
        dataType: 'json',
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType('application/jsoncharset=UTF-8')
          }
        },
        success: function(response) { // Ketika proses pengiriman berhasil

          if (response.status == 'sukses') {
            dataTable_santri.ajax.reload(null, false);
            del_modal_santri.modal('hide') // Close / Tutup Modal Dialog
          } else {
            $('#pesan-error').html(response.pesan).show()
          }
        },
        error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
          alert(xhr.responseText) // munculkan alert
        },
        complete: function() {
          // Aktifkan kembali tombol dan kembalikan teks aslinya
          delButton_santri.prop('disabled', false).text(originalText);
        }
      })
    })

    form_santri.on('submit', function(e) {
      e.preventDefault();

      if (isValidasiDataSantri) {
        var originalText = submitButton_santri.text(); // Simpan teks asli tombol
        // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
        submitButton_santri.prop('disabled', true).text('Saving...');
        var formData = new FormData(this);

        const action = submitButton_santri.data('action');
        const url = action === 'add' ?
          "<?php echo site_url('santri/simpandata'); ?>" :
          "<?php echo site_url('santri/ubahdata'); ?>";

        $.ajax({
          url: url,
          type: "POST",
          data: formData,
          processData: false, // Jangan proses data sebagai string query
          contentType: false,
          xhr: function() {
            let xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
              xhr.upload.addEventListener("progress", function(event) {
                if (event.lengthComputable) {
                  let percentComplete = (event.loaded / event.total) * 100;
                  $("#progressBar").css("width", percentComplete + "%").text(Math.round(percentComplete) + "%");
                }
              }, false);
            }
            return xhr;
          },
          success: function(res) {
            console.log("Success response:", res);

            if (res.status === 'success') {
              Swal.fire({
                icon: 'success', // Atau res.status
                title: 'Berhasil!',
                text: res.message || 'Data berhasil disimpan!', // Asumsi backend kirim message success
                showConfirmButton: true
              });
              $("#progressBar").css("width", "0%").text("0%");
              modal_santri.modal('hide');
              dataTable_santri.ajax.reload();
            } else if (res.status === 'errors') {
              let errorMessagesHtml = '<ul>'; // Buat list HTML untuk pesan error
              for (let field in res.message) {
                if (res.message.hasOwnProperty(field)) {
                  errorMessagesHtml += `<li><strong>${field}:</strong> ${res.message[field]}</li>`;
                }
              }
              errorMessagesHtml += '</ul>';

              Swal.fire({
                icon: 'error', // Set ikon ke 'error' untuk pesan validasi
                title: 'Kesalahan Validasi!',
                html: errorMessagesHtml, // Gunakan 'html' untuk menampilkan markup HTML
                showConfirmButton: true
              });

              // Opsional: Jika Anda punya elemen untuk menampilkan error per field di form
              // Misalnya, Anda bisa punya span dengan id 'nama_error', 'nis_lokal_error', dll.
              // for (let field in res.message) {
              //     if (res.message.hasOwnProperty(field)) {
              //         $('#' + field + '_error').text(res.message[field]).show();
              //     }
              // }

              $("#progressBar").css("width", "0%").text("0%"); // Reset progress bar
            } else {
              // Penanganan untuk status lain yang tidak terduga
              Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: res.message || 'Terjadi respons yang tidak terduga dari server.',
                showConfirmButton: true
              });
            }
            //alert(res.message);
            $("#progressBar").css("width", "0%").text("0%");
            // alert(`Data berhasil ${action === 'add' ? 'ditambahkan' : 'diperbarui'}!`);
            modal_santri.modal('hide');
            dataTable_santri.ajax.reload();
          },
          error: function(xhr) {
            console.error("Error:", xhr.responseText); // tambahkan ini
            alert('Gagal menyimpan data!');
          },
          complete: function() {
            // Aktifkan kembali tombol dan kembalikan teks aslinya
            submitButton_santri.prop('disabled', false).text(originalText);
          }
        });
      }
    });
  });
</script>