# ERD TambakCare
## Aplikasi Monitoring Kualitas Air Tambak

![Diagram ERD TambakCare](erd_tambakcare.png)

## Penjelasan Relasi

1. **`users` → `monitoring_air` (1:N)**  
   Satu pengguna dapat memiliki banyak catatan monitoring. Setiap catatan monitoring merujuk pada satu pengguna melalui `id_user`.

2. **`tambak` → `monitoring_air` (1:N)**  
   Satu tambak dapat memiliki banyak catatan monitoring. Setiap catatan monitoring merujuk pada satu tambak melalui `id_tambak`.

3. **`standar_parameter`**  
   Menyimpan rentang nilai acuan setiap parameter kualitas air, yaitu nama parameter, nilai minimum, nilai maksimum, dan satuan. Pada rancangan ini, tabel tersebut belum memiliki foreign key langsung ke `monitoring_air`.

## Struktur Tabel

### `users`
- `id_user` — INT, Primary Key
- `nama` — VARCHAR(100)
- `username` — VARCHAR(50)
- `password_hash` — VARCHAR(255)
- `role` — ENUM('admin', 'petugas')

### `tambak`
- `id_tambak` — INT, Primary Key
- `nama_tambak` — VARCHAR(50)
- `lokasi` — VARCHAR(50)
- `luas` — DECIMAL(10,2)

### `monitoring_air`
- `id_monitoring` — INT, Primary Key
- `id_tambak` — INT, Foreign Key ke `tambak.id_tambak`
- `id_user` — INT, Foreign Key ke `users.id_user`
- `tanggal` — DATETIME
- `suhu` — DECIMAL(5,2)
- `ph` — DECIMAL(4,2)
- `salinitas` — DECIMAL(6,2)
- `oksigen_terlarut` — DECIMAL(6,2)
- `keterangan` — TEXT

### `standar_parameter`
- `id_parameter` — INT, Primary Key
- `nama_parameter` — VARCHAR(50)
- `nilai_min` — DECIMAL(8,2)
- `nilai_max` — DECIMAL(8,2)
- `satuan` — VARCHAR(10)

> Catatan: Diagram menggambarkan hubungan berdasarkan rancangan database TambakCare. Pastikan tipe data pada diagram disesuaikan dengan definisi SQL yang benar-benar digunakan dalam proyek.
