<?php
class Mobil_C extends Controller
{
    public function index()
    {
        $cekdata = $this->load->model('m_master/Mobil_M');
        $dt['dtmobil'] = $cekdata->datamobil();
        $info['nm_user'] = explode('@', $this->session->userdata('emailuser'))[0];
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/mobilview', $dt);
        $this->load->view('layout/footer');
    }

    public function create_mobil()
    {
        $info['nm_user'] = explode('@', $this->session->userdata('emailuser'))[0];
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/create_mobilview');
        $this->load->view('layout/footer');
    }

    public function simpan()
    {
        $mobil = $this->load->model('m_master/Mobil_M');
        $no_plat = $this->load->post('no_plat');

        if ($mobil->cekplat($no_plat)) {
            echo "<script>
                alert('Nomor plat sudah terdaftar!');
                window.history.back();
            </script>";
            exit;
        }

        // 1. Buat folder img jika belum ada
        $dir_path = dirname(__DIR__, 2) . '/img/';
        if (!file_exists($dir_path)) {
            mkdir($dir_path, 0777, true);
        }

        // 2. Bersihkan karakter spasi dari nomor plat untuk penamaan file
        $clean_plat = str_replace(' ', '_', trim($no_plat));

        // ------------------------------------------
        // FOTO DEPAN
        // ------------------------------------------
        $ft_depan = '';
        if (!empty($_FILES['ft_depan']['name'])) {
            $ext = strtolower(pathinfo($_FILES['ft_depan']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $ft_depan = 'Depan_' . $clean_plat . '.' . $ext;
                move_uploaded_file($_FILES['ft_depan']['tmp_name'], $dir_path . $ft_depan);
            }
        }

        // ------------------------------------------
        // FOTO BELAKANG
        // ------------------------------------------
        $ft_blkg = '';
        if (!empty($_FILES['ft_blkg']['name'])) {
            $ext2 = strtolower(pathinfo($_FILES['ft_blkg']['name'], PATHINFO_EXTENSION));
            if (in_array($ext2, ['jpg', 'jpeg', 'png'])) {
                $ft_blkg = 'Belakang_' . $clean_plat . '.' . $ext2;
                move_uploaded_file($_FILES['ft_blkg']['tmp_name'], $dir_path . $ft_blkg);
            }
        }

        // ------------------------------------------
        // FOTO INTERIOR
        // ------------------------------------------
        $ft_interior = '';
        if (!empty($_FILES['ft_interior']['name'])) {
            $ext3 = strtolower(pathinfo($_FILES['ft_interior']['name'], PATHINFO_EXTENSION));
            if (in_array($ext3, ['jpg', 'jpeg', 'png'])) {
                $ft_interior = 'Interior_' . $clean_plat . '.' . $ext3;
                move_uploaded_file($_FILES['ft_interior']['tmp_name'], $dir_path . $ft_interior);
            }
        }

        // ------------------------------------------
        // SANITASI DATA NUMERIK (Cegah Incorrect Integer Value Error)
        // ------------------------------------------
        $nkursi   = $this->load->post('nkursi');
        $nbagasi  = $this->load->post('nbagasi');
        $thn_buat = $this->load->post('thn_buat');
        $hrg_hari = $this->load->post('hrg_hari');

        $data = [
            'no_plat'     => $no_plat,
            'nm_mobil'    => $this->load->post('nm_mobil'),
            'nkursi'      => ($nkursi !== '' && $nkursi !== null) ? (int)$nkursi : 0,
            'nbagasi'     => ($nbagasi !== '' && $nbagasi !== null) ? (int)$nbagasi : 0,
            'jns_mobil'   => $this->load->post('jns_mobil'),
            'transmisi'   => $this->load->post('transmisi'),
            'thn_buat'    => ($thn_buat !== '' && $thn_buat !== null) ? (int)$thn_buat : 0,
            'ft_depan'    => $ft_depan,
            'ft_blkg'     => $ft_blkg,
            'ft_interior' => $ft_interior,
            'hrg_hari'   => ($hrg_hari !== '' && $hrg_hari !== null) ? (float)$hrg_hari : 0,
            'cttn_unit'   => $this->load->post('cttn_unit'),
            'status_unit' => $this->load->post('status_unit')
        ];

        $simpan = $mobil->simpan($data);

        if ($simpan) {
            echo "<script>
                alert('Data mobil berhasil disimpan!');
                window.location.href = '" . base_url('?url=c_master/Mobil_C/index') . "';
            </script>";
        } else {
            echo "<script>
                alert('Data mobil gagal disimpan!');
                window.history.back();
            </script>";
        }
    }
}