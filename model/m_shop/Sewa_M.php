<?php

class Sewa_M extends Model
{
    // Membuat kode sewa otomatis
    public function buat_kode_sewa()
    {
        $sql = $this->db->prepare(
            "SELECT MAX(CAST(SUBSTRING(kode_sewa, 3) AS UNSIGNED)) AS nomor
             FROM sewa"
        );
        $sql->execute();
        $hasil = $sql->get_result()->fetch_assoc();
        $nomor = ($hasil['nomor'] !== null)
            ? (int) $hasil['nomor'] + 1
            : 1;
        return 'SW' . str_pad($nomor, 5, '0', STR_PAD_LEFT);
    }

    // Simpan header
    public function simpan($data_sewa)
    {
        // Simpan HEADER ke tabel sewa
        $sql = $this->db->prepare(
            "INSERT INTO sewa
            (kode_sewa, tgl_mulai, tgl_selesai, status_sewa, user_plg)
            VALUES (?, ?, ?, ?, ?)"
        );
        $sql->bind_param(
            "sssss",
            $data_sewa['kode_sewa'],
            $data_sewa['tgl_mulai'],
            $data_sewa['tgl_selesai'],
            $data_sewa['status_sewa'],
            $data_sewa['user_plg']
        );
        if ($sql->execute()) {
            return $data_sewa['kode_sewa'];
        } else {
            return false;
        }
    }

    // Simpan Detail
    public function simpandetail($data_pilih)
    {
        // Simpan DETAIL ke tabel pilih
        $sql = $this->db->prepare(
            "INSERT INTO pilih
            (kode_sewa, no_plat, hrg_sewa, n_hari)
            VALUES (?, ?, ?, ?)"
        );
        $sql->bind_param(
            "ssdi",
            $data_pilih['kode_sewa'],
            $data_pilih['no_plat'],
            $data_pilih['hrg_sewa'],
            $data_pilih['n_hari']
        );
        if ($sql->execute()) {
            return $data_pilih['kode_sewa'];
        } else {
            return false;
        }
    }

    // Cek transaksi keranjang aktif
    public function CekTransaksi($email)
    {
        $sql = $this->db->prepare(
            "SELECT * FROM sewa WHERE user_plg = ? AND status_sewa = 'Keranjang'"
        );
        $sql->bind_param("s", $email);
        $sql->execute();
        $hasil = $sql->get_result();
        $data = $hasil->fetch_assoc();
        return $data ? $data['kode_sewa'] : false;
    }

    // Cek apakah mobil sudah dipilih di keranjang
    public function CekDataPilih($kode, $no_plat)
    {
        $sql = $this->db->prepare(
            "SELECT * FROM pilih WHERE kode_sewa = ? AND no_plat = ?"
        );
        $sql->bind_param("ss", $kode, $no_plat);
        $sql->execute();
        $hasil = $sql->get_result();
        $data = $hasil->fetch_assoc();
        return $data ? $data['kode_sewa'] : false;
    }

    // Menghitung jumlah mobil di keranjang
    public function DataKeranjang($email)
    {
        $sql = $this->db->prepare(
            "SELECT sewa.kode_sewa, COUNT(pilih.no_plat) AS jumlah
             FROM sewa
             INNER JOIN pilih ON sewa.kode_sewa = pilih.kode_sewa
             WHERE sewa.user_plg = ?
             AND sewa.status_sewa = 'Keranjang'
             GROUP BY sewa.kode_sewa"
        );

        $sql->bind_param("s", $email);
        $sql->execute();

        $hasil = $sql->get_result();
        $data = $hasil->fetch_assoc();

        return $data ? $data['jumlah'] : 0;
    }

    // Menampilkan detail mobil di keranjang
    public function DtKeranjang($email)
    {
        $sql = $this->db->prepare(
            "SELECT sewa.kode_sewa, sewa.tgl_mulai, sewa.tgl_selesai, sewa.wkt_ambil, sewa.status_sewa,
                    pilih.no_plat, pilih.n_hari, mobil.nm_mobil, mobil.hrg_hari, mobil.ft_depan
             FROM sewa
             INNER JOIN pilih ON sewa.kode_sewa = pilih.kode_sewa
             INNER JOIN mobil ON pilih.no_plat = mobil.no_plat
             WHERE sewa.user_plg = ? AND sewa.status_sewa = 'Keranjang'"
        );
        $sql->bind_param("s", $email);
        $sql->execute();
        $hasil = $sql->get_result();
        return $hasil->fetch_all(MYSQLI_ASSOC);
    }

    // Hapus detail mobil di keranjang
    public function HapusDtKeranjang($no_plat, $kode_sewa)
    {
        $dtmobil = $this->db->prepare("DELETE FROM pilih WHERE no_plat = ? and kode_sewa=?");
        $dtmobil->bind_param("ss", $no_plat, $kode_sewa);
        $hasil = $dtmobil->execute();
        $dtmobil->close();
        return $hasil;
    }

    // Update detail keranjang
    public function updatekeranjang($data)
    {
        // Update tabel sewa
        $stmt1 = $this->db->prepare("UPDATE sewa SET tgl_mulai = ?, tgl_selesai = ?, wkt_ambil = ? WHERE kode_sewa = ?");
        $stmt1->bind_param(
            "ssss",
            $data['tgl_mulai'],
            $data['tgl_selesai'],
            $data['wkt_ambil'],
            $data['kode_sewa']
        );
        $stmt1->execute();
        $stmt1->close();

        // Update tabel pilih
        $stmt2 = $this->db->prepare("UPDATE pilih SET n_hari = ? WHERE kode_sewa = ?");
        $stmt2->bind_param(
            "is",
            $data['n_hari'],
            $data['kode_sewa']
        );
        $stmt2->execute();
        $stmt2->close();
        $this->db->commit();
        return true;
    }

    // Menampilkan detail data checkout
    public function datacheckout($kode_sewa)
    {
        $sql = $this->db->prepare(
            "SELECT sewa.kode_sewa, sewa.tgl_mulai, sewa.tgl_selesai, sewa.wkt_ambil, sewa.status_sewa,
                    pilih.no_plat, pilih.hrg_sewa, pilih.n_hari,
                    mobil.nm_mobil, mobil.ft_depan
             FROM sewa
             INNER JOIN pilih ON sewa.kode_sewa = pilih.kode_sewa
             INNER JOIN mobil ON pilih.no_plat = mobil.no_plat
             WHERE sewa.kode_sewa = ?"
        );
        $sql->bind_param("s", $kode_sewa);
        $sql->execute();
        $hasil = $sql->get_result();
        return $hasil->fetch_all(MYSQLI_ASSOC);
    }

    // Mengajukan transaksi (ubah status menjadi Diajukan)
    public function ajukantransaksi($kode_sewa)
    {
        $sql = "UPDATE sewa SET status_sewa = 'Diajukan' WHERE kode_sewa = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $kode_sewa);
        $hasil = $stmt->execute();
        $stmt->close();
        return $hasil;
    }
}