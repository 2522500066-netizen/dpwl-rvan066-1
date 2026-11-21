<?php
class Shopping extends Controller
{
    public function index()
    {
        $cekdata = $this->load->model('m_master/Mobil_M');
        $dt['dtmobil'] = $cekdata->datamobil();
        $dt['EmPlg'] = $this->session->userdata('EmailPlg');
        $dt['NmPlg'] = $this->session->userdata('NmPlg');
        $dt['psn'] = $this->session->set_flashdata('pesan');
        $cekdata = $this->load->model('m_shop/Sewa_M'); // Cari data keranjang
        $dt['jmlhkrj'] = $cekdata->DataKeranjang($this->session->userdata('EmailPlg'));
        $this->load->view('layoutshop/headershop', $dt);
        $this->load->view('layoutshop/menushop');
        $this->load->view('layoutshop/slidershop', $dt);
        $this->load->view('layoutshop/contentshop', $dt);
        $this->load->view('layoutshop/footershop');
    }

    public function detail($no_plat)
    {
        $cekdata = $this->load->model('m_master/Mobil_M');
        $dt['mobil'] = $cekdata->detailmobil($no_plat);
        $dt['EmPlg'] = $this->session->userdata('EmailPlg');
        $dt['NmPlg'] = $this->session->userdata('NmPlg');
        $cekdata = $this->load->model('m_shop/Sewa_M'); 
        $dt['jmlhkrj'] = $cekdata->DataKeranjang($this->session->userdata('EmailPlg'));
        $this->load->view('layoutshop/headershop', $dt);
        $this->load->view('layoutshop/menushop');
        $this->load->view('v_master_shop/detail_mobil_view', $dt);
        $this->load->view('layoutshop/footershop');
    }
}