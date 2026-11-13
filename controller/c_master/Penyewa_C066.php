
<?php

class Penyewa_C066 extends Controller
{
    // ==========================================
    // MENGAMBIL NAMA USER DARI SESSION
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
    // MENAMPILKAN DATA PENYEWA
    // ==========================================
    public function index()
    {
        $penyewa = $this->load->model('m_master/Penyewa_M066');

        $dt['dtpenyewa'] = $penyewa->datapenyewa();

        $info = $this->info_user();

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/penyewaview066', $dt);
        $this->load->view('layout/footer');
    }

    // ==========================================
    // FORM TAMBAH PENYEWA
    // ==========================================
    public function create_penyewa()
    {
        $info = $this->info_user();

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/create_penyewaview066');
        $this->load->view('layout/footer');
    }

    // ==========================================
    // SIMPAN DATA PENYEWA
    // ==========================================
    public function simpan()
    {
        $penyewaModel = $this->load->model('m_master/Penyewa_M066');

        $username = trim($_POST['user_plg066'] ?? '');
        $nik      = trim($_POST['nik066'] ?? $_POST['Nik066'] ?? '');
        $sandi    = trim($_POST['sandi066'] ?? $_POST['Sandi066'] ?? '');
        $nama     = trim($_POST['nm_lngkp066'] ?? '');
        $hp       = trim($_POST['no_hp066'] ?? '');
        $alamat   = trim($_POST['almt_lngkp066'] ?? '');

        if (
            $username === '' || $nik === '' || $sandi === '' ||
            $nama === '' || $hp === '' || $alamat === ''
        ) {
            echo "<script>
                alert('Tolong lengkapi semua kolom teks!');
                window.history.back();
            </script>";
            exit;
        }

        // FOTO KTP
        $file_ktp = !empty($_FILES['ft_ktp066']['name'])
            ? $_FILES['ft_ktp066']
            : (!empty($_FILES['ft_ktp']['name'])
                ? $_FILES['ft_ktp'] : null);

        if (
            !$file_ktp ||
            $file_ktp['error'] !== UPLOAD_ERR_OK
        ) {
            echo "<script>
                alert('Foto KTP wajib diunggah!');
                window.history.back();
            </script>";
            exit;
        }

        // CEK USERNAME
        if ($penyewaModel->cekusername($username)) {
            echo "<script>
                alert('Username sudah terdaftar!');
                window.history.back();
            </script>";
            exit;
        }

        // CEK NIK
        if ($penyewaModel->ceknik($nik)) {
            echo "<script>
                alert('NIK sudah terdaftar!');
                window.history.back();
            </script>";
            exit;
        }

        // FOLDER FOTO
        $dir_path = dirname(__DIR__, 2) . '/img/';

        if (!file_exists($dir_path)) {
            mkdir($dir_path, 0777, true);
        }

        $clean_user = str_replace(' ', '_', $username);

        // UPLOAD FOTO KTP
        $ext_ktp = strtolower(
            pathinfo($file_ktp['name'], PATHINFO_EXTENSION)
        );

        if (!in_array($ext_ktp, ['jpg', 'jpeg', 'png'])) {
            die('Format foto KTP harus JPG, JPEG, atau PNG.');
        }

        $ft_ktp_nama = 'KTP_' . $clean_user . '.' . $ext_ktp;

        if (!move_uploaded_file(
            $file_ktp['tmp_name'],
            $dir_path . $ft_ktp_nama
        )) {
            die('Gagal mengunggah foto KTP.');
        }

        // UPLOAD FOTO SIM A
        $file_sim = !empty($_FILES['ft_sim_a066']['name'])
            ? $_FILES['ft_sim_a066']
            : (!empty($_FILES['ft_sim_a']['name'])
                ? $_FILES['ft_sim_a'] : null);

        $ft_sim_nama = '';

        if ($file_sim && $file_sim['error'] === UPLOAD_ERR_OK) {
            $ext_sim = strtolower(
                pathinfo($file_sim['name'], PATHINFO_EXTENSION)
            );

            if (!in_array($ext_sim, ['jpg', 'jpeg', 'png'])) {
                die('Format foto SIM harus JPG, JPEG, atau PNG.');
            }

            $ft_sim_nama = 'SIM_' . $clean_user . '.' . $ext_sim;

            move_uploaded_file(
                $file_sim['tmp_name'],
                $dir_path . $ft_sim_nama
            );
        }

        // DATA PENYEWA
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
                window.location.href = '" .
                base_url('?url=c_master/Penyewa_C066/index') . "';
            </script>";
        } else {
            echo "<script>
                alert('Gagal menyimpan data penyewa!');
                window.history.back();
            </script>";
        }
    }

    // ==========================================
    // EDIT DATA PENYEWA
    // ==========================================
    public function edit($id = null)
    {
        $id = $id ?? $_GET['id'] ?? null;

        if (!$id) {
            echo "<script>
                alert('ID Penyewa tidak ditemukan!');
                window.history.back();
            </script>";
            exit;
        }

        $penyewaModel = $this->load->model('m_master/Penyewa_M066');

        $dt['penyewa'] = $penyewaModel->get_by_id($id);

        if (!$dt['penyewa']) {
            echo "<script>
                alert('Data penyewa tidak ditemukan!');
                window.history.back();
            </script>";
            exit;
        }

        $info = $this->info_user();

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar', $info);
        $this->load->view('v_master/update_penyewaview066', $dt);
        $this->load->view('layout/footer');
    }

    // ==========================================
    // UPDATE DATA PENYEWA
    // ==========================================
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
            echo "<script>
                alert('Data penyewa tidak ditemukan!');
                window.history.back();
            </script>";
            exit;
        }

        $dir_path = dirname(__DIR__, 2) . '/img/';

        if (!is_dir($dir_path)) {
            mkdir($dir_path, 0777, true);
        }

        $clean_user = str_replace(' ', '_', $username);

        // FOTO KTP
        $ft_ktp_nama = $old_data['ft_ktp066'];

        if (
            !empty($_FILES['ft_ktp066']['name']) &&
            $_FILES['ft_ktp066']['error'] === UPLOAD_ERR_OK
        ) {
            $ext_ktp = strtolower(
                pathinfo($_FILES['ft_ktp066']['name'], PATHINFO_EXTENSION)
            );

            if (!in_array($ext_ktp, ['jpg', 'jpeg', 'png'])) {
                die('Format foto KTP tidak valid.');
            }

            $ft_ktp_nama = 'KTP_' . $clean_user . '.' . $ext_ktp;

            move_uploaded_file(
                $_FILES['ft_ktp066']['tmp_name'],
                $dir_path . $ft_ktp_nama
            );
        }

        // FOTO SIM A
        $ft_sim_nama = $old_data['ft_sim_a066'];

        if (
            !empty($_FILES['ft_sim_a066']['name']) &&
            $_FILES['ft_sim_a066']['error'] === UPLOAD_ERR_OK
        ) {
            $ext_sim = strtolower(
                pathinfo($_FILES['ft_sim_a066']['name'], PATHINFO_EXTENSION)
            );

            if (!in_array($ext_sim, ['jpg', 'jpeg', 'png'])) {
                die('Format foto SIM tidak valid.');
            }

            $ft_sim_nama = 'SIM_' . $clean_user . '.' . $ext_sim;

            move_uploaded_file(
                $_FILES['ft_sim_a066']['tmp_name'],
                $dir_path . $ft_sim_nama
            );
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
                window.location.href = '" .
                base_url('?url=c_master/Penyewa_C066/index') . "';
            </script>";
        } else {
            echo "<script>
                alert('Gagal memperbarui data penyewa!');
                window.history.back();
            </script>";
        }
    }

    // ==========================================
    // HAPUS DATA PENYEWA
    // ==========================================
    public function delete($id = null)
    {
        $id = $id ?? $_GET['id'] ?? null;

        if (!$id) {
            echo "<script>
                alert('ID Penyewa tidak ditemukan!');
                window.history.back();
            </script>";
            exit;
        }

        $penyewaModel = $this->load->model('m_master/Penyewa_M066');

        if ($penyewaModel->delete($id)) {
            echo "<script>
                alert('Data penyewa berhasil dihapus!');
                window.location.href = '" .
                base_url('?url=c_master/Penyewa_C066/index') . "';
            </script>";
        } else {
            echo "<script>
                alert('Gagal menghapus data penyewa!');
                window.history.back();
            </script>";
        }
    }
}
