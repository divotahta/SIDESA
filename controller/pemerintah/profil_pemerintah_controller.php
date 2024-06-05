<?php
include_once 'model/user_model.php';

class profilPemerintahController
{
    static function profil()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . 'login?auth=false');
            exit;
        } elseif ($_SESSION['user']['role'] !== 'pemerintah') {
            // Arahkan ke dashboard berdasarkan role
            if ($_SESSION['user']['role'] == 'admin') {
                header('Location: ' . BASEURL . 'admin/dashboard');
            } elseif ($_SESSION['user']['role'] == 'masyarakat') {
                header('Location: ' . BASEURL . 'masyarakat/dashboard');
            } else {
                header('Location: ' . BASEURL . 'login?auth=false');
            }
            exit;
        } else {
            view('pemerintah/dashboard/layout', ['url' => 'profil', 'user' => $_SESSION['user']]);
        }
    }
    static function viewUbahProfil()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'pemerintah') {
            header('Location: ' . BASEURL . 'login?auth=false');
            exit;
        } else {
            view('pemerintah/dashboard/layout', ['url' => 'view/pemerintah/crudprofil/edit', 'user' => $_SESSION['user']]);
        }
    }
    static function editProfil()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'pemerintah') {
            header('Location: ' . BASEURL . 'login?auth=false');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
            $id_user = $_GET['id'];
            $nama = $_POST['name'];
            $email = $_POST['email'];
            $currentUserId = $_GET['id']; // atau cara lain untuk mendapatkan ID user saat ini

            if (User::checkEmailExists($email, $currentUserId)) {
                header('Location: ' . BASEURL . 'pemerintah/profil?edit=emailused');
                exit;
            }

            $nomor_hp = $_POST['nomor_hp'];
            $avatar = $_FILES['avatar'] ?? null;
            // var_dump($_POST);
            // die();

            if ($avatar && $avatar['error'] == 0) {
                $fileTmpPath = $avatar['tmp_name'];
                $fileName = $avatar['name'];
                $fileSize = $avatar['size'];
                $fileType = $avatar['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                if (in_array($fileExtension, ['png', 'jpg', 'jpeg'])) {
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    $uploadFileDir = './src/foto/';
                    $dest_path = $uploadFileDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        User::updateProfil($id_user, $nama, $email, $nomor_hp, $dest_path);
                        // Perbarui data sesi
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        $_SESSION['user']['name'] = $nama;
                        $_SESSION['user']['email'] = $email;
                        $_SESSION['user']['nomor_hp'] = $nomor_hp;
                        $_SESSION['user']['avatar'] = $dest_path;
                        header('Location: ' . BASEURL . 'pemerintah/profil?edit=success');
                    } else {
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        $_SESSION['user']['name'] = $nama;
                        $_SESSION['user']['email'] = $email;
                        $_SESSION['user']['nomor_hp'] = $nomor_hp;
                        error_log("Failed to move file to $dest_path");
                        header('Location: ' . BASEURL . 'pemerintah/profil?edit=error');
                    }
                } else {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['user']['name'] = $nama;
                    $_SESSION['user']['email'] = $email;
                    $_SESSION['user']['nomor_hp'] = $nomor_hp;
                    header('Location: ' . BASEURL . 'pemerintah/profil?edit=invalidtype');
                }
            } else {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user']['name'] = $nama;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['nomor_hp'] = $nomor_hp;
                // Update profil tanpa mengubah avatar
                User::updateProfil($id_user, $nama, $email, $nomor_hp, $_SESSION['user']['avatar']);
                header('Location: ' . BASEURL . 'pemerintah/profil?edit=success');
            }
        } else {
            header('Location: ' . BASEURL . 'pemerintah/profil?edit=error');
        }
    }
}
