## Explanation

### Deskripsi Repository
Repository ini bertujuan untuk menghitung dua jenis nilai, yaitu **Nilai RT** dan **Nilai ST**, berdasarkan data yang terdapat pada tabel `nilai`. Nilai dihitung menggunakan Laravel dengan skema perhitungan yang telah ditentukan.
<hr>

### Struktur Tabel `Nilai`
Tabel `nilai` memiliki kolom-kolom berikut yang relevan untuk perhitungan:
-   **id**: Primary key dari tabel.
-   **nama**: Nama siswa.
-   **nisn**: Nomor Induk Siswa Nasional.
-   **materi_uji_id**: ID dari materi uji.
-   **nama_pelajaran**: Nama pelajaran terkait (digunakan untuk Nilai RT dan ST).
-   **pelajaran_id**: ID dari pelajaran (digunakan untuk Nilai RT dan ST).
-   **skor**: Skor siswa pada pelajaran tersebut (skor per mata pelajaran adalah komponen yang dijumlahkan).

Kolom lainnya yang juga ada di tabel tetapi tidak digunakan secara langsung dalam perhitungan ini meliputi:
- **id_status**, **profil_tes_id**, **id_siswa**, **soal_bank_paket_id**, **jk**, **soal_benar**, **sesi**, **id_pelaksanaan**, **nama_sekolah**, **total_soal**, **urutan**.

<hr>

### Perhitungan Nilai RT
#### Skema Perhitungan

Nilai RT dihitung menggunakan _materi_uji_id 7_, dengan langkah-langkah berikut:

1.  Identifikasi pelajaran yang akan dihitung berdasarkan nama pelajaran tertentu: ARTISTIC, CONVENTIONAL, ENTERPRISING, INVESTIGATIVE, REALISTIC, dan SOCIAL.
    
2.  Untuk setiap siswa, jumlahkan skor dari masing-masing pelajaran.
    
3.  Abaikan data dengan nama pelajaran `Pelajaran Khusus`.
    
4.  Kelompokkan hasil perhitungan berdasarkan siswa.
    

#### Alur Kerja Logika

-   Buat daftar pelajaran yang akan dihitung beserta nama alias untuk setiap pelajaran.
    
-   Iterasi melalui daftar pelajaran tersebut, kemudian tambahkan kolom perhitungan untuk masing-masing pelajaran dengan cara menjumlahkan skor berdasarkan kondisi nama pelajaran.
    
-   Tambahkan filter untuk memastikan hanya _materi_uji_id 7_ yang dihitung dan abaikan `Pelajaran Khusus`.
    
-   Kelompokkan hasil berdasarkan kolom `nama` dan `nisn` untuk setiap siswa. 

<hr>

### Perhitungan Nilai ST

#### Skema Perhitungan

Nilai ST dihitung menggunakan _materi_uji_id 4_, dengan langkah-langkah berikut:

1.  Gunakan bobot khusus untuk setiap pelajaran:
    
    -   _pelajaran_id 44_ dikali **41.67**
        
    -   _pelajaran_id 45_ dikali **29.67**
        
    -   _pelajaran_id 46_ dikali **100**
        
    -   _pelajaran_id 47_ dikali **23.81**
        
2.  Hitung total nilai dengan menjumlahkan hasil dari semua perkalian untuk setiap siswa.
    
3.  Urutkan hasil akhir berdasarkan total nilai terbesar.
    

#### Alur Kerja Logika

-   Buat daftar pelajaran yang akan dihitung beserta bobot perkalian untuk setiap pelajaran.
    
-   Iterasi melalui daftar pelajaran tersebut, tambahkan kolom perhitungan untuk masing-masing pelajaran dengan cara mengalikan skor dengan bobot.
    
-   Hitung kolom total dengan menjumlahkan semua kolom hasil perkalian.
    
-   Tambahkan filter untuk memastikan hanya _materi_uji_id 4_ yang dihitung.
    
-   Kelompokkan hasil berdasarkan `nama` dan `nisn` untuk setiap siswa, lalu urutkan berdasarkan nilai total secara menurun.

<hr>

### Output
#### Nilai RT
Hasil berupa array dengan format <br>
![enter image description here](https://www.upload.ee/image/17581064/nilaiRT.png) <br>
Dapat juga diakses langsung melalui [https://aksamedia-syahreza-be-test-additional.vercel.app/api/api/nilaiRT](https://aksamedia-syahreza-be-test-additional.vercel.app/api/api/nilaiRT)

#### Nilai ST
Hasil merupakan array dengan format: <br>
![enter image description here](https://www.upload.ee/image/17581072/nilaiST.png) <br>
Dapat juga diakses langsung melalui [https://aksamedia-syahreza-be-test-additional.vercel.app/api/api/nilaiST](https://aksamedia-syahreza-be-test-additional.vercel.app/api/api/nilaiST)
