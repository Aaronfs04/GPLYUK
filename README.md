## 📋 Kebutuhan Sistem (Requirements)

Sebelum mulai, pastikan di laptop kamu sudah terinstall:

- **PHP** >= 8.2 & **Composer**
- **Node.js** >= 18 & **npm**
- **Database:** MySQL (XAMPP / Laragon) atau bisa pakai SQLite

---

## 🚀 Setup Awal (Semua orang lakuin ye)

Setelah kamu clone repo ini pertama kali, jalankan langkah-langkah berikut:

### 1. Clone & Masuk ke Folder

```bash
git clone <repo-url>
cd gplyuk_dev
```

### 2. Setup File Environment (`.env`)

```bash
# Copy file contoh .env
cp .env.example .env

# Generate security key aplikasi
php artisan key:generate
```

### 3. Konfigurasi Database di `.env`

Buka file `.env`, atur database yang kamu pakai:

> **Contoh jika pakai MySQL (XAMPP / Laragon):**
> Pastikan database dengan nama `gplyuk_db` sudah dibuat di phpMyAdmin / MySQL kamu.
>
> ```env
> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=gplyuk_db
> DB_USERNAME=root
> DB_PASSWORD=
> ```

> **Contoh jika mau simpel tanpa install MySQL (Pakai SQLite):**
>
> ```env
> DB_CONNECTION=sqlite
> ```

### 4. Install Dependencies

```bash
# 1. Install paket PHP (Backend)
composer install

# 2. Install paket JavaScript (Frontend)
npm install
```

### 5. Jalankan Migrasi Database

```bash
php artisan migrate
```

### 6. Jalankan Server Development

Kamu bisa memilih salah satu dari 2 cara ini:

- **Cara 1 (Paling Simpel - Sekaligus jalan semua):**

    ```bash
    composer run dev
    ```

    _(Perintah ini otomatis menjalankan server Laravel dan Vite React sekaligus di satu terminal)._

- **Cara 2 (Manual dengan 2 terminal terpisah):**
    - Terminal 1: `php artisan serve` _(menjalankan backend di port 8000)_
    - Terminal 2: `npm run dev` _(menjalankan frontend compiler Vite)_

Akses aplikasi di browser: 👉 **[http://localhost:8000](http://localhost:8000)**

---

## 🔄 Bagaimana Frontend & Backend Terhubung?

Proyek ini menggunakan **Inertia.js**, artinya:

1. **Tidak perlu `fetch()` atau `axios` manual** hanya untuk menampilkan data halaman.
2. **Backend mengirim data** langsung lewat fungsi `Inertia::render()`.
3. **Frontend menerima data** sebagai **`props`** biasa di komponen React.

**Contoh alurnya:**

```
[Backend (Controller)]                            [Frontend (React)]
Inertia::render('Dashboard', [          ===>      export default function Dashboard({ user }) {
    'user' => $userData                               return <h1>Halo, {user.name}</h1>;
])                                                }
```

---

## 🛠️ Panduan untuk Developer BACKEND

### Folder yang Kamu Kelola:

- `app/Http/Controllers/` : Logika bisnis dan controller aplikasi.
- `app/Models/` : Model database (Eloquent).
- `routes/web.php` : Rute halaman web & render halaman Inertia.
- `routes/api.php` : Rute REST API (jika ada kebutuhan konsumsi API eksternal via Sanctum).
- `database/migrations/` : Struktur tabel database.

### Cara Kerja Backend (Contoh Kasus):

1. **Buat Model & Migration:**
    ```bash
    php artisan make:model Produk -m
    ```
2. **Kirim Data ke Halaman React:**
   Buka `routes/web.php` atau Controller kamu:

    ```php
    use Inertia\Inertia;
    use App\Models\Produk;

    Route::get('/produk', function () {
        $daftarProduk = Produk::all();

        // Render halaman React di resources/js/Pages/Produk.jsx
        return Inertia::render('Produk', [
            'produk' => $daftarProduk
        ]);
    })->middleware(['auth']);
    ```

### Command Penting Backend:

| Perintah                                     | Kegunaan                          |
| -------------------------------------------- | --------------------------------- |
| `php artisan migrate`                        | Menjalankan migrasi database baru |
| `php artisan migrate:rollback`               | Membatalkan migrasi terakhir      |
| `php artisan make:controller NamaController` | Membuat controller baru           |
| `php artisan make:model NamaModel -m`        | Membuat model beserta migration   |
| `php artisan test`                           | Menjalankan automated test        |

---

## 🎨 Panduan untuk Developer FRONTEND

### Folder yang Kamu Kelola:

Semua kode frontend ada di dalam folder `resources/js/`:

- `resources/js/Pages/` : Tempat membuat file halaman baru (contoh: `Dashboard.jsx`, `Welcome.jsx`, atau buat folder sendiri seperti `Produk/Index.jsx`).
- `resources/js/Components/` : Komponen tombol, modal, input, dropdown yang bisa dipakai ulang.
- `resources/js/Layouts/` : Template kerangka halaman (`AuthenticatedLayout.jsx` untuk yang sudah login, `GuestLayout.jsx` untuk publik).
- `resources/css/app.css` : Konfigurasi Tailwind CSS.

### Cara Kerja Frontend (Contoh Kasus):

1. **Membuat Halaman Baru (`resources/js/Pages/Produk.jsx`):**

    ```jsx
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
    import { Head, Link } from "@inertiajs/react";

    // Data 'produk' otomatis diterima dari Controller Backend
    export default function Produk({ produk }) {
        return (
            <AuthenticatedLayout
                header={<h2 className="font-bold text-xl">Daftar Produk</h2>}
            >
                <Head title="Produk" />

                <div className="p-6">
                    {/* Tombol kembali pakai route() dari Laravel */}
                    <Link
                        href={route("dashboard")}
                        className="text-blue-500 underline"
                    >
                        ← Kembali ke Dashboard
                    </Link>

                    <div className="mt-4 grid grid-cols-3 gap-4">
                        {produk.map((item) => (
                            <div
                                key={item.id}
                                className="p-4 bg-white rounded shadow"
                            >
                                <h3 className="font-semibold">{item.nama}</h3>
                                <p className="text-gray-600">Rp {item.harga}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </AuthenticatedLayout>
        );
    }
    ```

2. **Tips untuk Frontend:**
    - Gunakan `<Link href={route('nama.route')}>` bukan tag `<a>` biasa agar halaman berpindah cepat tanpa reload browser (SPA feel).
    - Styling menggunakan utility class **Tailwind CSS** (misal: `bg-blue-500`, `flex`, `p-4`, dll).

### Command Penting Frontend:

| Perintah        | Kegunaan                                                          |
| --------------- | ----------------------------------------------------------------- |
| `npm run dev`   | Menjalankan Vite compiler (auto-reload saat simpan file)          |
| `npm run build` | Melakukan build file frontend untuk siap upload ke hosting/server |

---

## 🤝 Aturan Git & Alur Kolaborasi Tim

Agar tidak terjadi tabrakan kode (conflict) antar anggota tim:

1. **Selalu update branch `Staging` sebelum mulai coding:**

    ```bash
    git checkout Staging
    git pull origin Staging
    ```

2. **Buat branch baru untuk tugas kamu:**
    - Untuk fitur baru: `feature/nama-fitur`
    - Untuk fix bug: `fix/nama-bug`

    ```bash
    git checkout -b feature-namamu
    ```

3. **Commit dan push branch kamu:**

    ```bash
    git add .
    git commit -m "feat: membuat halaman dan card produk"
    git push origin feature/halaman-produk
    ```

4. **Buat Pull Request (PR):**
   - Buka GitHub repository.
   - Buat PR dari branch kamu menuju ke branch **`Staging`**.
   - Tunggu GitHub Actions CI selesai memeriksa kode (centang hijau) sebelum di-merge.
   - **Otomatis dicek oleh CI:**
     - **Frontend:** Instalasi dependency (`npm ci`) dan uji kompilasi asset (`npm run build`).
     - **Backend:** Instalasi dependency (`composer install`), migrasi database, dan pengujian unit/feature (`php artisan test`).
