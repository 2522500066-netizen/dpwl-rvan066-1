
<?php
class Login_M extends Model
{
    public function ambildata($email)
    {
        $sql = "SELECT username, password, status_akun
                FROM admin
                WHERE username = ?";

        $dtadmin = $this->db->prepare($sql);

        if (!$dtadmin) {
            die("Query gagal: " . $this->db->error);
        }

        $dtadmin->bind_param("s", $email);
        $dtadmin->execute();

        $hasil = $dtadmin->get_result()->fetch_assoc();

        $dtadmin->close();

        return $hasil;
    }
}
