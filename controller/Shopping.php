<?php
class Shopping extends Controller
{
    public function index()
    {
        $cekdata = $this->load->model('m_master/Mobil_M');
        $dt['dtmobil'] = $cekdata->datamobil();
        $dt['EmPlg']   = $this->session->userdata('EmailPlg');
        $dt['NmPlg']   = $this->session->userdata('NmPlg');

        $dt['psn']     = $this->session->userdata('pesan');
        $this->session->unset_userdata('pesan');

        $this->load->view('layoutshop/headershop', $dt);
        $this->load->view('layoutshop/menushop');
        $this->load->view('layoutshop/slidershop', $dt);
        $this->load->view('layoutshop/contentshop', $dt);
        $this->load->view('layoutshop/footershop', $dt);
    }
}