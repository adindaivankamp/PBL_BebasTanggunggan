<?php

class Redirect
{
    public static function RedirectAdmin($role)
    {
        $redir = "unknown.php";

        switch ($role) {
                // admin prodi
                // perpus
                // admin skripsi
                // teknisi
                // maintenance

            case "teknisi":
                $redir = "beranda_admin_akademik.php";
                break;
            case "perpus":
                $redir = "beranda_admin_perpustakaan.php";
                break;
            case "admin skripsi":
                $redir = "beranda_admin_skripsi.php";
                break;
            case "admin prodi":
                $redir = "beranda_admin_prodi.php";
                break;
            case "maintenance":
                $redir = "maintain_admin.php";
                break;
            default:
                $redir = "unknown.php";
                break;
        }
        header("Location: $redir"); // Redirect ke halaman admin jika sudah login
        exit();
    }
}
