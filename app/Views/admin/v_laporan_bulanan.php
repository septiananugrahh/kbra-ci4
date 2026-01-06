<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css" />

<style>
  .card {
    border-radius: 0.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .table-responsive {
    border-radius: 0.5rem;
    overflow: hidden;
  }

  #table-laporan-bulanan thead th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
  }

  .action-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 6px;
  }

  @media (max-width: 768px) {
    .action-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <?= session()->getFlashdata('success') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <?= session()->getFlashdata('error') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="mb-0">Laporan Bulanan</h5>
              <p class="text-muted mb-0">
                <strong>Tahun Ajaran:</strong> <?= esc($tahun) ?> |
                <strong>Semester:</strong> <?= esc($semester) ?>
              </p>
            </div>
            <button type="button" id="btn-generate-laporan" class="btn btn-success">
              <i class="ri-add-line"></i> Buat Laporan Baru
            </button>
          </div>

          <div class="table-responsive">
            <table id="table-laporan-bulanan" class="display" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Bulan</th>
                  <th>Tahun Ajaran</th>
                  <th>Semester</th>
                  <th>Status</th>
                  <th>Dibuat Oleh</th>
                  <th>Tanggal Dibuat</th>
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

<!-- Modal Generate Laporan -->
<div class="modal fade" id="modalGenerateLaporan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="ri-file-add-line"></i> Buat Laporan Bulanan Baru
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="bulan" class="form-label">Pilih Bulan <span class="text-danger">*</span></label>
          <select id="bulan" class="form-select">
            <option value="">-- Pilih Bulan --</option>
          </select>
        </div>
        <div class="alert alert-info">
          <small>
            <i class="ri-information-line"></i>
            Sistem akan mengambil semua data asesmen (Checklist, Anekdot, Hasta Karya, Foto Berseri)
            dari bulan yang dipilih dan menyalinnya ke laporan bulanan. Data asli tidak akan berubah.
          </small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="ri-close-line"></i> Batal
        </button>
        <button type="button" id="btn-confirm-generate" class="btn btn-primary">
          <i class="ri-file-add-line"></i> Generate Laporan
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalDeleteLaporan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="ri-delete-bin-line text-danger"></i> Konfirmasi Hapus
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning">
          <p class="mb-2">Apakah Anda yakin ingin menghapus laporan ini?</p>
          <h6 id="delete-laporan-info" class="mb-0 fw-bold"></h6>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="ri-close-line"></i> Batal
        </button>
        <button type="button" id="btn-confirm-delete" class="btn btn-danger">
          <i class="ri-delete-bin-line"></i> Ya, Hapus!
        </button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>

<script>
  const BASE_URL = '<?= base_url() ?>';
  const BULAN_LIST = <?= $bulan_list ?>;
  const GURU_ID = '<?= $guru_id ?>';
  let dataTable;
  let deleteTargetId = null;

  $(document).ready(function() {
    // Initialize DataTable
    initDataTable();

    // Populate bulan dropdown
    populateBulanDropdown();

    // Button generate laporan
    $('#btn-generate-laporan').on('click', function() {
      $('#bulan').val('');
      $('#modalGenerateLaporan').modal('show');
    });

    // Confirm generate
    $('#btn-confirm-generate').on('click', handleGenerate);

    // Confirm delete
    $('#btn-confirm-delete').on('click', handleDelete);

    // Event delegation untuk button edit, print, delete
    $(document).on('click', '.btn-edit-laporan', handleEdit);
    $(document).on('click', '.btn-print-laporan', handlePrint);
    $(document).on('click', '.btn-delete-laporan', showDeleteModal);
  });

  function initDataTable() {
    dataTable = $('#table-laporan-bulanan').DataTable({
      processing: true,
      scrollX: true,
      serverSide: false,
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.childRowImmediate,
          type: 'column',
          renderer: renderResponsiveCard
        }
      },
      data: <?= json_encode($laporan_list) ?>,
      columns: [{
          data: "id",
          visible: false
        },
        {
          data: "nama_bulan"
        },
        {
          data: "tahun"
        },
        {
          data: "semester"
        },
        {
          data: null,
          render: function(data) {
            if (data.status === 'draft') {
              return '<span class="badge bg-warning">Draft</span>';
            }
            return '<span class="badge bg-success">Final</span>';
          }
        },
        {
          data: "pembuat_nama",
          render: function(data) {
            return data || '-';
          }
        },
        {
          data: "dibuat_pada",
          render: function(data) {
            if (!data) return '-';
            const date = new Date(data);
            return date.toLocaleDateString('id-ID', {
              day: '2-digit',
              month: 'short',
              year: 'numeric',
              hour: '2-digit',
              minute: '2-digit'
            });
          }
        },
        {
          data: null,
          render: renderActionButtons
        }
      ]
    });
  }

  function renderActionButtons(data) {
    const isOwner = data.dibuat_oleh == GURU_ID;

    let html = '<div class="action-grid">';
    html += `<a href="${BASE_URL}laporan-bulanan/edit/${data.id}" class="btn btn-sm btn-info btn-edit-laporan" title="Edit">
              <i class="ri-edit-line"></i>
            </a>`;
    html += `<button type="button" class="btn btn-sm btn-success btn-print-laporan" 
              data-id="${data.id}" title="Print PDF">
              <i class="ri-printer-line"></i>
            </button>`;

    if (isOwner) {
      html += `<button type="button" class="btn btn-sm btn-danger btn-delete-laporan" 
                data-id="${data.id}" 
                data-bulan="${data.nama_bulan}"
                data-tahun="${data.tahun}" 
                title="Hapus">
                <i class="ri-delete-bin-line"></i>
              </button>`;
    }

    html += '</div>';
    return html;
  }

  function renderResponsiveCard(api, rowIdx, columns) {
    const data = api.row(rowIdx).data();
    const isOwner = data.dibuat_oleh == GURU_ID;

    let content = '<div class="card mb-3"><div class="card-body">';

    columns.forEach(col => {
      const header = dataTable.column(col.columnIndex).header().textContent;
      const value = col.data;

      if (header && value && header !== 'Aksi') {
        content += `<p class="card-text"><strong>${header}:</strong> ${value}</p>`;
      }
    });

    content += '<div class="row mt-3">';
    content += `<div class="col-6">
                  <a href="${BASE_URL}laporan-bulanan/edit/${data.id}" 
                     class="btn btn-lg btn-info w-100">
                    <i class="ri-edit-line"></i> Edit
                  </a>
                </div>`;
    content += `<div class="col-6">
                  <button type="button" class="btn btn-lg btn-success w-100 btn-print-laporan" 
                          data-id="${data.id}">
                    <i class="ri-printer-line"></i> Print
                  </button>
                </div>`;
    content += '</div>';

    if (isOwner) {
      content += '<div class="row mt-2">';
      content += `<div class="col-12">
                    <button type="button" class="btn btn-lg btn-danger w-100 btn-delete-laporan" 
                            data-id="${data.id}" 
                            data-bulan="${data.nama_bulan}"
                            data-tahun="${data.tahun}">
                      <i class="ri-delete-bin-line"></i> Hapus
                    </button>
                  </div>`;
      content += '</div>';
    }

    content += '</div></div>';

    return content ? $('<div/>').append(content) : false;
  }

  function populateBulanDropdown() {
    const $select = $('#bulan');
    Object.entries(BULAN_LIST).forEach(([key, value]) => {
      $select.append(`<option value="${key}">${value}</option>`);
    });
  }

  function handleGenerate() {
    const bulan = $('#bulan').val();

    if (!bulan) {
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: 'Pilih bulan terlebih dahulu!'
      });
      return;
    }

    const $btn = $('#btn-confirm-generate');
    const originalText = $btn.html();
    $btn.prop('disabled', true).html('<i class="ri-loader-4-line ri-spin"></i> Memproses...');

    $.ajax({
      url: BASE_URL + 'laporan-bulanan/generate',
      type: 'POST',
      data: {
        bulan: bulan
      },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          $('#modalGenerateLaporan').modal('hide');
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: response.message,
            timer: 2000,
            showConfirmButton: false
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: response.message
          });
        }
      },
      error: function() {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Terjadi kesalahan. Silakan coba lagi.'
        });
      },
      complete: function() {
        $btn.prop('disabled', false).html(originalText);
      }
    });
  }

  function handleEdit(e) {
    e.preventDefault();
    const url = $(this).attr('href');
    window.location.href = url;
  }

  function handlePrint() {
    const id = $(this).data('id');
    window.open(BASE_URL + 'laporan-bulanan/download-pdf/' + id, '_blank');
  }

  function showDeleteModal() {
    deleteTargetId = $(this).data('id');
    const bulan = $(this).data('bulan');
    const tahun = $(this).data('tahun');

    $('#delete-laporan-info').text(`Laporan ${bulan} - ${tahun}`);
    $('#modalDeleteLaporan').modal('show');
  }

  function handleDelete() {
    if (!deleteTargetId) return;

    const $btn = $('#btn-confirm-delete');
    const originalText = $btn.html();
    $btn.prop('disabled', true).html('<i class="ri-loader-4-line ri-spin"></i> Menghapus...');

    $.ajax({
      url: BASE_URL + 'laporan-bulanan/delete/' + deleteTargetId,
      type: 'DELETE',
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          $('#modalDeleteLaporan').modal('hide');
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: response.message,
            timer: 2000,
            showConfirmButton: false
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: response.message
          });
        }
      },
      error: function() {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Terjadi kesalahan. Silakan coba lagi.'
        });
      },
      complete: function() {
        $btn.prop('disabled', false).html(originalText);
        deleteTargetId = null;
      }
    });
  }
</script>