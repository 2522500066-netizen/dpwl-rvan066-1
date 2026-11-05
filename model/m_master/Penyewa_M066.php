<?php

class Penyewa_M066 extends Model
{
    private function prepareQuery($query)
    {
        $sql = $this->db->prepare($query);
        if (!$sql) {
            die("Query SQL gagal: " . $this->db->error);
        }
        return $sql;
    }

    // Mengambil seluruh data penyewa
    public function datapenyewa()
    {
        $sql = $this->prepareQuery("
            SELECT
                user_plg066,
                sandi066,
                nik066,
                nm_lngkp066,
                no_hp066,
                almt_lngkp066,
                ft_ktp066,
                ft_sim_a066
            FROM penyewa
            ORDER BY user_plg066 ASC
        ");

        $sql->execute();
        $hasil = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        $sql->close();

        return $hasil;
    }

    // Mengambil 1 data penyewa berdasarkan username (Wajib untuk Edit)
    public function get_by_id($username)
    {
        $sql = $this->prepareQuery("
            SELECT * FROM penyewa WHERE user_plg066 = ?
        ");

        $sql->bind_param("s", $username);
        $sql->execute();
        $hasil = $sql->get_result()->fetch_assoc();
        $sql->close();

        return $hasil;
    }

    // Cek duplikasi username
    public function cekusername($username)
    {
        $sql = $this->prepareQuery("
            SELECT user_plg066
            FROM penyewa
            WHERE user_plg066 = ?
        ");

        $sql->bind_param("s", $username);
        $sql->execute();

        $hasil = $sql->get_result()->num_rows > 0;
        $sql->close();

        return $hasil;
    }

    // Cek duplikasi NIK
    public function ceknik($nik)
    {
        $sql = $this->prepareQuery("
            SELECT nik066
            FROM penyewa
            WHERE nik066 = ?
        ");

        $sql->bind_param("s", $nik);
        $sql->execute();

        $hasil = $sql->get_result()->num_rows > 0;
        $sql->close();

        return $hasil;
    }

    // Simpan data penyewa baru
    public function simpan($data)
    {
        $username = $data['user_plg066'] ?? '';
        $password = $data['sandi066'] ?? '';
        $nik      = $data['nik066'] ?? '';
        $nama     = $data['nm_lngkp066'] ?? '';
        $hp       = $data['no_hp066'] ?? '';
        $alamat   = $data['almt_lngkp066'] ?? '';
        $ktp      = $data['ft_ktp066'] ?? '';
        $sim      = $data['ft_sim_a066'] ?? '';

        $sql = $this->prepareQuery("
            INSERT INTO penyewa (
                user_plg066,
                sandi066,
                nik066,
                nm_lngkp066,
                no_hp066,
                almt_lngkp066,
                ft_ktp066,
                ft_sim_a066
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $sql->bind_param(
            "ssssssss",
            $username,
            $password,
            $nik,
            $nama,
            $hp,
            $alamat,
            $ktp,
            $sim
        );

        $hasil = $sql->execute();
        $sql->close();

        return $hasil;
    }

    // Update data penyewa
    public function update($data)
    {
        $sql = $this->prepareQuery("
            UPDATE penyewa SET
                sandi066 = ?,
                nik066 = ?,
                nm_lngkp066 = ?,
                no_hp066 = ?,
                almt_lngkp066 = ?,
                ft_ktp066 = ?,
                ft_sim_a066 = ?
            WHERE user_plg066 = ?
        ");

        $sql->bind_param(
            "ssssssss",
            $data['sandi066'],
            $data['nik066'],
            $data['nm_lngkp066'],
            $data['no_hp066'],
            $data['almt_lngkp066'],
            $data['ft_ktp066'],
            $data['ft_sim_a066'],
            $data['user_plg066']
        );

        $hasil = $sql->execute();
        $sql->close();

        return $hasil;
    }

    // Hapus data penyewa
    public function delete($username)
    {
        $sql = $this->prepareQuery("DELETE FROM penyewa WHERE user_plg066 = ?");
        $sql->bind_param("s", $username);

        $hasil = $sql->execute();
        $sql->close();

        return $hasil;
    }
}