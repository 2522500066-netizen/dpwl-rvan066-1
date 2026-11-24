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
        $hasil = false;
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
            $hasil = $sewa->simpan($data_sewa);
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
        if ($hasil !== false || $dtpilih !== false) {
            echo "<script>
                alert('Mobil berhasil dimasukkan ke keranjang! Kode Sewa: " . $kode . "');
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

    public function keranjang()
    {
        $email = $this->session->userdata('EmailPlg');
        if (empty($email)) {
            echo "<script>
                alert('Silakan login sebagai penyewa terlebih dahulu!');
                window.location.href = '" . base_url('?url=Login_C/penyewa') . "';
            </script>";
            exit;
        }

        $sewa = $this->load->model('m_shop/Sewa_M');
        $data['EmPlg']         = $email;
        $data['NmPlg']         = $this->session->userdata('NmPlg');
        $data['dtkeranjang']   = $sewa->DataKeranjang($email);
        $data['datakeranjang'] = $sewa->DtKeranjang($email);
        $data['pesan']         = $this->session->set_flashdata('pesan');

        $this->load->view('layoutshop/headershop', $data);
        $this->load->view('layoutshop/menushop');
        $this->load->view('v_master_shop/keranjang_view', $data);
        $this->load->view('layoutshop/footershop');
    }

    public function hapus($parameter)
    {
        $data = explode('|', $parameter);
        $no_plat   = rawurldecode($data[0]);
        $kode_sewa = $data[1];
        $mobil = $this->load->model('m_shop/Sewa_M');
        $hapus = $mobil->HapusDtKeranjang($no_plat, $kode_sewa);
        if ($hapus) {
            echo "<script>alert('Data mobil dikeranjang berhasil dihapus!');
            window.location.href = '" . base_url('Sewa_C/keranjang') . "';
            </script>";
        } else {
            echo "<script>alert('Data mobil dikeranjang gagal dihapus!');window.history.back();</script>";
        }
    }

    public function updatekeranjang()
    {
        $kode_sewa   = $_POST['kode_sewa'] ?? '';
        $tgl_mulai   = $_POST['tgl_mulai'] ?? '';
        $tgl_selesai = $_POST['tgl_selesai'] ?? '';
        $wkt_ambil   = $_POST['wkt_ambil'] ?? '';

        // Validasi format tanggal
        $mulai   = DateTime::createFromFormat('Y-m-d', $tgl_mulai);
        $selesai = DateTime::createFromFormat('Y-m-d', $tgl_selesai);

        // Hitung lama sewa berdasarkan selisih tanggal
        $n_hari = $mulai->diff($selesai)->days;

        // Jika tanggal sama, dianggap menyewa minimal 1 hari
        if ($n_hari < 1) {
            $n_hari = 1;
        }

        // Ubah format datetime-local menjadi format MySQL
        $wkt_ambil = str_replace('T', ' ', $wkt_ambil);

        $model = $this->load->model('m_shop/Sewa_M');
        $data = [
            'kode_sewa'   => $kode_sewa,
            'tgl_mulai'   => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'wkt_ambil'   => $wkt_ambil,
            'n_hari'      => $n_hari
        ];

        $hasil = $model->updatekeranjang($data);
        if ($hasil) {
            $this->session->set_flashdata('pesan', 'Keranjang berhasil diperbarui...');
        } else {
            $this->session->set_flashdata('pesan', 'Keranjang gagal diperbarui...');
        }
        redirect('Sewa_C/keranjang');
    }

    public function checkout($kode_sewa)
    {
        $model = $this->load->model('m_shop/Sewa_M');
        $dt['dtcheckout'] = $model->datacheckout($kode_sewa);
        $sewa = $dt['dtcheckout'][0];
        $dt['kode_sewa']   = $sewa['kode_sewa'];
        $dt['tgl_mulai']   = $sewa['tgl_mulai'];
        $dt['tgl_selesai'] = $sewa['tgl_selesai'];
        $dt['wkt_ambil']   = $sewa['wkt_ambil'];
        $total_sewa = 0;
        foreach ($dt['dtcheckout'] as $m) {
            $subtotal = $m['hrg_sewa'] * $m['n_hari'];
            $total_sewa += $subtotal;
        }
        $cekdata = $this->load->model('m_shop/Sewa_M');
        $dt['total_sewa']  = $total_sewa;
        $dt['dp']          = $total_sewa * 0.30;
        $dt['sisa']        = $total_sewa - $dt['dp'];
        $dt['EmPlg']       = $this->session->userdata('EmailPlg');
        $dt['NmPlg']       = $this->session->userdata('NmPlg');
        $dt['dtkeranjang'] = $cekdata->DataKeranjang($this->session->userdata('EmailPlg'));
        $this->load->view('layoutshop/headershop', $dt);
        $this->load->view('layoutshop/menushop');
        $this->load->view('v_master_shop/checkout_view', $dt);
        $this->load->view('layoutshop/footershop');
    }

    public function ajukantransaksi($kode_sewa)
    {
        $model = $this->load->model('m_shop/Sewa_M');
        $hasil = $model->ajukantransaksi($kode_sewa);
        if ($hasil) {
            echo "<script>
                alert('Transaksi berhasil diajukan. Silakan lanjutkan pembayaran DP 30% dari total Pembayaran...');
                window.location.href = '" . base_url('Shopping') . "';
            </script>";
        } else {
            echo "<script>
                alert('Pengajuan transaksi gagal.');
                window.location.href = '" . base_url('Sewa_C/keranjang') . "';
            </script>";
        }
    }
}