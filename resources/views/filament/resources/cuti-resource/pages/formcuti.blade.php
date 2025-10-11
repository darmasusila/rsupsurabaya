<x-filament-panels::page>
    <style>
        /* Variabel CSS untuk kemudahan perubahan warna dan font */
        :root {
            --border-color: #333;
            --background-color: #f9f9f9;
            --font-family: Arial, sans-serif;
            --text-color: #333;
        }

        /* Styling dasar untuk body halaman */
        body {
            font-family: var(--font-family);
            line-height: 1.6;
            background-color: #f0f2f5;
            color: var(--text-color);
            padding: 20px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Kontainer utama untuk seluruh formulir */
        .form-container {
            max-width: 800px;
            width: 100%;
            padding: 30px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        /* Header formulir, berisi tanggal, alamat, dan judul */
        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .header-left {
            font-size: 0.9em;
        }

        /* Judul utama formulir */
        .form-title {
            font-size: 1.5em;
            font-weight: bold;
            text-align: center;
            border: 2px solid var(--border-color);
            padding: 10px;
            flex-grow: 1;
            margin-left: 20px;
        }

        /* Styling untuk setiap bagian (section) dari formulir */
        .section {
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            padding: 10px;
        }

        /* Judul untuk setiap bagian */
        .section-title {
            font-size: 1.2em;
            font-weight: bold;
            margin: 0 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid var(--border-color);
        }

        /* Grup input, mengatur tata letak label dan input */
        .input-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px 20px;
            margin-bottom: 10px;
        }

        .input-group label {
            font-weight: bold;
            flex-shrink: 0;
        }

        /* Styling untuk input teks dan tanggal */
        .input-group input[type="text"],
        .input-group input[type="date"],
        textarea {
            border: none;
            border-bottom: 1px solid var(--border-color);
            padding: 2px;
            background: none;
            flex-grow: 1;
            min-width: 150px;
        }
        
        /* Styling untuk textarea */
        textarea {
            resize: vertical;
            min-height: 50px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid var(--border-color);
            padding: 5px;
        }

        /* Grup checkbox untuk jenis cuti */
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Kontainer untuk tabel agar responsif */
        .leave-table-container {
            overflow-x: auto;
        }

        /* Tabel untuk catatan cuti */
        .leave-table {
            width: 100%;
            border-collapse: collapse;
        }

        .leave-table th, .leave-table td {
            border: 1px solid var(--border-color);
            padding: 8px;
            text-align: left;
            vertical-align: top;
            font-size: 0.9em;
        }

        .leave-table th {
            background-color: var(--background-color);
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Bagian tanda tangan */
        .signature-section {
            position: relative;
        }

        .signature {
            text-align: right;
            margin-top: 20px;
        }

        .signature p {
            margin: 0;
        }

        /* Opsi persetujuan dengan checkbox */
        .approval-section .approval-options {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 10px;
        }

        /* Garis pemisah antar bagian persetujuan */
        .divider {
            border: 0;
            border-top: 2px dashed var(--border-color);
            margin: 20px 0;
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 600px) {
            .form-header {
                flex-direction: column;
                align-items: center;
            }
            
            .header-left {
                margin-bottom: 10px;
            }

            .form-title {
                margin-left: 0;
            }

            .checkbox-group {
                grid-template-columns: 1fr;
            }

            .input-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .input-group input, .input-group textarea {
                width: 100%;
            }
        }
    </style>

    @php
        $pegawai = $cuti->pegawai ?? null;
        $biodata = $pegawai->biodata ?? null;
        $date1 = new DateTime($cuti->tanggal_mulai ?? '');
        $date2 = new DateTime($cuti->tanggal_selesai ?? '');
        $interval = $date1->diff($date2)->days + 1;
    @endphp

    <div class="form-container">
        <!-- Header Formulir -->
        <header class="form-header">
            <div class="header-left">
                <p>Surabaya, {{ date('d F Y') }}</p>
                <p>Kepada Yth. Tenaga Ahli Direktur SDM RSUP Surabaya</p>
                <p>di Tempat</p>
            </div>
            <h1 class="form-title">FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</h1>
        </header>

        <!-- Bagian I: DATA PEGAWAI -->
        <section class="section">
            <h2 class="section-title">I. DATA PEGAWAI</h2>
            <div class="input-group">
                <label>Nama :</label>
                <input type="text" value="{{ $biodata->nama ?? '-' }}">
                <label>NIP :</label>
                <input type="text" value="{{ $pegawai->nip ?? '-' }}">
            </div>
            <div class="input-group">
                <label>Jabatan :</label>
                <input type="text" value="{{ $pegawai->jabatan ?? '-' }}">
                <label>Masa Kerja :</label>
                <input type="text" value="-">
            </div>
            <div class="input-group">
                <label>Unit Kerja :</label>
                <input type="text" value="{{ $pegawai->unit_kerja ?? '-' }}">
                <label>Pangkat/gol :</label>
                <input type="text" value="-">
            </div>
        </section>

        <!-- Bagian II: JENIS CUTI YANG DIAMBIL -->
        <section class="section">
            <h2 class="section-title">II. JENIS CUTI YANG DIAMBIL</h2>
            <div class="checkbox-group">
                <label><input type="checkbox" checked> 1. Cuti Tahunan</label>
                <label><input type="checkbox"> 2. Cuti Besar</label>
                <label><input type="checkbox"> 3. Cuti Sakit</label>
                <label><input type="checkbox"> 4. Cuti Melahirkan</label>
                <label><input type="checkbox"> 5. Cuti Karena Alasan Penting</label>
                <label><input type="checkbox"> 6. Cuti di Luar Tanggungan Negara</label>
            </div>
        </section>

        <!-- Bagian III: ALASAN CUTI -->
        <section class="section">
            <h2 class="section-title">III. ALASAN CUTI:</h2>
            <textarea>{{ $cuti->alasan ?? '' }}</textarea>
        </section>

        <!-- Bagian IV: LAMANYA CUTI -->
        <section class="section">
            <h2 class="section-title">IV. LAMANYA CUTI</h2>
            <div class="input-group">
                <label>Selama: {{ $interval }} hari</label>
                <label>Mulai Tanggal: </label> {{ $cuti->tanggal_mulai ?? '' }}
                <label>s/d:</label> {{ $cuti->tanggal_selesai ?? '' }}
            </div>
        </section>

        <!-- Bagian V: CATATAN CUTI -->
        <section class="section">
            <h2 class="section-title">V. CATATAN CUTI</h2>
            <div class="leave-table-container">
                <table class="leave-table">
                    <thead>
                        <tr>
                            <th>1. CUTI TAHUNAN</th>
                            <th>2. CUTI BESAR</th>
                            <th>3. CUTI SAKIT</th>
                            <th>4. CUTI MELAHIRKAN</th>
                            <th>5. CUTI KARENA ALASAN PENTING</th>
                            <th>6. CUTI DI LUAR TANGGUNGAN NEGARA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p>Tahun: N-2 (2022)</p>
                                <p>Sisa: 0</p>
                                <p>Keterangan: -</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <p>Tahun: N-1 (2023)</p>
                                <p>Sisa: 0</p>
                                <p>Keterangan: -</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <p>Tahun: N (2024)</p>
                                <p>Sisa: 12</p>
                                <p>Keterangan: -</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        
        <!-- Bagian VI: ALAMAT SELAMA MENJALANKAN CUTI -->
        <section class="section signature-section">
            <h2 class="section-title">VI. ALAMAT SELAMA MENJALANKAN CUTI</h2>
            <div class="input-group">
                <label>ALAMAT:</label>
                <textarea>Permata Cluster Callysta D5-02 Bintaro Jaya Tangerang Selatan</textarea>
                <label>TELP:</label>
                <input type="text" value="0812 887 5511">
            </div>
            <div class="signature">
                <p>Hormat Saya</p>
                <br><br>
                <p><strong>Kencana Widiastuti Carbite</strong></p>
                <p>NIP: -</p>
            </div>
        </section>

        <!-- Garis pemisah antara bagian formulir dan persetujuan -->
        <hr class="divider">

        <!-- Bagian VII: PERTIMBANGAN ATASAN LANGSUNG -->
        <section class="section approval-section">
            <h2 class="section-title">VII. PERTIMBANGAN ATASAN LANGSUNG</h2>
            <div class="approval-options">
                <label><input type="checkbox"> DISETUJUI</label>
                <label><input type="checkbox"> PERUBAHAN</label>
                <label><input type="checkbox"> DITANGGUHKAN</label>
                <label><input type="checkbox" checked> TIDAK DISETUJUI</label>
            </div>
            <div class="input-group">
                <label>Catatan ditolak / ditangguhkan:</label>
                <textarea></textarea>
            </div>
            <div class="signature">
                <p>Tenaga Ahli Manajer SDM</p>
                <br><br>
                <p><strong>Luhputu Agustinawati</strong></p>
            </div>
        </section>

        <!-- Garis pemisah -->
        <hr class="divider">

        <!-- Bagian VIII: KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI -->
        <section class="section approval-section">
            <h2 class="section-title">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI</h2>
            <div class="approval-options">
                <label><input type="checkbox"> DISETUJUI</label>
                <label><input type="checkbox"> PERUBAHAN</label>
                <label><input type="checkbox"> DITANGGUHKAN</label>
                <label><input type="checkbox" checked> TIDAK DISETUJUI</label>
            </div>
            <div class="input-group">
                <label>Catatan ditolak / ditangguhkan:</label>
                <textarea></textarea>
            </div>
            <div class="signature">
                <p>Tenaga Ahli Direktur SDM, Pelatihan dan Penelitian,</p>
                <br><br>
                <p><strong>Ir. Warno Hidayat</strong></p>
            </div>
        </section>
    </div>
</x-filament-panels::page>
