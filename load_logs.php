<?php
// Konfigurasi Database (Sama seperti log.php dan index.php sebelumnya)
$servername = "localhost"; // Ganti dengan host database Anda
$username = "root";       // Ganti dengan username database Anda
$password = "";           // Ganti dengan password database Anda
$dbname = "smartlocknew_db"; // Sesuai dengan nama database Anda

// Nama tabel log
$table_name = "aktivitas"; // Sesuai dengan nama tabel log Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("<p class='text-red-500 text-center'>Koneksi gagal: " . $conn->connect_error . "</p>");
}

// Query untuk mengambil data log
$sql = "SELECT id, status, uid, timestamp FROM " . $table_name . " ORDER BY timestamp DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='min-w-full bg-white rounded-lg overflow-hidden shadow-md border-2 border-gray-300'>";
    echo "<thead>";
    echo "<tr class='bg-green-600 text-white uppercase text-sm leading-normal'>";
    echo "<th class='py-3 px-6 text-left rounded-tl-lg'>ID</th>";
    echo "<th class='py-3 px-6 text-left'>Status</th>";
    echo "<th class='py-3 px-6 text-left'>UID Kartu</th>";
    echo "<th class='py-3 px-6 text-left rounded-tr-lg'>Waktu</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody class='text-gray-600 text-sm font-light'>";
    // Menampilkan data setiap baris
    $row_count = 0;
    while($row = $result->fetch_assoc()) {
        $row_class = ($row_count % 2 == 0) ? 'bg-white' : 'bg-gray-50'; // Baris genap putih, ganjil abu-abu terang
        echo "<tr class='" . $row_class . " border-b border-gray-200 hover:bg-blue-100'>"; // Perhatikan hover:bg-blue-100
        echo "<td class='py-3 px-6 text-left whitespace-nowrap'>" . $row["id"]. "</td>";
        echo "<td class='py-3 px-6 text-left'>" . $row["status"]. "</td>";
        echo "<td class='py-3 px-6 text-left'>" . ($row["uid"] ? $row["uid"] : "-"). "</td>";
        echo "<td class='py-3 px-6 text-left'>" . $row["timestamp"]. "</td>";
        echo "</tr>";
        $row_count++;
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p class='text-gray-600 text-center'>Tidak ada aktivitas Smartlock yang ditemukan.</p>";
}

$conn->close();
?>
