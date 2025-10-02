<?php
// Konfigurasi Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "smartlocknew_db"; // Sesuai dengan yang ada di kode ESP32 dan log.php Anda

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Memeriksa koneksi
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan eksekusi dan tampilkan pesan error
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memastikan request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memeriksa apakah parameter 'status' ada dalam request POST
    if (isset($_POST["status"])) {
        $status = $_POST["status"];
        // Mengambil parameter 'uid'. Jika tidak ada, set string kosong.
        $uid = isset($_POST["uid"]) ? $_POST["uid"] : "";

        // Menyiapkan statement SQL untuk INSERT data
        // Kolom 'timestamp' akan otomatis terisi oleh database dengan CURRENT_TIMESTAMP
        $stmt = $conn->prepare("INSERT INTO aktivitas (status, uid) VALUES (?, ?)");

        // Memeriksa apakah persiapan statement berhasil
        if ($stmt === false) {
            echo "Error persiapan statement: " . $conn->error;
            $conn->close();
            exit();
        }

        // Mengikat parameter ke statement yang telah disiapkan
        // 'ss' berarti kedua parameter adalah string
        $stmt->bind_param("ss", $status, $uid);

        // Mengeksekusi statement
        if ($stmt->execute()) {
            echo "OK"; // Kirim respon 'OK' jika berhasil
        } else {
            // Jika eksekusi gagal, tampilkan pesan error
            echo "Error eksekusi statement: " . $stmt->error;
        }

        // Menutup statement
        $stmt->close();
    } else {
        // Jika parameter 'status' tidak ada, tampilkan pesan error
        echo "Parameter 'status' tidak ada.";
    }
} else {
    // Jika request bukan POST, tampilkan pesan error
    echo "Hanya menerima request POST.";
}

// Menutup koneksi database
$conn->close();
?>
