<!-- ====================================== -->
<!-- FILE: admin/laporan_bulanan/edit.php -->
<!-- ====================================== -->

<style>
    .editable-item {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .editable-item:hover {
        background-color: #f0f0f0 !important;
    }

    .editable-item .editable-input {
        display: none;
    }

    .table-bordered th,
    .table-bordered td {
        vertical-align: top;
    }

    @media print {
        .no-print {
            display: none;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                Edit Laporan Bulanan - <?= esc($laporan['nama_bulan']) ?>
                            </h5>
                            <small class="text-muted">
                                Tahun Ajaran: <?= esc($laporan['tahun']) ?> | Semester: <?= esc($laporan['semester']) ?>
                            </small>
                        </div>
                        <div class="no-print">
                            <a href="<?= base_url('laporan-bulanan') ?>" class="btn btn-secondary btn-sm me-2">
                                <i class="ri-arrow-left-line"></i> Kembali
                            </a>
                            <a href="<?= base_url('laporan-bulanan/customize/' . $laporan['id']) ?>"
                                class="btn btn-success btn-sm" target="_blank">
                                <i class="ri-printer-line"></i> Print PDF
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info no-print">
                        <i class="ri-information-line"></i>
                        <strong>Petunjuk:</strong> Klik pada teks untuk mengedit. Perubahan akan tersimpan otomatis saat Anda klik di luar area edit atau tekan Enter.
                    </div>

                    <?php if (empty($details)): ?>
                        <div class="alert alert-warning">
                            <i class="ri-alert-line"></i>
                            Tidak ada data santri untuk ditampilkan.
                        </div>
                    <?php else: ?>
                        <?php foreach ($details as $santri_id => $santri_data): ?>
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">
                                            <i class="ri-user-line"></i> <?= esc($santri_data['santri_nama']) ?>
                                        </h5>
                                        <a href="<?= base_url('laporan-bulanan/customize-santri/' . $laporan['id'] . '/' . $santri_id) ?>"
                                            class="btn btn-sm btn-success no-print" target="_blank">
                                            <i class="ri-printer-line"></i> Print
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <?php foreach ($capaian_list as $capaian): ?>
                                                        <th class="text-center" style="width: 33%; background-color: <?= esc($capaian['warna']) ?>;">
                                                            <?= esc($capaian['nama']) ?>
                                                        </th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php foreach ($capaian_list as $capaian): ?>
                                                        <td class="align-top">
                                                            <?php
                                                            $capaian_id = $capaian['id'];
                                                            if (isset($santri_data['capaian'][$capaian_id])):
                                                                $keterangan_list = $santri_data['capaian'][$capaian_id]['keterangan'];
                                                                foreach ($keterangan_list as $ket):
                                                            ?>
                                                                    <div class="editable-item mb-2 p-2 border rounded position-relative"
                                                                        data-id="<?= $ket['id'] ?>"
                                                                        style="background-color: #f8f9fa;">

                                                                        <!-- Tombol Hapus -->
                                                                        <button class="btn-hapus-item position-absolute"
                                                                            style="top:4px; right:4px; background:none; border:none; color:#dc3545; cursor:pointer; padding:0 4px; font-size:14px; line-height:1;"
                                                                            data-id="<?= $ket['id'] ?>"
                                                                            title="Hapus item">
                                                                            &times;
                                                                        </button>

                                                                        <div class="editable-text" style="padding-right: 20px;">
                                                                            <?= esc($ket['keterangan']) ?>
                                                                        </div>
                                                                        <textarea class="form-control editable-input" rows="3"><?= esc($ket['keterangan']) ?></textarea>
                                                                    </div>
                                                                <?php
                                                                endforeach;
                                                            else:
                                                                ?>
                                                                <span class="text-muted">-</span>
                                                            <?php endif; ?>
                                                            <!-- Tombol Tambah -->
                                                            <div class="mt-2">
                                                                <div class="add-item-form" style="display:none;">
                                                                    <textarea class="form-control add-item-input mb-1" rows="2" placeholder="Ketik keterangan baru..."></textarea>
                                                                    <button class="btn btn-sm btn-primary btn-save-add"
                                                                        data-laporan-id="<?= $laporan['id'] ?>"
                                                                        data-santri-id="<?= $santri_id ?>"
                                                                        data-capaian-id="<?= $capaian['id'] ?>">
                                                                        Simpan
                                                                    </button>
                                                                    <button class="btn btn-sm btn-secondary btn-cancel-add ms-1">Batal</button>
                                                                </div>
                                                                <button class="btn btn-sm btn-outline-primary btn-show-add w-100">
                                                                    <i class="ri-add-line"></i> Tambah Item
                                                                </button>
                                                            </div>
                                                        </td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    const BASE_URL = '<?= base_url() ?>';
    let currentEditingElement = null;

    $(document).ready(function() {
        // Click to edit
        $('.editable-item').on('click', function(e) {
            if ($(e.target).is('textarea')) return;

            if (currentEditingElement && currentEditingElement[0] !== this) {
                cancelEdit(currentEditingElement);
            }

            const $item = $(this);
            const $text = $item.find('.editable-text');
            const $input = $item.find('.editable-input');

            $text.hide();
            $input.show().focus();
            $item.css('background-color', '#fff3cd');
            currentEditingElement = $item;
        });

        // Save on blur
        $('.editable-input').on('blur', function() {
            saveEdit($(this).closest('.editable-item'));
        });

        // Save on Enter (without Shift)
        $('.editable-input').on('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                $(this).blur();
            }
            if (e.key === 'Escape') {
                cancelEdit($(this).closest('.editable-item'));
            }
        });
    });

    // Tampilkan form tambah
    $(document).on('click', '.btn-show-add', function() {
        const $wrapper = $(this).closest('td').find('.add-item-form');
        $wrapper.show();
        $(this).hide();
        $wrapper.find('.add-item-input').focus();
    });

    // Batal tambah
    $(document).on('click', '.btn-cancel-add', function() {
        const $td = $(this).closest('td');
        $(this).closest('.add-item-form').hide().find('.add-item-input').val('');
        $td.find('.btn-show-add').show();
    });

    // Simpan item baru
    $(document).on('click', '.btn-save-add', function() {
        const $btn = $(this);
        const $td = $btn.closest('td');
        const $input = $btn.closest('.add-item-form').find('.add-item-input');
        const keterangan = $input.val().trim();
        const laporan_id = $btn.data('laporan-id');
        const santri_id = $btn.data('santri-id');
        const capaian_id = $btn.data('capaian-id');

        if (!keterangan) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Keterangan tidak boleh kosong!'
            });
            return;
        }

        $btn.prop('disabled', true);

        $.ajax({
            url: BASE_URL + 'laporan-bulanan/add-detail',
            type: 'POST',
            data: {
                laporan_id,
                santri_id,
                capaian_id,
                keterangan
            },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    // Inject item baru ke DOM sebelum form tambah
                    const html = `
                    <div class="editable-item mb-2 p-2 border rounded position-relative" data-id="${res.new_id}" style="background-color:#f8f9fa;">
                        <button class="btn-hapus-item position-absolute"
                            style="top:4px;right:4px;background:none;border:none;color:#dc3545;cursor:pointer;padding:0 4px;font-size:14px;line-height:1;"
                            data-id="${res.new_id}" title="Hapus item">&times;</button>
                        <div class="editable-text" style="padding-right:20px;">${res.keterangan}</div>
                        <textarea class="form-control editable-input" rows="3">${res.keterangan}</textarea>
                    </div>`;
                    $td.find('.add-item-form').before(html);
                    $input.val('');
                    $td.find('.add-item-form').hide();
                    $td.find('.btn-show-add').show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan.'
                });
            },
            complete: function() {
                $btn.prop('disabled', false);
            }
        });
    });

    // Hapus item
    $(document).on('click', '.btn-hapus-item', function(e) {
        e.stopPropagation();
        const $item = $(this).closest('.editable-item');
        const id = $(this).data('id');

        Swal.fire({
            icon: 'warning',
            title: 'Hapus item ini?',
            text: 'Data akan dihapus permanen.',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: BASE_URL + 'laporan-bulanan/delete-detail',
                type: 'POST',
                data: {
                    detail_id: id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $item.fadeOut(300, () => $item.remove());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan.'
                    });
                }
            });
        });
    });

    function saveEdit($item) {
        const id = $item.data('id');
        const $text = $item.find('.editable-text');
        const $input = $item.find('.editable-input');
        const newValue = $input.val().trim();
        const oldValue = $text.text().trim();

        if (newValue === oldValue) {
            $input.hide();
            $text.show();
            $item.css('background-color', '#f8f9fa');
            currentEditingElement = null;
            return;
        }

        if (!newValue) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Keterangan tidak boleh kosong!'
            });
            $input.focus();
            return;
        }

        // Show loading
        $item.css('opacity', '0.6');

        $.ajax({
            url: BASE_URL + 'laporan-bulanan/update-detail',
            type: 'POST',
            data: {
                detail_id: id,
                keterangan: newValue
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $text.text(newValue);
                    $input.hide();
                    $text.show();
                    $item.css('background-color', '#d4edda');
                    setTimeout(function() {
                        $item.css('background-color', '#f8f9fa');
                    }, 1000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Gagal menyimpan perubahan'
                    });
                    $input.focus();
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan. Silakan coba lagi.'
                });
                $input.focus();
            },
            complete: function() {
                $item.css('opacity', '1');
                currentEditingElement = null;
            }
        });
    }

    function cancelEdit($item) {
        const $text = $item.find('.editable-text');
        const $input = $item.find('.editable-input');

        $input.val($text.text());
        $input.hide();
        $text.show();
        $item.css('background-color', '#f8f9fa');
        currentEditingElement = null;
    }
</script>