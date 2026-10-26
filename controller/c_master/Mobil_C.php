<?php

class Mobil_C extends Controller
{
    // Menampilkan data mobil
    public function index()
    {
        $email = $this->session->userdata('emailuser') ?? 'admin@';
        $info['nm_user'] = explode('@', $email)[0];

        $cekdata = $this->load->model('m_master/Mobil_M');
        $dt['dtmobil'] = $cekdata->datamobil();

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/mobilview', $dt);
        $this->load->view('layout/footer');
    }

    // Menampilkan form tambah mobil
    public function create_mobil()
    {
        $email = $this->session->userdata('emailuser') ?? 'admin@';
        $info['nm_user'] = explode('@', $email)[0];

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/create_mobilview');
        $this->load->view('layout/footer');
    }

    // Menyimpan data mobil
    public function simpan()
    {
        $mobil = $this->load->model('m_master/Mobil_M');

        $plat = $this->load->post('no_plat');

        // Memeriksa nomor plat
        if ($mobil->cekplat($plat)) {
            echo "<script>
                alert('Nomor plat sudah terdaftar!');
                window.history.back();
            </script>";
            exit;
        }

        // Menentukan folder penyimpanan foto
        $folder = dirname(__DIR__, 2) . '/img/';

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // Upload ketiga foto mobil
        $namaFiledepan = $this->uploadFoto(
            'ft_depan',
            $folder,
            'Depan_' . $plat
        );

        $namaFileblkg = $this->uploadFoto(
            'ft_blkg',
            $folder,
            'Belakang_' . $plat
        );

        $namaFileinterior = $this->uploadFoto(
            'ft_interior',
            $folder,
            'Interior_' . $plat
        );

        // Jika upload gagal, hentikan proses
        if (
            $namaFiledepan === false ||
            $namaFileblkg === false ||
            $namaFileinterior === false
        ) {
            echo "<script>
                alert('Upload foto gagal! Gunakan JPG/PNG maksimal 2 MB per foto.');
                window.history.back();
            </script>";
            exit;
        }

        // Data yang akan disimpan ke database
        $data = [
            'no_plat'      => $plat,
            'nm_mobil'     => $this->load->post('nm_mobil'),
            'nkursi'       => $this->load->post('nkursi'),
            'nbagasi'      => $this->load->post('nbagasi'),
            'jns_mobil'    => $this->load->post('jns_mobil'),
            'transmisi'    => $this->load->post('transmisi'),
            'thn_buat'     => $this->load->post('thn_buat'),
            'ft_depan'     => $namaFiledepan,
            'ft_blkg'      => $namaFileblkg,
            'ft_interior'  => $namaFileinterior,
            'hrg_hari'     => $this->load->post('hrg_hari'),
            'cttn_unit'    => $this->load->post('cttn_unit'),
            'status_unit'  => $this->load->post('status_unit')
        ];

        // Memanggil model untuk menyimpan data
        $simpan = $mobil->simpan($data);

        if ($simpan) {
            echo "<script>
                alert('Data mobil berhasil disimpan!');
                window.location.href = '" .
                base_url('mobil_C/index') . "';
            </script>";
        } else {
            echo "<script>
                alert('Data mobil gagal disimpan!');
                window.history.back();
            </script>";
        }
    }

    // Fungsi untuk upload foto mobil
    private function uploadFoto($field, $folder, $namaDasar)
    {
        // Jika foto tidak dipilih, gunakan nama dasar
        if (
            !isset($_FILES[$field]) ||
            $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE
        ) {
            return $namaDasar;
        }

        $file = $_FILES[$field];

        // Periksa apakah upload berhasil
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Maksimal ukuran foto 2 MB
        if ($file['size'] > 2 * 1024 * 1024) {
            return false;
        }

        // Pastikan file benar-benar berupa gambar
        $infoGambar = getimagesize($file['tmp_name']);

        if ($infoGambar === false) {
            return false;
        }

        // Format gambar yang diperbolehkan
        $ekstensi = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png'
        ];

        $mime = $infoGambar['mime'];

        if (!isset($ekstensi[$mime])) {
            return false;
        }

        // Amankan nama file
        $namaAman = preg_replace(
            '/[^A-Za-z0-9_-]/',
            '_',
            $namaDasar
        );

        $namaFile = $namaAman . '.' . $ekstensi[$mime];
        $tujuan = $folder . $namaFile;

        // Pindahkan foto ke folder img
        if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
            return false;
        }

        return $namaFile;
    }
}