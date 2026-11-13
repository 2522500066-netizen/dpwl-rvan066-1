<?php
class Login_C extends Controller
{
    public function index()
    {
        // Hapus penanda login penyewa jika masuk ke login admin biasa
        if (method_exists($this->session, 'unset_userdata')) {
            $this->session->unset_userdata('userplg');
        }

        $psn = '';
        if (method_exists($this->session, 'userdata')) {
            $psn = $this->session->userdata('pesan');
            $this->session->unset_userdata('pesan');
        }
        $data['psn'] = $psn;
        $this->load->view('login', $data);
    }

    public function penyewa()
    {
        $this->session->set_userdata('userplg', 'penyewa');

        $psn = '';
        if (method_exists($this->session, 'userdata')) {
            $psn = $this->session->userdata('pesan');
            $this->session->unset_userdata('pesan');
        }
        $data['psn'] = $psn;
        $this->load->view('login', $data);
    }

    public function CekLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('Login_C/index');
            return;
        }

        // Tangkap semua kemungkinan nama input dari form login.php
        $email = '';
        if (isset($_POST['email'])) {
            $email = trim($_POST['email']);
        } elseif (isset($_POST['username'])) {
            $email = trim($_POST['username']);
        } elseif (isset($_POST['user_plg066'])) {
            $email = trim($_POST['user_plg066']);
        }

        $password = '';
        if (isset($_POST['pass'])) {
            $password = trim($_POST['pass']);
        } elseif (isset($_POST['password'])) {
            $password = trim($_POST['password']);
        } elseif (isset($_POST['sandi066'])) {
            $password = trim($_POST['sandi066']);
        }

        // 1. CEK LOGIN KHUSUS PENYEWA (PELANGGAN)
        if (!empty($this->session->userdata('userplg'))) {
            if (file_exists(dirname(__DIR__) . '/model/LoginPlg_M.php')) {
                $cekdata = $this->load->model('LoginPlg_M');
            } else {
                $cekdata = $this->load->model('m_master/LoginPlg_M');
            }

            $datauser = $cekdata->DataPlg($email);

            if ($datauser && (password_verify($password, $datauser['sandi066']) || $password == $datauser['sandi066'])) {
                $this->session->set_userdata('EmailPlg', $email);
                $this->session->set_userdata('NmPlg', $datauser['nm_lngkp066']);
                $this->session->set_userdata('pesan', 'Login berhasil...');
                redirect('Shopping/index');
            } else {
                $this->session->set_userdata('pesan', 'Gagal: Silahkan cek user, password Anda...');
                redirect('Login_C/penyewa');
            }
            exit();
        }

        // 2. CEK LOGIN ADMIN
        if ($email == 'revandisastra@gmail.com' && $password == '12345') {
            $this->session->set_userdata('emailuser', $email);
            $this->session->set_userdata('nm_user', 'Revan - Aktif');
            $this->session->set_userdata('status_akun', 'aktif');
            $this->session->set_userdata('pesan', '');
            redirect('Admin_C/index');
            return;
        }

        require_once dirname(__DIR__) . '/model/Login_M.php';
        $loginModel = new Login_M();
        $datauser = $loginModel->ambildata($email);

        if ($datauser && $password == $datauser['password'] && $datauser['status'] == 'aktif') {
            $this->session->set_userdata('emailuser', $email);
            $this->session->set_userdata('nm_user', 'Revan - Aktif');
            $this->session->set_userdata('status_akun', 'aktif');
            redirect('Admin_C/index');
        } else {
            $this->session->set_userdata('pesan', 'Gagal: Silahkan cek email, password, atau status akun Anda...');
            redirect('Login_C/index');
        }
    }

    public function keluar()
    {
        $this->session->unset_userdata('userplg');
        $this->session->unset_userdata('EmailPlg');
        $this->session->unset_userdata('NmPlg');
        $this->session->set_userdata('pesan', 'Berhasil Logout');
        redirect('Shopping/index');
        exit();
    }
}