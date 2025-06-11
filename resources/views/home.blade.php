<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PPDB 2025 - SMK Tamansiswa 2 Jakarta</title>
  <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/gaya.css">
</head>

<body>
  <!-- Tombol Login -->
  <div class="top-right">
    <a href="{{ route('login') }}" class="btn btn-login">Masuk Akun</a>
  </div>

  <!-- Konten Utama -->
  <div class="content">
    <img src="{{ asset('img/logo.png') }}" alt="Logo SMK Tamansiswa 2" class="logo">
    <h1>PPDB 2025</h1>
    <h2>SMK Tamansiswa 2 Jakarta</h2>
    <a href="{{ route('register') }}" class="btn btn-daftar">Daftar Sekarang</a>
    <button class="btn btn-outline-light mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="padding: 10px 28px; border-radius: 50px; font-size: 1rem; animation: fadeIn 2.2s ease-in;">Informasi</button>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: black;">PPDB 2025 - SMK Tamansiswa 2</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="color: black;">
          <h5>Informasi</h5>
          <p>
            Penerimaan Peserta Didik Baru (PPDB) 2025 SMK Tamansiswa 2 Jakarta telah dibuka! 
          </p>
          <p>
            Kami mengundang calon siswa terbaik untuk bergabung dan mengembangkan potensi di lingkungan belajar yang modern, disiplin, dan penuh inovasi. 
          </p>
          <p>  
            Tersedia berbagai program keahlian yang relevan dengan dunia industri, didukung fasilitas lengkap dan tenaga pendidik profesional. Kompetensi Keahlian di SMK Tamansiswa 2 Yaitu :
            <ol>
              <li>TITL - Teknik Instalasi Tenaga Listrik</li>
              <li>TP - Teknik Pemesinan</li>
              <li>TKR - Teknik Kendaraan Ringan</li>
              <li>TKJ - Teknik Komputer Jaringan</li>
              <li>RPL - Rekayasa Perangkat Lunak</li>
              <li>TBSM- Teknik Bisnis Sepeda Motor</li>
            </ol>
          </p>
          <p>
            <b>Segera daftarkan diri Anda dengan klik <a href="{{ route('register') }}">DAFTAR SEKARANG</a>, dan pantau Status Penerimaan dengan <a href="{{ route('login') }}">LOGIN/MASUK</a>.</b>
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>