# Analisis dan Penjelasan Arsitektur Aplikasi Ticketing

**Subtitle: Demo, Alur Logika (MVC), dan Best Practice**

---

## 1. Demo Aplikasi: Alur Admin (Kelola Event)

Alur kerja admin untuk mengelola event mengikuti pola arsitektur yang umum dan kokoh, menggunakan resource controller untuk operasi CRUD (Create, Read, Update, Delete).

- **Route (`routes/web.php`):**
  - Sebuah *resource route* didefinisikan untuk event di dalam grup route admin, yang secara otomatis memetakan aksi CRUD ke metode di `EventController`.
  - Route ini dilindungi oleh middleware `admin` untuk memastikan hanya admin yang dapat mengaksesnya.
  ```php
  Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
      Route::resource('event', App\Http\Controllers\Admin\EventController::class);
  });
  ```

- **Controller (`app/Http/Controllers/Admin/EventController.php`):**
  - Controller ini menangani semua logika bisnis untuk manajemen event:
    - `index()`: Menampilkan daftar semua event.
    - `create()`: Menampilkan form untuk membuat event baru.
    - `store()`: Memvalidasi dan menyimpan event baru ke database.
    - `edit()`: Menampilkan form untuk mengedit event yang ada.
    - `update()`: Memvalidasi dan memperbarui event yang ada di database.
    - `destroy()`: Menghapus event dari database.

- **Views (`resources/views/admin/event/`):**
  - Setiap metode di controller mengembalikan view Blade yang sesuai untuk berinteraksi dengan admin.

---

## 2. Penjelasan Alur Logika (MVC)

### A. Route Menangani Request Pembelian

Proses pembelian tiket dimulai saat pengguna mengirimkan request ke route yang telah ditentukan.

- **Route (`routes/web.php`):**
  - Sebuah route `POST` didefinisikan untuk menangani permintaan pembelian tiket untuk event tertentu.
  - Route ini menangkap ID event dari URL dan meneruskannya ke metode `store` di `OrderController`.
  ```php
  Route::post('/events/{event}/order', [App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
  ```

### B. Logika Controller: Validasi Kuota & Penyimpanan Data

- **Controller (`app/Http/Controllers/OrderController.php` - metode `store`):**
  - Di sinilah logika inti dari proses pemesanan tiket berada. Untuk menjaga integritas data dan mencegah *race condition* (di mana beberapa pengguna mencoba membeli tiket terakhir secara bersamaan), proses ini dibungkus dalam **transaksi database**.

  - **Langkah-langkah utama:**
    1.  **Mulai Transaksi:** `DB::beginTransaction();` memulai "zona aman" untuk operasi database.
    2.  **Validasi Kuota:** Sistem memeriksa apakah jumlah tiket yang diminta (`$jumlah`) tidak melebihi stok yang tersedia (`$tiket->stok`). Jika tidak mencukupi, transaksi dibatalkan dan pengguna mendapat pesan error.
        ```php
        if ($tiket->stok < $jumlah) {
            DB::rollBack();
            return back()->with('error', 'Stok tiket tidak mencukupi.');
        }
        ```
    3.  **Update Stok (Atomic):** Stok tiket dikurangi menggunakan metode `decrement()`. Operasi ini bersifat *atomic*, yang berarti aman dari *race conditions*.
        ```php
        $tiket->decrement('stok', $jumlah);
        ```
    4.  **Buat Pesanan:** Data pesanan baru (`Order` dan `DetailOrder`) dibuat dan disimpan ke database.
    5.  **Commit Transaksi:** Jika semua langkah berhasil, `DB::commit();` menyimpan semua perubahan ke database secara permanen. Jika terjadi kesalahan di salah satu langkah, `DB::rollBack();` akan membatalkan semua perubahan.

### C. Interaksi Model Menggunakan Eloquent

Eloquent ORM mempermudah interaksi dengan database melalui relasi antar model.

- **`Kategori` ke `Event` (One-to-Many):**
  - Satu kategori dapat memiliki banyak event.
  - `app/Models/Kategori.php`:
    ```php
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    ```
  - `app/Models/Event.php`:
    ```php
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    ```

- **`Event` ke `Tiket` (One-to-Many):**
  - Satu event dapat memiliki banyak jenis tiket (misal: VIP, Reguler).
  - `app/Models/Event.php`:
    ```php
    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
    ```
  - `app/Models/Tiket.php`:
    ```php
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    ```
---

## 3. Reasoning: Pola Kode untuk Stabilitas Sistem

Aplikasi ini menggunakan beberapa pola dan praktik terbaik untuk memastikan stabilitas dan keandalan:

- **Pola Desain MVC (Model-View-Controller):**
  - **Alasan:** Memisahkan logika bisnis (Model), antarmuka pengguna (View), dan kontrol alur (Controller) membuat kode lebih terorganisir, lebih mudah dipelihara, dan lebih mudah diuji.

- **Eloquent ORM & Relasi:**
  - **Alasan:** Mengabstraksi interaksi database membuat kode lebih bersih, lebih mudah dibaca, dan mengurangi risiko kesalahan SQL. Relasi yang jelas (`hasMany`, `belongsTo`) memastikan integritas data.

- **Middleware:**
  - **Alasan:** Menyediakan mekanisme yang fleksibel untuk memfilter request HTTP. Dalam kasus ini, middleware `admin` berfungsi sebagai penjaga keamanan yang andal untuk melindungi route-route sensitif.

- **Transaksi Database:**
  - **Alasan:** Ini adalah kunci untuk stabilitas dalam operasi kritis seperti pemesanan. Dengan membungkus logika dalam transaksi, kita memastikan bahwa database hanya akan berada dalam keadaan konsisten. Jika salah satu bagian dari proses gagal (misalnya, stok habis saat proses berjalan), semua perubahan akan dibatalkan, mencegah data yang tidak valid seperti pesanan tanpa pengurangan stok.

- **Operasi Atomic (`decrement`):**
  - **Alasan:** Menggunakan operasi atomic untuk memperbarui data yang sensitif terhadap konkurensi (seperti stok) adalah praktik terbaik untuk mencegah *race conditions*. Ini memastikan bahwa bahkan jika 100 pengguna mencoba membeli tiket terakhir pada saat yang sama, hanya satu yang akan berhasil.
