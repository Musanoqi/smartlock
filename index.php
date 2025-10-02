<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartlock Activity Log</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Tailwind gray-100 */
        }
        /* Optional: Custom scrollbar for better appearance */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #e5e7eb; /* gray-200 */
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb {
            background: #9ca3af; /* gray-400 */
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6b7280; /* gray-500 */
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-4xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Smartlock Activity Log</h1>

        <div id="activityLogTable" class="overflow-x-auto">
            </div>

        <p id="loadingMessage" class="text-center text-gray-500 mt-4 hidden">Loading...</p>

    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const activityLogTable = document.getElementById('activityLogTable');
        const loadingMessage = document.getElementById('loadingMessage');

        function loadActivityLogs() {
            // Tidak menampilkan pesan loading setiap kali refresh agar tidak mengganggu
            // loadingMessage.classList.remove('hidden'); 

            fetch('load_logs.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.text();
                })
                .then(data => {
                    activityLogTable.innerHTML = data;
                    // loadingMessage.classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error loading activity logs:', error);
                    activityLogTable.innerHTML = '<p class="text-red-500 text-center py-4">Gagal memuat aktivitas. Silakan coba lagi. (' + error.message + ')</p>';
                    // loadingMessage.classList.add('hidden');
                });
        }

        // Muat data pertama kali saat halaman dibuka
        loadActivityLogs();

        // Atur interval untuk me-refresh data setiap 3 detik (3000 milidetik)
        setInterval(loadActivityLogs, 3000);
    });
</script>
</body>
</html>