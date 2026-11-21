
<?php

class Login_C extends Controller
{
    // ==========================================
    // MENAMPILKAN HALAMAN LOGIN ADMIN
    // ==========================================
    public function index()
    {
        $this->session->unset_userdata('userplg');

        $data['psn'] = $this->session->userdata('pesan');

        $this->session->unset_userdata('pesan');

        $this->load->view('login', $data);
    }

    // ==========================================
    // MENAMPILKAN HALAMAN LOGIN PENYEWA
    // ==========================================
    public function penyewa()
    {
        $this->session->set_userdata('userplg', 'penyewa');

        $data['psn'] = $this->session->userdata('pesan');

        $this->session->unset_userdata('pesan');

        $this->load->view('login', $data);
    }

    // ==========================================
    // MEMERIKSA PASSWORD
    // ==========================================
    private function cekPassword($password, $passwordDB)
    {
        if (!is_string($passwordDB) || $passwordDB === '') {
            return false;
        }

        // Password berbentuk hash
        if (password_verify($password, $passwordDB)) {
            return true;
        }

        // Password berbentuk teks biasa
        return hash_equals((string)$passwordDB, (string)$password);
    }

    // ==========================================
    // PROSES LOGIN
    // ==========================================
    public function Ceklogin()
    {
        $email = trim($this->load->post('email'));
        $password = $this->load->post('password');

        // ======================================
        // VALIDASI INPUT
        // ======================================
        if ($email === '' || $password === '') {

            $this->session->set_userdata(
                'pesan',
                'Email dan password wajib diisi!'
            );

            redirect(
                $this->session->userdata('userplg') == 'penyewa'
                ? 'Login_C/penyewa'
                : 'Login_C/index'
            );

            exit();
        }

        // ======================================
        // LOGIN PENYEWA
        // ======================================
        if ($this->session->userdata('userplg') == 'penyewa') {

            $model = $this->load->model('LoginPlg_M');

            $datauser = $model->DataPlg($email);

            if (
                $datauser &&
                $this->cekPassword(
                    $password,
                    $datauser['sandi066']
                )
            ) {

                $this->session->unset_userdata('emailuser');

                $this->session->set_userdata('EmailPlg', $email);

                $this->session->set_userdata(
                    'NmPlg',
                    $datauser['nm_lngkp066']
                );

                $this->session->unset_userdata('userplg');

                $this->session->set_userdata(
                    'pesan',
                    'Login penyewa berhasil!'
                );

                redirect('Shopping/index');

                exit();
            }

            $this->session->set_userdata(
                'pesan',
                'Login penyewa gagal! Periksa email dan password.'
            );

            redirect('Login_C/penyewa');

            exit();
        }

        // ======================================
        // LOGIN ADMIN
        // ======================================
        $model = $this->load->model('Login_M');

        $dataadmin = $model->ambildata($email);

        if ($dataadmin) {

            $passwordDB = $dataadmin['password'];

            $status = strtolower(
                trim($dataadmin['status_akun'])
            );

            $cocok = $this->cekPassword(
                $password,
                $passwordDB
            );

            if ($cocok && $status === 'aktif') {

                // Hapus session penyewa
                $this->session->unset_userdata('EmailPlg');
                $this->session->unset_userdata('NmPlg');
                $this->session->unset_userdata('userplg');

                // Simpan session admin
                $this->session->set_userdata(
                    'emailuser',
                    $dataadmin['username']
                );

                redirect('Admin_C/index');

                exit();
            }
        }

        // ======================================
        // LOGIN ADMIN GAGAL
        // ======================================
        $this->session->set_userdata(
            'pesan',
            'Gagal login! Periksa email, password, dan status akun.'
        );

        redirect('Login_C/index');

        exit();
    }

    // ==========================================
    // LOGOUT
    // ==========================================
    public function keluar()
    {
        $this->session->unset_userdata('userplg');
        $this->session->unset_userdata('EmailPlg');
        $this->session->unset_userdata('NmPlg');
        $this->session->unset_userdata('emailuser');

        $this->session->set_userdata(
            'pesan',
            'Berhasil Logout!'
        );

        redirect('Login_C/index');

        exit();
    }
}
