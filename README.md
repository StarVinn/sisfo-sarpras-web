# Sisfo Sarpras
## Description
SOON

## Installation
1. Clone the repository `git clone https://github.com/StarVinn/sisfo-sarpras-web.git`
2. Run `composer install`
3. Run `touch .env`
4. Copy .env.example to .env
5. Edit .env to set your database credentials
6. Run `php artisan key:generate`
7. Run `php artisan migrate:fresh --seed`
8. Run `php artisan serve`


## API Endpoints

### AUTH
#### - `POST` /api/login
- Description: Login API endpoint
- Parameters:
- `email`
- `password`
- Response:
- `token` (string)
- `user` (object)
- `message` (string)
#### - `POST` /api/logout
- Description: Logout API endpoint
- Parameters:
- `token` (string)
- Response:
- `message` (string)

### HOME
#### - `GET` /api/home
- Description: Home API endpoint
- Parameters:
- `token` (string)
- Response:
- `message` (string)
- `peminjaman` (object)
- `barang` (object)

### BARANG
#### - `GET` /api/barang
- Description: Get all barang
- Parameters:
- `token` (string)
- Response:
- `barang` (array)

### - `GET` /api/barang/{barang}
- Description: Get barang by id
- Parameters:
- `token` (string)
- `barang` (string)
- Response:
- `barang` (object)

### PEMINJAMAN
#### - `GET` /api/peminjaman
- Description: Get all peminjaman
- Parameters:
- `token` (string)
- Response:
- `peminjaman` (array)

#### - `POST` /api/peminjaman
- Description: Create new peminjaman
- Parameters:
- `token` (string)
- `barang_id` (string)
- `user_id` (string)
- `kelas_peminjam` (string)
- `tanggal_peminjaman` (string)
- `status` (string)->default(`waiting peminjaman`)
- Response:
- `peminjaman` (object)
- `message` (string)
#### - `GET` /api/peminjaman/{id}
- Description: Get peminjaman by id
- Parameters:
- `token` (string)
- `peminjaman_id` (string)
- Response:
- `peminjaman` (object)

#### - `POST` /api/pengembalian/{id}
- Description: Create new pengembalian
- Parameters:
- `token` (string)
- `peminjaman_id` (string)
- `image_bukti` (string)
- `kondisi_barang` (string)
- `tanggal_pengembalian` (string)
- `status` (string)->default(`waiting pengembalian`)
- Response:
- `pengembalian` (object)
- `message` (string)


