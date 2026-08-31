  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-heading">Menu Utama</li>

      <!-- 1. Pendataan -->
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa-baru.*', 'mahasiswa.*', 'orang-tua.*') ? '' : 'collapsed' }}" data-bs-target="#pendataan-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Pendataan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="pendataan-nav" class="nav-content collapse {{ request()->routeIs('mahasiswa-baru.*', 'mahasiswa.*', 'orang-tua.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('mahasiswa-baru.index') }}" class="{{ request()->routeIs('mahasiswa-baru.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Mahasiswa Baru (MABA)</span>
            </a>
          </li>
          <li>
            <a href="{{ route('mahasiswa.index') }}" class="{{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Data Mahasiswa</span>
            </a>
          </li>
          <li>
            <a href="{{ route('orang-tua.index') }}" class="{{ request()->routeIs('orang-tua.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Data Orang Tua/Wali</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Dokumen Mahasiswa</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Kebutuhan Inklusif</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Data Alumni</span>
            </a>
          </li>
        </ul>
      </li><!-- End Pendataan Nav -->

      <!-- 2. Akademik & Penilaian -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#akademik-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-bookmark"></i><span>Akademik & Penilaian</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="akademik-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Mata Kuliah</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>KRS Mahasiswa</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Nilai Mahasiswa</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>IP & IPK</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Prestasi</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Sertifikasi</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Portofolio</span>
            </a>
          </li>
        </ul>
      </li><!-- End Akademik & Penilaian Nav -->

      <!-- 3. Asesmen Kompetensi -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#asesmen-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-clipboard-check"></i><span>Asesmen Kompetensi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="asesmen-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Instrumen Asesmen</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Bank Pertanyaan</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Pelaksanaan Asesmen</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Hasil Asesmen</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Pemetaan Kompetensi</span>
            </a>
          </li>
        </ul>
      </li><!-- End Asesmen Kompetensi Nav -->

      <!-- 4. Kelulusan -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#kelulusan-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-mortarboard"></i><span>Kelulusan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="kelulusan-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Data Kelulusan</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Wisuda</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Dokumen Lulusan</span>
            </a>
          </li>
        </ul>
      </li><!-- End Kelulusan Nav -->

      <!-- 5. Pelacakan Karir -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#karir-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-briefcase"></i><span>Pelacakan Karir</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="karir-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Tracer Study</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Status Pekerjaan</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Riwayat Karier</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Perusahaan Mitra</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Monitoring Alumni</span>
            </a>
          </li>
        </ul>
      </li><!-- End Pelacakan Karir Nav -->

      <!-- 6. Laporan -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#laporan-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark-bar-graph"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="laporan-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Laporan Mahasiswa</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Laporan Akademik</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Laporan Asesmen</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Laporan Alumni</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Laporan Tracer Study</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Export Data</span>
            </a>
          </li>
        </ul>
      </li><!-- End Laporan Nav -->

      <!-- 7. Master Data -->
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pengguna.*', 'fakultas.*', 'program-studi.*', 'tahun-akademik.*', 'semester.*') ? '' : 'collapsed' }}" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="master-nav" class="nav-content collapse {{ request()->routeIs('pengguna.*', 'fakultas.*', 'program-studi.*', 'tahun-akademik.*', 'semester.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('pengguna.index') }}" class="{{ request()->routeIs('pengguna.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Pengguna</span>
            </a>
          </li>
          <li>
            <a href="{{ route('fakultas.index') }}" class="{{ request()->routeIs('fakultas.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Fakultas</span>
            </a>
          </li>
          <li>
            <a href="{{ route('program-studi.index') }}" class="{{ request()->routeIs('program-studi.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Program Studi</span>
            </a>
          </li>
          <li>
            <a href="{{ route('tahun-akademik.index') }}" class="{{ request()->routeIs('tahun-akademik.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Tahun Akademik</span>
            </a>
          </li>
          <li>
            <a href="{{ route('semester.index') }}" class="{{ request()->routeIs('semester.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Semester</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Pengaturan Sistem</span>
            </a>
          </li>
        </ul>
      </li><!-- End Master Data Nav -->

    </ul>

  </aside><!-- End Sidebar-->