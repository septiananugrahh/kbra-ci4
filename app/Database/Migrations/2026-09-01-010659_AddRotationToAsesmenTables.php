<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRotationToAsesmenTables extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('rotation_foto1', 'asesmen_fotoberseri')) {
            $this->forge->addColumn('asesmen_fotoberseri', [
                'rotation_foto1' => ['type' => 'INT', 'constraint' => 3, 'default' => 0],
                'rotation_foto2' => ['type' => 'INT', 'constraint' => 3, 'default' => 0],
                'rotation_foto3' => ['type' => 'INT', 'constraint' => 3, 'default' => 0],
            ]);
        }
        if (! $this->db->fieldExists('rotation_foto', 'asesmen_hasilkarya')) {
            $this->forge->addColumn('asesmen_hasilkarya', [
                'rotation_foto' => ['type' => 'INT', 'constraint' => 3, 'default' => 0],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('rotation_foto1', 'asesmen_fotoberseri')) {
            $this->forge->dropColumn('asesmen_fotoberseri', ['rotation_foto1', 'rotation_foto2', 'rotation_foto3']);
        }
        if ($this->db->fieldExists('rotation_foto', 'asesmen_hasilkarya')) {
            $this->forge->dropColumn('asesmen_hasilkarya', 'rotation_foto');
        }
    }
}
