
<?php

class Mobil_C extends Controller
{
    // ==========================================
    // MENGAMBIL NAMA USER
    // ==========================================
    private function info_user()
    {
        $email = $this->session->userdata('emailuser') ?? '';

        $info['nm_user'] = !empty($email)
            ? explode('@', $email)[0]
            : 'Admin';

        return $info;
    }

    // ==========================================
    // MENAMPILKAN DATA MOBIL
    // ==========================================
    public function index()
    {
        $mobil = $this->load->model('m_master/Mobil_M');

        $dt['dtmobil'] = $mobil->datamobil();

        $info = $this->info_user();

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/mobilview', $dt);
        $this->load->view('layout/footer');
    }

    // ==========================================
    // FORM TAMBAH MOBIL
    // ==========================================
    public function create_mobil()
    {
        $info = $this->info_user();

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/create_mobilview');
        $this->load->view('layout/footer');
    }

    // ==========================================
    // MEMBUAT FOLDER FOTO
    // ==========================================
    private function folder_foto()
    {
        $dir = dirname(__DIR__, 2) . '/img/';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    // ==========================================
    // UPLOAD FOTO
    // ==========================================
    private function upload_foto($nama_input, $nama_file)
    {
        if (
            !isset($_FILES[$nama_input]) ||
            empty($_FILES[$nama_input]['name'])
        ) {
            return '';
        }

        if ($_FILES[$nama_input]['error'] !== UPLOAD_ERR_OK) {
            return '';
        }

        $ext = strtolower(
            pathinfo($_FILES[$nama_input]['name'], PATHINFO_EXTENSION)
        );

        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            return '';
        }

        $nama_file = $nama_file . '.' . $ext;
        $tujuan = $this->folder_foto() . $nama_file;

        if (move_uploaded_file(
            $_FILES[$nama_input]['tmp_name'],
            $tujuan
        )) {
            return $nama_file;
        }

        return '';
    }

    // ==========================================
    // SIMPAN DATA MOBIL
    // ==========================================
    public function simpan()
    {
        $mobil = $this->load->model('m_master/Mobil_M');

        $no_plat = trim($this->load->post('no_plat'));

        if (empty($no_plat)) {
            echo "<script>alert('Nomor plat wajib diisi!');history.back();</script>";
            return;
        }

        if ($mobil->cekplat($no_plat)) {
            echo "<script>alert('Nomor plat sudah terdaftar!');history.back();</script>";
            return;
        }

        $clean_plat = preg_replace('/[^A-Za-z0-9_-]/', '_', $no_plat);

        $data = [
            'no_plat'     => $no_plat,
            'nm_mobil'    => $this->load->post('nm_mobil'),
            'nkursi'      => (int)$this->load->post('nkursi'),
            'nbagasi'     => (int)$this->load->post('nbagasi'),
            'jns_mobil'   => $this->load->post('jns_mobil'),
            'transmisi'   => $this->load->post('transmisi'),
            'thn_buat'    => (int)$this->load->post('thn_buat'),
            'ft_depan'    => $this->upload_foto('ft_depan', 'Depan_' . $clean_plat),
            'ft_blkg'     => $this->upload_foto('ft_blkg', 'Belakang_' . $clean_plat),
            'ft_interior' => $this->upload_foto('ft_interior', 'Interior_' . $clean_plat),
            'hrg_hari'    => (float)$this->load->post('hrg_hari'),
            'cttn_unit'   => $this->load->post('cttn_unit'),
            'status_unit' => $this->load->post('status_unit')
        ];

        $hasil = $mobil->simpan($data);

        if ($hasil) {
            echo "<script>
                alert('Data mobil berhasil disimpan!');
                window.location.href = '" . base_url('?url=c_master/Mobil_C') . "';
            </script>";
        } else {
            echo "<script>alert('Data mobil gagal disimpan!');history.back();</script>";
        }
    }

    // ==========================================
    // FORM EDIT MOBIL
    // ==========================================
    public function edit($id = null)
    {
        $no_plat = $id ?? ($_GET['id'] ?? '');

        if (empty($no_plat)) {
            echo "Nomor plat mobil tidak ditemukan!";
            return;
        }

        $mobil = $this->load->model('m_master/Mobil_M');

        $dt['dtmobil'] = $mobil->get_by_id($no_plat);

        if (empty($dt['dtmobil'])) {
            echo "Data mobil tidak ditemukan!";
            return;
        }

        $info = $this->info_user();

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/update_mobilview', $dt);
        $this->load->view('layout/footer');
    }

    // ==========================================
    // UPDATE DATA MOBIL
    // ==========================================
    public function update()
    {
        $mobil = $this->load->model('m_master/Mobil_M');

        $no_plat = trim($this->load->post('no_plat'));

        $data_lama = $mobil->get_by_id($no_plat);

        if (empty($data_lama)) {
            echo "Data mobil tidak ditemukan!";
            return;
        }

        $clean_plat = preg_replace('/[^A-Za-z0-9_-]/', '_', $no_plat);

        $foto_depan = $this->upload_foto('ft_depan', 'Depan_' . $clean_plat);
        $foto_blkg = $this->upload_foto('ft_blkg', 'Belakang_' . $clean_plat);
        $foto_interior = $this->upload_foto('ft_interior', 'Interior_' . $clean_plat);

        $data = [
            'no_plat'     => $no_plat,
            'nm_mobil'    => $this->load->post('nm_mobil'),
            'nkursi'      => (int)$this->load->post('nkursi'),
            'nbagasi'     => (int)$this->load->post('nbagasi'),
            'jns_mobil'   => $this->load->post('jns_mobil'),
            'transmisi'   => $this->load->post('transmisi'),
            'thn_buat'    => (int)$this->load->post('thn_buat'),
            'ft_depan'    => $foto_depan ?: $data_lama['ft_depan'],
            'ft_blkg'     => $foto_blkg ?: $data_lama['ft_blkg'],
            'ft_interior' => $foto_interior ?: $data_lama['ft_interior'],
            'hrg_hari'    => (float)$this->load->post('hrg_hari'),
            'cttn_unit'   => $this->load->post('cttn_unit'),
            'status_unit' => $this->load->post('status_unit')
        ];

        $hasil = $mobil->update($data);

        if ($hasil) {
            echo "<script>
                alert('Data mobil berhasil diperbarui!');
                window.location.href = '" . base_url('?url=c_master/Mobil_C/index') . "';
            </script>";
        } else {
            echo "<script>alert('Data mobil gagal diperbarui!');history.back();</script>";
        }
    }

    // ==========================================
    // HAPUS DATA MOBIL
    // ==========================================
    public function delete($id = null)
    {
        $no_plat = $id ?? ($_GET['id'] ?? '');

        if (empty($no_plat)) {
            echo "Nomor plat tidak ditemukan!";
            return;
        }

        $mobil = $this->load->model('m_master/Mobil_M');

        $hasil = $mobil->delete($no_plat);

        if ($hasil) {
            echo "<script>
                alert('Data mobil berhasil dihapus!');
                window.location.href = '" . base_url('?url=c_master/Mobil_C/index') . "';
            </script>";
        } else {
            echo "<script>alert('Data mobil gagal dihapus!');history.back();</script>";
        }
    }
}
