
<?php

class LoginPlg_M extends Model
{
    public function DataPlg($email)
    {
        $query = $this->db->prepare("
            SELECT *
            FROM penyewa
            WHERE user_plg066 = ?
        ");

        if (!$query) {
            die("Query gagal: " . $this->db->error);
        }

        $query->bind_param("s", $email);
        $query->execute();

        return $query->get_result()->fetch_assoc();
    }
}
