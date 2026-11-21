<?php

class Mobil_M extends Model
{
    // ==========================================
    // MENAMPILKAN DATA MOBIL
    // ==========================================
    public function datamobil()
    {
        $sql = $this->db->prepare("
            SELECT
                no_plat,
                nm_mobil,
                nkursi,
                nbagasi,
                jns_mobil,
                transmisi,
                thn_buat,
                ft_depan,
                ft_blkg,
                ft_interior,
                hrg_hari,
                cttn_unit,
                status_unit
            FROM mobil
            ORDER BY no_plat ASC
        ");

        if (!$sql) {
            die('Query gagal: ' . $this->db->error);
        }

        $sql->execute();

        $hasil = $sql->get_result()->fetch_all(MYSQLI_ASSOC);

        $sql->close();

        return $hasil;
    }

    // ==========================================
    // CEK NOMOR PLAT
    // ==========================================
    public function cekplat($no_plat)
    {
        $sql = $this->db->prepare("
            SELECT no_plat
            FROM mobil
            WHERE no_plat = ?
        ");

        if (!$sql) {
            die('Query gagal: ' . $this->db->error);
        }

        $sql->bind_param("s", $no_plat);
        $sql->execute();

        $hasil = $sql->get_result()->num_rows > 0;

        $sql->close();

        return $hasil;
    }

    // ==========================================
    // MENGAMBIL DATA MOBIL BERDASARKAN PLAT
    // ==========================================
    public function get_by_id($no_plat)
    {
        $sql = $this->db->prepare("
            SELECT
                no_plat,
                nm_mobil,
                nkursi,
                nbagasi,
                jns_mobil,
                transmisi,
                thn_buat,
                ft_depan,
                ft_blkg,
                ft_interior,
                hrg_hari,
                cttn_unit,
                status_unit
            FROM mobil
            WHERE no_plat = ?
        ");

        if (!$sql) {
            die('Query gagal: ' . $this->db->error);
        }

        $sql->bind_param("s", $no_plat);
        $sql->execute();

        $hasil = $sql->get_result()->fetch_assoc();

        $sql->close();

        return $hasil;
    }

    // ==========================================
    // DETAIL MOBIL BERDASARKAN PLAT (UNTUK SHOP & SEWA)
    // ==========================================
    public function detailmobil($no_plat)
    {
        $no_plat = rawurldecode((string) $no_plat);
        return $this->get_by_id($no_plat);
    }

    // ==========================================
    // MENYIMPAN DATA MOBIL
    // ==========================================
    public function simpan($data)
    {
        foreach ($data as $k => $v) {
            if ($v === null) {
                $data[$k] = '';
            }
        }

        if (empty($data['hrg_hari'])) {
            $data['hrg_hari'] = 0;
        }

        $sql = $this->db->prepare("
            INSERT INTO mobil (
                no_plat,
                nm_mobil,
                nkursi,
                nbagasi,
                jns_mobil,
                transmisi,
                thn_buat,
                ft_depan,
                ft_blkg,
                ft_interior,
                hrg_hari,
                cttn_unit,
                status_unit
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$sql) {
            die('Query gagal: ' . $this->db->error);
        }

        $sql->bind_param(
            "ssiississsdss",
            $data['no_plat'],
            $data['nm_mobil'],
            $data['nkursi'],
            $data['nbagasi'],
            $data['jns_mobil'],
            $data['transmisi'],
            $data['thn_buat'],
            $data['ft_depan'],
            $data['ft_blkg'],
            $data['ft_interior'],
            $data['hrg_hari'],
            $data['cttn_unit'],
            $data['status_unit']
        );

        $hasil = $sql->execute();

        $sql->close();

        return $hasil;
    }

    // ==========================================
    // UPDATE DATA MOBIL
    // ==========================================
    public function update($data)
    {
        $sql = $this->db->prepare("
            UPDATE mobil SET
                nm_mobil = ?,
                nkursi = ?,
                nbagasi = ?,
                jns_mobil = ?,
                transmisi = ?,
                thn_buat = ?,
                ft_depan = ?,
                ft_blkg = ?,
                ft_interior = ?,
                hrg_hari = ?,
                cttn_unit = ?,
                status_unit = ?
            WHERE no_plat = ?
        ");

        if (!$sql) {
            die('Query gagal: ' . $this->db->error);
        }

        $sql->bind_param(
            "siississsdsss",
            $data['nm_mobil'],
            $data['nkursi'],
            $data['nbagasi'],
            $data['jns_mobil'],
            $data['transmisi'],
            $data['thn_buat'],
            $data['ft_depan'],
            $data['ft_blkg'],
            $data['ft_interior'],
            $data['hrg_hari'],
            $data['cttn_unit'],
            $data['status_unit'],
            $data['no_plat']
        );

        $hasil = $sql->execute();

        $sql->close();

        return $hasil;
    }

    // ==========================================
    // HAPUS DATA MOBIL
    // ==========================================
    public function delete($no_plat)
    {
        $sql = $this->db->prepare("
            DELETE FROM mobil
            WHERE no_plat = ?
        ");

        if (!$sql) {
            die('Query gagal: ' . $this->db->error);
        }

        $sql->bind_param("s", $no_plat);

        $hasil = $sql->execute();

        $sql->close();

        return $hasil;
    }
}