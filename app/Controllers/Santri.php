<?php

namespace App\Controllers;

use App\Models\RuangKelasModel;
use App\Models\SantriModel;

class Santri extends CustomController
{
  protected $santriModel;
  protected $ruangKelasModel;

  public function __construct()
  {
    $this->santriModel = new SantriModel();
    $this->ruangKelasModel = new RuangKelasModel();
  }

  public function simpandata()
  {
    $data = $this->request->getPost();
    $foto = $this->request->getFile('foto_santri');

    $validationRules = [
      'nama'           => 'required',
      'nis_lokal'      => 'required',
      'nisn'           => 'required',
      'nik'            => 'required',
      'jenis_kelamin'  => 'required',
      'tempat_lahir'   => 'required',
      'tanggal_lahir'  => 'required',
      'telp'           => 'required',
      'alamat'         => 'required',
      'nama_ayah'      => 'required',
      'pekerjaan_ayah' => 'required',
      'nama_ibu'       => 'required',
      'pekerjaan_ibu'  => 'required',
      'jenjang'        => 'required',
      'foto_santri'    => [
        'is_image[foto_santri]',
        'mime_in[foto_santri,image/jpg,image/jpeg,image/png]',
        'max_size[foto_santri,1024]'
      ]

    ];

    if (!$this->validate($validationRules)) {
      return $this->response->setStatusCode(400)->setJSON([
        'errors' => $this->validator->getErrors()
      ]);
    }

    $file = $this->request->getFile('foto_santri');
    $fotoName = null;

    if ($file && $file->isValid() && !$file->hasMoved()) {
      $fotoName = $file->getRandomName();
      $file->move('uploads/foto_santri', $fotoName);
    }

    // simpan ke database:
    $data['foto_santri'] = $fotoName;


    // Simpan data
    $this->santriModel->save([
      'nama'           => $data['nama'],
      'nis_lokal'      => $data['nis_lokal'],
      'nisn'           => $data['nisn'],
      'nik'            => $data['nik'],
      'jenis_kelamin'  => $data['jenis_kelamin'],
      'tempat_lahir'   => $data['tempat_lahir'],
      'tanggal_lahir'  => $data['tanggal_lahir'],
      'telp'           => $data['telp'],
      'alamat'         => $data['alamat'],
      'nama_ayah'      => $data['nama_ayah'],
      'pekerjaan_ayah' => $data['pekerjaan_ayah'],
      'nama_ibu'       => $data['nama_ibu'],
      'pekerjaan_ibu'  => $data['pekerjaan_ibu'],
      'jenjang'        => $data['jenjang'],
      'foto_santri'    => $data['foto_santri'],
    ]);

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data santri berhasil disimpan'
    ]);
  }


  public function ubahdata()
  {
    $data = $this->request->getPost();
    $id   = $data['id']; // pastikan ID dikirim dari form/edit modal
    $foto = $this->request->getFile('foto_santri');

    $validationRules = [
      'nama'           => 'required',
      // 'nis_lokal'      => "required|is_unique[santri.nis_lokal,id,{$id}]",
      'nis_lokal'      => "required",
      'nisn'           => "required",
      'nik'            => "required",
      'jenis_kelamin'  => 'required',
      'tempat_lahir'   => 'required',
      'tanggal_lahir'  => 'required',
      'telp'           => 'required',
      'alamat'         => 'required',
      'nama_ayah'      => 'required',
      'pekerjaan_ayah' => 'required',
      'nama_ibu'       => 'required',
      'jenjang'        => 'required',
      'pekerjaan_ibu'  => 'required',
    ];

    // Validasi foto hanya jika ada upload baru
    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
      $validationRules['foto_santri'] = [
        'is_image[foto_santri]',
        'mime_in[foto_santri,image/jpg,image/jpeg,image/png]',
        'max_size[foto_santri,512]'
      ];
    }

    $validationMessages = [
      'nama' => [
        'required' => 'Nama tidak boleh kosong.',
      ],
      'nis_lokal' => [
        'required'  => 'NIS Lokal tidak boleh kosong.',
        'is_unique' => 'NIS Lokal ini sudah terdaftar.',
      ],
      'foto_santri' => [
        'is_image'  => 'File yang diupload harus berupa gambar.',
        'mime_in'   => 'Format gambar tidak didukung (gunakan JPG, JPEG, atau PNG).',
        'max_size'  => 'Ukuran gambar maksimal 512KB.',
      ],
      // ... pesan untuk field lainnya
    ];

    if (!$this->validate($validationRules)) {
      return $this->response->setJSON([
        'status'  => 'errors',
        'message' => $this->validator->getErrors()
      ]);
    }

    // Ambil data lama
    $santriLama = $this->santriModel->find($id);
    $fotoName = $santriLama['foto_santri']; // default: tetap pakai yang lama

    // Jika upload foto baru
    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
      $fotoName = $foto->getRandomName();
      $foto->move('uploads/foto_santri', $fotoName);

      // Hapus foto lama
      if ($santriLama['foto_santri'] && file_exists('uploads/foto_santri/' . $santriLama['foto_santri'])) {
        unlink('uploads/foto_santri/' . $santriLama['foto_santri']);
      }
    }

    // Simpan data ke DB
    $this->santriModel->save([
      'id'             => $id,
      'nama'           => $data['nama'],
      'nis_lokal'      => $data['nis_lokal'],
      'nisn'           => $data['nisn'],
      'nik'            => $data['nik'],
      'jenis_kelamin'  => $data['jenis_kelamin'],
      'tempat_lahir'   => $data['tempat_lahir'],
      'tanggal_lahir'  => $data['tanggal_lahir'],
      'telp'           => $data['telp'],
      'alamat'         => $data['alamat'],
      'nama_ayah'      => $data['nama_ayah'],
      'pekerjaan_ayah' => $data['pekerjaan_ayah'],
      'nama_ibu'       => $data['nama_ibu'],
      'pekerjaan_ibu'  => $data['pekerjaan_ibu'],
      'jenjang'        => $data['jenjang'],
      'foto_santri'    => $fotoName,
    ]);

    return $this->response->setJSON([
      'status'  => 'success',
      'message' => 'Data santri berhasil diperbarui'
    ]);
  }

  public function hapusdata_soft()
  {
    $id = $this->request->getPost('delIdSantri');

    if (!$id) {
      return $this->response->setJSON([
        'status' => 'gagal',
        'message'  => 'ID tidak ditemukan'
      ]);
    }

    $update = $this->santriModel->update($id, ['deleted' => 1]);

    if ($update) {
      return $this->response->setJSON([
        'status' => 'sukses'
      ]);
    } else {
      return $this->response->setJSON([
        'status' => 'gagal',
        'pesan'  => 'Gagal menghapus data.'
      ]);
    }
  }


  public function index()
  {
    $data = [
      'title' => 'Santri | KBRA Islamic Center',
      'nav' => 'santri',
      'username' => $this->session->get('username')
    ];
    return $this->render('admin/v_santri', $data); // pakai render() dari CustomController
  }

  public function ambil_data_santri()
  {
    $data = $this->santriModel->where('deleted', 0)->findAll();

    $result = [
      "data" => $data
    ];

    return $this->response->setJSON($result);
  }

  public function ambil_data_santri_by_kelas($kelasId)
  {
    // Ambil ID santri dari tabel ruang_kelas yang sesuai kelasId
    $santriIds = $this->ruangKelasModel
      ->select('santri_id')
      ->where('kelas_id', $kelasId)
      ->findAll();

    $ids = array_column($santriIds, 'santri_id');

    $data = [];
    if (!empty($ids)) {
      $data = $this->santriModel
        ->whereIn('id', $ids)
        ->where('deleted', 0)
        ->findAll();
    }

    return $this->response->setJSON([
      'data' => $data
    ]);
  }


  public function importExcel()
  {
    $file = $this->request->getFile('excel_file');

    if (!$file->isValid()) {
      return redirect()->back()->with('error', 'File tidak valid.');
    }

    $ext = $file->getClientExtension();
    if (!in_array($ext, ['xls', 'xlsx'])) {
      return redirect()->back()->with('error', 'Hanya file Excel yang diizinkan.');
    }

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName());
    $sheet = $spreadsheet->getActiveSheet()->toArray();

    // Lewati baris pertama (header)
    foreach (array_slice($sheet, 1) as $row) {
      $data = [
        'nama'           => $row[0],
        'nis_lokal'      => $row[1],
        'nisn'           => $row[2],
        'nik'            => $row[3],
        'jenis_kelamin'  => $row[4],
        'tempat_lahir'   => $row[5],
        'tanggal_lahir'  => $row[6],
        'telp'           => $row[7],
        'alamat'         => $row[8],
        'nama_ayah'      => $row[9],
        'pekerjaan_ayah' => $row[10],
        'nama_ibu'       => $row[11],
        'pekerjaan_ibu'  => $row[12],
        'jenjang'        => $row[13],
        'foto_santri'    => null, // <- NULL untuk import excel
      ];

      // Simpan ke database
      $this->santriModel->save($data);
    }

    return redirect()->back()->with('message', 'Import berhasil.');
  }
}
