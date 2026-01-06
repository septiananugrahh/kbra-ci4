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
                            <a href="<?= base_url('laporan-bulanan/download-pdf/' . $laporan['id']) ?>"
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
                                    <h5 class="mb-0">
                                        <i class="ri-user-line"></i> <?= esc($santri_data['santri_nama']) ?>
                                    </h5>
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
                                                                    <div class="editable-item mb-2 p-2 border rounded"
                                                                        data-id="<?= $ket['id'] ?>"
                                                                        style="background-color: #f8f9fa;">
                                                                        <div class="editable-text">
                                                                            <?= esc($ket['keterangan']) ?>
                                                                        </div>
                                                                        <textarea class="form-control editable-input"
                                                                            rows="3"><?= esc($ket['keterangan']) ?></textarea>
                                                                    </div>
                                                                <?php
                                                                endforeach;
                                                            else:
                                                                ?>
                                                                <span class="text-muted">-</span>
                                                            <?php endif; ?>
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