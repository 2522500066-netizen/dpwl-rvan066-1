<?php

class Sewa_C extends Controller
{
    public function simpan($no_plat = null)
    {
        // 1. Cek sesi login penyewa
        $email = $this->session->userdata('EmailPlg');
        if (empty($email)) {
            echo "<script>
                alert('Silakan login sebagai penyewa terlebih dahulu!');
                window.location.href = '" . base_url('?url=Login_C/penyewa') . "';
            </script>";
            exit;
        }

        // 2. Ambil & decode no_plat dari URL
        $no_plat = rawurldecode((string) $no_plat);

        // 3. Load model Sewa_M
        $sewa = $this->load->model('m_shop/Sewa_M');

        // 4. Cek apakah sudah ada transaksi dengan status 'Keranjang'
        $kode = $sewa->CekTransaksi($email);
        if (!$kode) {
            $kode = $sewa->buat_kode_sewa();
            // HEADER: Tabel sewa
            $data_sewa = [
                'kode_sewa'   => $kode,
                'tgl_mulai'   => date('Y-m-d'),
                'tgl_selesai' => date('Y-m-d'),
                'status_sewa' => 'Keranjang',
                'user_plg'    => $email
            ];
            $sewa->simpan($data_sewa);
        }

        // 5. Cek keberadaan data mobil di keranjang
        $cekdata = $sewa->CekDataPilih($kode, $no_plat);
        if (!$cekdata) {
            // Data detail
            $hrgmobil = $this->load->model('m_master/Mobil_M');
            $ambilhrg = $hrgmobil->detailmobil($no_plat);

            $data_pilih = [
                'kode_sewa' => $kode,
                'no_plat'   => $no_plat,
                'hrg_sewa'  => $ambilhrg['hrg_hari'] ?? 0,
                'n_hari'    => 0
            ];
            $dtpilih = $sewa->simpandetail($data_pilih);
        } else {
            echo "<script>
                alert('Mobil Sudah dipilih..!');
                window.location.href = '" . base_url('?url=Shopping/index') . "';
            </script>";
            exit;
        }

        // 6. Notifikasi hasil penyimpanan detail
        if ($dtpilih !== false) {
            echo "<script>
                alert('Mobil berhasil dimasukkan ke keranjang!');
                window.location.href = '" . base_url('?url=Shopping/index') . "';
            </script>";
            exit;
        } else {
            echo "<script>
                alert('Gagal memasukkan mobil ke keranjang!');
                window.location.href = '" . base_url('?url=Shopping/index') . "';
            </script>";
            exit;
        }
    }
}