<?php

class Penyewa_C066 extends Controller
{
    public function index()
    {
        $penyewa = $this->load->model('m_master/Penyewa_M066');
        $dt['dtpenyewa'] = $penyewa->datapenyewa();
        $info['nm_user'] = explode('@', $this->session->userdata('emailuser'))[0];

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/penyewaview066', $dt);
        $this->load->view('layout/footer');
    }

    public function create_penyewa()
    {
        $info['nm_user'] = explode('@', $this->session->userdata('emailuser'))[0];

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/create_penyewaview066');
        $this->load->view('layout/footer');
    }

    public function simpan()
    {
        $penyewaModel = $this->load->model('m_master/Penyewa_M066');

        $username = trim($_POST['user_plg066'] ?? '');
        $nik      = trim($_POST['nik066'] ?? $_POST['Nik066'] ?? '');
        $sandi    = trim($_POST['sandi066'] ?? $_POST['Sandi066'] ?? '');
        $nama     = trim($_POST['nm_lngkp066'] ?? '');
        $hp       = trim($_POST['no_hp066'] ?? '');
        $alamat   = trim($_POST['almt_lngkp066'] ?? '');

        if ($username === '' || $nik === '' || $sandi === '' || $nama === '' || $hp === '' || $alamat === '') {
            echo "<script>alert('Tolong lengkapi semua kolom teks!'); window.history.back();</script>";
            exit;
        }

        $file_ktp = !empty($_FILES['ft_ktp066']['name']) ? $_FILES['ft_ktp066'] : (!empty($_FILES['ft_ktp']['name']) ? $_FILES['ft_ktp'] : null);
        if (!$file_ktp || empty($file_ktp['name']) || $file_ktp['error'] !== UPLOAD_ERR_OK) {
            echo "<script>alert('Foto KTP wajib diunggah!'); window.history.back();</script>";
            exit;
        }

        if ($penyewaModel->cekusername($username)) {
            echo "<script>alert('Username sudah terdaftar!'); window.history.back();</script>";
            exit;
        }

        if ($penyewaModel->ceknik($nik)) {
            echo "<script>alert('NIK sudah terdaftar!'); window.history.back();</script>";
            exit;
        }

        $dir_path = dirname(__DIR__, 2) . '/img/';
        if (!file_exists($dir_path)) {
            mkdir($dir_path, 0777, true);
        }

        $clean_user = str_replace(' ', '_', $username);

        $ext_ktp = strtolower(pathinfo($file_ktp['name'], PATHINFO_EXTENSION));
        if (empty($ext_ktp)) {
            $ext_ktp = 'jpg';
        }
        $ft_ktp_nama = 'KTP_' . $clean_user . '.' . $ext_ktp;
        move_uploaded_file($file_ktp['tmp_name'], $dir_path . $ft_ktp_nama);

        $file_sim = !empty($_FILES['ft_sim_a066']['name']) ? $_FILES['ft_sim_a066'] : (!empty($_FILES['ft_sim_a']['name']) ? $_FILES['ft_sim_a'] : null);
        $ft_sim_nama = '';

        if ($file_sim && !empty($file_sim['name']) && $file_sim['error'] === UPLOAD_ERR_OK) {
            $ext_sim = strtolower(pathinfo($file_sim['name'], PATHINFO_EXTENSION));
            if (empty($ext_sim)) {
                $ext_sim = 'jpg';
            }
            $ft_sim_nama = 'SIM_' . $clean_user . '.' . $ext_sim;
            move_uploaded_file($file_sim['tmp_name'], $dir_path . $ft_sim_nama);
        }

        $data = [
            'user_plg066'   => $username,
            'sandi066'      => $sandi,
            'nik066'        => $nik,
            'nm_lngkp066'   => $nama,
            'no_hp066'      => $hp,
            'almt_lngkp066' => $alamat,
            'ft_ktp066'     => $ft_ktp_nama,
            'ft_sim_a066'   => $ft_sim_nama
        ];

        if ($penyewaModel->simpan($data)) {
            echo "<script>
                alert('Data penyewa berhasil disimpan!');
                window.location.href = '" . base_url('?url=c_master/Penyewa_C066/index') . "';
            </script>";
        } else {
            echo "<script>alert('Gagal menyimpan data penyewa!'); window.history.back();</script>";
        }
    }

    public function edit($id = null)
    {
        $id = $id ?? $_GET['id'] ?? null;
        if (!$id) {
            echo "<script>alert('ID Penyewa tidak ditemukan!'); window.history.back();</script>";
            exit;
        }

        $penyewaModel = $this->load->model('m_master/Penyewa_M066');
        $dt['penyewa'] = $penyewaModel->get_by_id($id);

        if (!$dt['penyewa']) {
            echo "<script>alert('Data penyewa tidak ditemukan!'); window.history.back();</script>";
            exit;
        }

        $info['nm_user'] = explode('@', $this->session->userdata('emailuser'))[0];

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/update_penyewaview066', $dt);
        $this->load->view('layout/footer');
    }

    public function update()
    {
        $penyewaModel = $this->load->model('m_master/Penyewa_M066');

        $username = trim($_POST['user_plg066'] ?? '');
        $nik      = trim($_POST['nik066'] ?? '');
        $sandi    = trim($_POST['sandi066'] ?? '');
        $nama     = trim($_POST['nm_lngkp066'] ?? '');
        $hp       = trim($_POST['no_hp066'] ?? '');
        $alamat   = trim($_POST['almt_lngkp066'] ?? '');

        $old_data = $penyewaModel->get_by_id($username);
        if (!$old_data) {
            echo "<script>alert('Data penyewa tidak ditemukan!'); window.history.back();</script>";
            exit;
        }

        $dir_path = dirname(__DIR__, 2) . '/img/';
        $clean_user = str_replace(' ', '_', $username);

        $ft_ktp_nama = $old_data['ft_ktp066'];
        if (!empty($_FILES['ft_ktp066']['name']) && $_FILES['ft_ktp066']['error'] === UPLOAD_ERR_OK) {
            $ext_ktp = strtolower(pathinfo($_FILES['ft_ktp066']['name'], PATHINFO_EXTENSION));
            $ft_ktp_nama = 'KTP_' . $clean_user . '.' . $ext_ktp;
            move_uploaded_file($_FILES['ft_ktp066']['tmp_name'], $dir_path . $ft_ktp_nama);
        }

        $ft_sim_nama = $old_data['ft_sim_a066'];
        if (!empty($_FILES['ft_sim_a066']['name']) && $_FILES['ft_sim_a066']['error'] === UPLOAD_ERR_OK) {
            $ext_sim = strtolower(pathinfo($_FILES['ft_sim_a066']['name'], PATHINFO_EXTENSION));
            $ft_sim_nama = 'SIM_' . $clean_user . '.' . $ext_sim;
            move_uploaded_file($_FILES['ft_sim_a066']['tmp_name'], $dir_path . $ft_sim_nama);
        }

        $data = [
            'user_plg066'   => $username,
            'sandi066'      => $sandi,
            'nik066'        => $nik,
            'nm_lngkp066'   => $nama,
            'no_hp066'      => $hp,
            'almt_lngkp066' => $alamat,
            'ft_ktp066'     => $ft_ktp_nama,
            'ft_sim_a066'   => $ft_sim_nama
        ];

        if ($penyewaModel->update($data)) {
            echo "<script>
                alert('Data penyewa berhasil diperbarui!');
                window.location.href = '" . base_url('?url=c_master/Penyewa_C066/index') . "';
            </script>";
        } else {
            echo "<script>alert('Gagal memperbarui data penyewa!'); window.history.back();</script>";
        }
    }

    public function delete($id = null)
    {
        $id = $id ?? $_GET['id'] ?? null;
        if (!$id) {
            echo "<script>alert('ID Penyewa tidak ditemukan!'); window.history.back();</script>";
            exit;
        }

        $penyewaModel = $this->load->model('m_master/Penyewa_M066');
        if ($penyewaModel->delete($id)) {
            echo "<script>
                alert('Data penyewa berhasil dihapus!');
                window.location.href = '" . base_url('?url=c_master/Penyewa_C066/index') . "';
            </script>";
        } else {
            echo "<script>alert('Gagal menghapus data penyewa!'); window.history.back();</script>";
        }
    }
}