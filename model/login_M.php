<?php

class Login_M extends Model
{
    public function ambildata($email)
    {
        // Cek apakah tabel admin memiliki kolom 'email'
        $cekKolom = $this->db->query("SHOW COLUMNS FROM admin LIKE 'email'");
        $punyaEmail = ($cekKolom && $cekKolom->num_rows > 0);

        if ($punyaEmail) {
            $sql = "SELECT username, password, status_akun
                    FROM admin
                    WHERE email = ? OR username = ?
                    LIMIT 1";
            $dtadmin = $this->db->prepare($sql);

            if (!$dtadmin) {
                die("Query gagal: " . $this->db->error);
            }

            $dtadmin->bind_param("ss", $email, $email);
        } else {
            $sql = "SELECT username, password, status_akun
                    FROM admin
                    WHERE username = ?
                    LIMIT 1";
            $dtadmin = $this->db->prepare($sql);

            if (!$dtadmin) {
                die("Query gagal: " . $this->db->error);
            }

            $dtadmin->bind_param("s", $email);
        }

        $dtadmin->execute();

        $hasil = $dtadmin->get_result()->fetch_assoc();

        $dtadmin->close();

        return $hasil;
    }
}