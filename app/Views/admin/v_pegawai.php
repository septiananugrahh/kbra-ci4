<div class="row">


  <div class="col-xxl-12 mb-6 order-0">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-sm-12">
          <div class="card-body">

            <div class="d-flex justify-content-end">
              <button type="button" id="btn-tambah-pegawai" class="btn btn-success mb-10">
                <i class="ri-add-line"></i> &nbsp;Tambah Data
              </button>
            </div>

            <div class="d-flex align-items-start row">
              <div class="table-responsive">
                <table id="table-ptk" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama PTK</th>
                      <th>Tempat Lahir</th>
                      <th>Tanggal Lahir</th>
                      <th>Username</th>
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
<div class="modal fade" id="DelmodalPegawai" tabindex="-1" aria-hidden="true">
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

        <form id="delPegawai">

          <div class="form-group">
            <input type="hidden" id="delID" name="delIdPegawai" readonly>
            <h2>
              <div id="delNama"></div>
            </h2>
          </div>

          <div class="d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-danger"
              id="btn-hapus-pegawai">Iya !</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </form>


      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalPegawai" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="dataForm-ptk">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle-pegawai">Modal title</h5>
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
            <label for="username" class="form-label">Username</label>
            <input
              type="text"
              id="username"
              name="username"
              class="form-control"
              placeholder="Masukan Username" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="password" class="form-label">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              class="form-control"
              placeholder="Masukan Password" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="password" class="form-label">Re-Type Password</label>
            <input
              type="password"
              id="re_password"
              name="re_password"
              class="form-control"
              placeholder="Masukan Password" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="alamat" class="form-label">Alamat</label>
            <input
              type="text"
              id="alamat"
              name="alamat"
              class="form-control"
              placeholder="Ponorogo . . " />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="tempat" class="form-label">Tempat</label>
            <input
              type="text"
              id="tempat"
              name="tempat"
              class="form-control"
              placeholder="Ponorogo . . " />
          </div>
        </div>

        <div class="row">
          <div class="col mb-6">
            <label for="tanggal" class="form-label">Tanggal Lahir</label>
            <input
              type="date"
              id="tanggal"
              name="tanggal"
              class="form-control"
              placeholder="Enter Name" />
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary" id="btn-simpan-pegawai">Simpan</button>
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

    const modal_pegawai = $('#modalPegawai');
    const del_modal_pegawai = $('#DelmodalPegawai');
    const form_pegawai = $('#dataForm-ptk');
    const delButton_pegawai = $('#btn-hapus-pegawai');
    const submitButton_pegawai = $('#btn-simpan-pegawai');

    function resetModalPegawai() {
      form_pegawai[0].reset();
    }

    const validasiPegawai = new JustValidate('#dataForm-ptk');

    validasiPegawai.addField('#nama', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]).addField('#username', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]).addField('#tempat', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]).addField('#tanggal', [{
      rule: 'required',
      errorMessage: 'wajib diisi!',
    }, ]).addField('#password', [{
      rule: 'required',
      errorMessage: 'password wajib diisi!',
    }, ]).addField('#re_password', [{
        rule: 'required',
        errorMessage: 'Konfirmasi password wajib diisi',
      },
      {
        validator: (value, fields) => {
          return value === fields['#password'].elem.value;
        },
        errorMessage: 'Password tidak cocok',
      },
    ]).addField('#alamat', [{
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

    var dataTable = $('#table-ptk').DataTable({
      processing: true,
      serverSide: false,
      scrollX: true,
      responsive: true,
      ajax: {
        url: "<?= site_url('pegawai/ambil_data_pegawai'); ?>", // URL API server
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
          data: "tempat_lahir",
          className: "all"
        },
        {
          data: "tanggal_lahir",
          className: "all"
        },
        {
          data: "username",
          className: "all"
        },
        {
          data: null,
          className: "all",
          render: function(data, type, row) {
            return `<button class="btn btn-sm btn-info editBtn"
            data-id="${row.id}"
            data-nama="${row.nama}"
            data-alamat="${row.alamat}"
            data-username="${row.username}"
            data-tempat="${row.tempat_lahir}"
            data-tanggal="${row.tanggal_lahir}"
            ><i class="ri-pencil-line"></i></button>

            <?php if (array_intersect(["5"], session("roles"))) : ?>
            <button class="btn btn-sm btn-warning roleBtn" 
            data-id="${row.id}"
            data-nama="${row.nama}"
            ><i class="ri-function-add-line"></i></button>
            <?php endif ?>

            <button class="btn btn-sm btn-danger delBtn" 
            data-id="${row.id}"
            data-nama="${row.nama}"
            ><i class="ri-delete-bin-2-line"></i></button>`;
          }
        }
      ]
    });

    $(document).on('click', '.roleBtn', function() {
      const userId = $(this).data('id');
      const userName = $(this).data('nama');

      $('#namaUserRole').text(userName);
      $('#inputUserIdRole').val(userId);
      $('#modalRole').modal('show');

      // Ambil role yang dimiliki user
      $.get("<?= site_url('pegawai/get_roles_by_user'); ?>/" + userId, function(data) {
        let html = '<ul>';
        data.userRoles.forEach(role => {
          html += `<li>
        ${role.nama}
          <button class="btn btn-sm btn-danger btn-delete-role ms-2" data-user-id="${userId}" data-role-id="${role.type}">Hapus</button>
          </li>`;
        });
        html += '</ul>';
        $('#listRoleUser').html(html);

      });

      // Ambil semua role untuk dropdown
      $.get("<?= site_url('pegawai/get_all_roles'); ?>", function(data) {
        let options = '';
        data.roles.forEach(role => {
          options += `<option value="${role.id}">${role.nama}</option>`;
        });
        $('#selectRole').html(options);
      });
    });

    $('#formTambahRole').on('submit', function(e) {
      e.preventDefault();
      $.post("<?= site_url('pegawai/tambah_role'); ?>", $(this).serialize(), function(res) {
        if (res.status == 'success') {
          $('.roleBtn[data-id="' + $('#inputUserIdRole').val() + '"]').click(); // reload role list
        } else {
          Swal.fire('Peringatan', 'Gagal Menambahkan Role.', 'warning');
        }
      });
    });

    $(document).on('click', '.btn-delete-role', function() {
      const userId = $(this).data('user-id');
      const roleId = $(this).data('role-id');

      if (confirm('Yakin ingin menghapus role ini?')) {
        $.post("<?= site_url('pegawai/hapus_role'); ?>", {
          user_id: userId,
          level_id: roleId
        }, function(res) {
          if (res.status === 'success') {
            $('.roleBtn[data-id="' + userId + '"]').click(); // Reload modal
          } else {
            Swal.fire('Peringatan', 'Gagal Menghapus Role.', 'warning');

          }
        });
      }
    });




    $('#table-ptk').on('click', '.delBtn', function() {
      var id = $(this).data('id');
      var nama = $(this).data('nama');

      $('#delID').val(id);

      document.getElementById("delNama").innerText = nama;
      // Show the modal
      del_modal_pegawai.modal('show');
    });

    $('#table-ptk').on('click', '.editBtn', function() {
      resetModalPegawai();
      // Ambil data dari atribut data-*
      const id = $(this).data('id');
      const nama = $(this).data('nama');
      const username = $(this).data('username');
      const tempat = $(this).data('tempat');
      const tanggal = $(this).data('tanggal');
      const alamat = $(this).data('alamat');

      // alert(nama)

      $('#id').val(id);
      $('#nama').val(nama);
      $('#username').val(username);
      // $('#password').val(password);
      // $('#re-password').val(password);
      $('#tempat').val(tempat);
      $('#tanggal').val(tanggal);
      $('#alamat').val(alamat);

      $('#modalTitle-pegawai').text('Ubah Data Pegawai'); // Judul Modal

      submitButton_pegawai.text('Perbarui');
      submitButton_pegawai.data('action', 'edit');

      // Tampilkan modal
      modal_pegawai.modal('show');
    });

    $('#btn-tambah-pegawai').on('click', function() {
      resetModalPegawai();
      $('#modalTitle-pegawai').text('Tambah Data Pegawai'); // Judul Modal
      submitButton_pegawai.text('Tambah Pegawai'); // Tombol Save
      submitButton_pegawai.data('action', 'add'); // Tandai sebagai Add

      modal_pegawai.modal('show');
    });

    $(document).on('click', '#btn-hapus-pegawai', function() { // Ketika tombol simpan di klik
      //alert('aaa')
      var originalText = delButton_pegawai.text(); // Simpan teks asli tombol
      // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
      delButton_pegawai.prop('disabled', true).text('Deleting...');
      $.ajax({
        url: "<?= site_url('pegawai/hapusdata_soft'); ?>", // URL tujuan
        type: 'POST', // Tentukan type nya POST atau GET
        data: $("#delPegawai").serialize(), // Ambil semua data yang ada didalam tag form
        dataType: 'json',
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType('application/jsoncharset=UTF-8')
          }
        },
        success: function(response) { // Ketika proses pengiriman berhasil
          $('#loading-simpan').hide() // Sembunyikan loading simpan

          if (response.status == 'sukses') {
            dataTable.ajax.reload(null, false);
            del_modal_pegawai.modal('hide') // Close / Tutup Modal Dialog
          } else {
            $('#pesan-error').html(response.pesan).show()
          }
        },
        error: function(xhr, ajaxOptions, thrownError) { // Ketika terjadi error
          alert(xhr.responseText) // munculkan alert
        },
        complete: function() {
          // Aktifkan kembali tombol dan kembalikan teks aslinya
          delButton_pegawai.prop('disabled', false).text(originalText);
        }
      })
    })

    form_pegawai.on('submit', function(e) {
      e.preventDefault();

      if (isValidDataPegawai) {
        var originalText = submitButton_pegawai.text(); // Simpan teks asli tombol
        // Nonaktifkan tombol dan ubah teks menjadi "Saving..."
        submitButton_pegawai.prop('disabled', true).text('Saving...');
        var formData = new FormData(this);

        const action = submitButton_pegawai.data('action');
        const url = action === 'add' ?
          "<?php echo site_url('pegawai/simpandata'); ?>" :
          "<?php echo site_url('pegawai/ubahdata'); ?>";

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
            modal_pegawai.modal('hide');
            dataTable.ajax.reload();
          },
          error: function(xhr) {
            console.error("Error:", xhr.responseText); // tambahkan ini
            Swal.fire('Peringatan', 'Gagal Menyimpan Data.', 'warning');

          },
          complete: function() {
            // Aktifkan kembali tombol dan kembalikan teks aslinya
            submitButton_pegawai.prop('disabled', false).text(originalText);
          }
        });
      }
    });
  });
</script>