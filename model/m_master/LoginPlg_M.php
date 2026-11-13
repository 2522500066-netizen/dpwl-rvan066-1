<?php
class LoginPlg_M extends Model
{
    function DataPlg($email)
    {
        $dtadmin = $this->db->prepare("SELECT user_plg066, sandi066, nm_lngkp066 FROM penyewa WHERE user_plg066 = ?");
        $dtadmin->bind_param("s", $email);
        $dtadmin->execute();
        return $dtadmin->get_result()->fetch_assoc();
    }
}