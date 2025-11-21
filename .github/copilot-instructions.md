# Wisuda - AI Coding Agent Instructions

## Project Overview

**Wisuda** is a Laravel 12 application for managing university graduation (wisuda) and academic status verification (yudisium) registration and payment processes. The system handles student registration, payment verification, requirement uploads, and QR code-based attendance tracking for graduation ceremonies.

### Core Purpose
Students register and pay for wisuda/yudisium ceremonies, upload required documents, and admins verify payments and requirements. The system also tracks ceremony attendance via QR codes.

---

## Architecture

### Tech Stack
- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade templates with Tailwind CSS v4 + custom auth styles
- **Build**: Vite with laravel-vite-plugin
- **Database**: SQL (migrations-based schema)
- **QR Codes**: simplesoftwareio/simple-qrcode package

### Key Design Patterns

#### Role-Based Access Control (RBAC)
- Two roles: `mahasiswa` (student) and `admin`
- Enforced via `CheckRole` middleware on route groups
- Routes in `routes/web.php` use `middleware('role:mahasiswa')` and `middleware('role:admin')`
- Example: Yudisium routes only accessible to students; verification routes only to admins

#### Two-Process Model: Wisuda & Yudisium
Both share similar workflows but are **separate processes** managed by independent controller and model pairs:

**Yudisium (Academic Status)**: 
````instructions
# Wisuda - AI Coding Agent Instructions

## Project Overview

**Wisuda** is a Laravel 12 application for managing university graduation (wisuda) and academic status verification (yudisium) registration and payment processes. The system handles student registration, payment verification, requirement uploads, and QR code-based attendance tracking for graduation ceremonies.

### Core Purpose
Students register and pay for wisuda/yudisium ceremonies, upload required documents, and admins verify payments and requirements. The system also tracks ceremony attendance via QR codes.

---

## Architecture

### Tech Stack
- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade templates with Tailwind CSS v4 + custom auth styles
- **Build**: Vite with laravel-vite-plugin
- **Database**: SQL (migrations-based schema)
- **QR Codes**: simplesoftwareio/simple-qrcode package

### Key Design Patterns

#### Role-Based Access Control (RBAC)
- Two roles: `mahasiswa` (student) and `admin`
- Enforced via `CheckRole` middleware on route groups
- Routes in `routes/web.php` use `middleware('role:mahasiswa')` and `middleware('role:admin')`
- Example: Yudisium routes only accessible to students; verification routes only to admins

#### Two-Process Model: Wisuda & Yudisium
Both share similar workflows but are **separate processes** managed by independent controller and model pairs:

**Yudisium (Academic Status)**: 
- Controller: `YudisiumController`
- Models: `PendaftaranYudisium`, `PersyaratanYudisium`

**Wisuda (Graduation Ceremony)**:
- Controller: `WisudaController`
- Models: `PendaftaranWisuda`, `PersyaratanWisuda`, `DataMahasiswaFinal`

Each has identical workflow stages but separate data tables and file directories.

#### User-Centric Data Model
- Central model: `User` (students and admins are both users, distinguished by `role` field)
- Students have: `nim`, `prodi`, `ipk`, `pas_foto`, `no_hp`
- All registration/requirement/attendance data is keyed to `mahasiswa_id` (FK to users)

---

## Critical Workflows

### Development Startup
```bash
composer install
npm install
php artisan key:generate
php artisan migrate --force
npm run build
```

**Development Server** (concurrent processes):
```bash
composer run dev
```
Runs: Laravel server + queue listener + pail logs + Vite dev server (use concurrently)

### Build & Deployment
```bash
npm run build      # Production Vite build
php artisan test   # Run tests
composer run setup # Full fresh setup
```

### File Upload Patterns
- Payment proofs: stored in `storage/app/public/bukti_bayar/{yudisium|wisuda}/`
- Requirements: stored in `storage/app/public/persyaratan/{yudisium|wisuda}/`
- Controllers use `Storage::disk('public')` for access
- Download routes serve files via `response()->download()` for security

---

## Model Relationships & Data Flows

### Pendaftaran (Registration) Flow
1. Student triggers `daftarWisuda()` or `daftarYudisium()` → creates registration record
2. Status flow: `menunggu_pembayaran` → `menunggu_verifikasi` (after proof upload) → `lunas` (after admin verification)
3. Each registration has unique `kode_invoice` (format: `INV-YDS-{timestamp}-{nim}`)

### Multi-Step Processes
Students navigate **sequential steps** shown in views:
1. Register (creates pendaftaran)
2. Pay & upload proof (updates bukti_bayar, status → menunggu_verifikasi)
3. Fill requirements form (creates/updates persyaratan)
4. (Wisuda only) Upload requirement files (creates persyaratan_wisuda records)
5. (Wisuda only) Enter additional data (creates data_mahasiswa_final)

Admin verifies each step independently with status updates.

### Key Model Methods
- `$user->pendaftaranWisuda()` / `$user->pendaftaranYudisium()` - one-to-one registration
- `$pendaftaran->mahasiswa()` - inverse relationship to User
- `getStatusLabelAttribute()` - converts enum status to display labels (e.g., `menunggu_verifikasi` → `Menunggu Verifikasi Admin`)
- Scopes: `User::mahasiswa()`, `User::admin()` - filter by role

---

## Code Conventions

### Controllers
- Public methods handle HTTP requests (show forms, process submissions)
- All controller classes are in `app/Http/Controllers/`
- Pattern: method names reflect actions (`daftarWisuda`, `uploadPersyaratan`, `verifikasiPembayaran`)
- Use `Auth::user()` or `Auth::id()` for current user access; verify ownership in queries

### Models
- Located in `app/Models/`
- Use `protected $fillable = [...]` to define assignable attributes
- Use `protected $casts` for type conversions (e.g., `'tanggal_bayar' => 'datetime'`, `'total_bayar' => 'decimal:2'`)
- Define explicit `protected $table = 'table_name'` if table name doesn't match convention
- Status enums use simple string format stored in DB: `'menunggu_pembayaran'`, `'lunas'`, etc.

### Views & Styling
- Blade templates in `resources/views/` organized by role: `mahasiswa/`, `admin/`
- All custom styles in `resources/css/app.css` with class names like `.auth-gradient-bg`, `.auth-card`, `.auth-input`
- Tailwind v4 with `@import 'tailwindcss'` at top of CSS
- Forms use standard HTML with classes like `.auth-input`, `.auth-button`

### Routes
- Routes in `routes/web.php` are organized by middleware groups and prefixes
- Guest routes: login/register
- Auth routes split by role: student routes under role check, admin routes under `prefix('admin')`
- RESTful naming: `yudisium.index`, `yudisium.daftar`, `admin.verifikasi.pembayaran-yudisium`
- File downloads require auth; use `name` parameter in routes for flexibility

---

## Common Patterns to Follow

### Verification Workflow in Admin
Admin dashboard retrieves unverified submissions, displays them for review:
```php
// Pattern: Query for specific status, eager load relationships
$pendaftaran = PendaftaranYudisium::where('status', 'menunggu_verifikasi')
    ->with('mahasiswa')
    ->get();
```

### File Handling
```php
// Upload: store in public disk with timestamped filename
$file->storeAs('bukti_bayar/yudisium', time() . '_' . $file->getClientOriginalName(), 'public');

// Download: use route model binding and Auth checks
Route::get('/download/{filename}', [YudisiumController::class, 'downloadFile'])->name('yudisium.download');
```

### Status Updates
Always use `match()` for status labels; keep status enum values consistent across migrations and models.

---

## Testing & Debugging

### Common Commands
```bash
php artisan tinker          # REPL for testing queries
php artisan migrate:refresh # Reset DB to fresh migrations
php artisan seed            # Run seeders (AdminUserSeeder for test admin)
php artisan pail            # Watch logs in real-time
```

### Key Test Fixtures
- `AdminUserSeeder`: Creates demo admin user for testing
- Test users available in auth views with demo credentials

---

## External Dependencies & Integrations

### QR Code Generation
- Package: `simplesoftwareio/simple-qrcode`
- Usage: `\\SimpleSoftwareIO\\QrCode\\Facades\\QrCode::generate()` for QR code generation
- Controller: `QrController` handles attendance tracking via QR scans

### Authentication
- Built on Laravel's Authenticatable trait
- Session-based auth (no API tokens required for current features)
- Password hashing via `Illuminate\\Support\\Facades\\Hash`

---

## Project-Specific Gotchas

1. **Two Separate Processes**: Wisuda and Yudisium are NOT shared; changes to one workflow often need parallel updates to the other.
2. **Status Enum Strings**: Status values like `menunggu_pembayaran` are plain strings in DB (not database enum); keep them consistent across migrations.
3. **Ownership Checks**: Always verify `mahasiswa_id` matches `Auth::id()` in student-facing routes to prevent unauthorized access.
4. **File Directories**: Payment proofs and requirement uploads use separate subdirectories (`bukti_bayar/wisuda` vs `bukti_bayar/yudisium`).
5. **Migration Evolution**: Several migrations update enum values (e.g., `2025_11_05_050918_update_status_enum_in_pendaftaran_yudisium_table.php` adds `menunggu_verifikasi` status); check migration history when adding new statuses.

---

## Quick Reference

| Task | Key Files | Command |
|------|-----------|---------|
| Add student field | `User` model, migration | `php artisan make:model --migration` |
| New verification step | `AdminController`, views, routes | Add method + route under `admin/verifikasi` prefix |
| New requirement type | `PersyaratanWisuda` model/controller | Create model + update form view |
| Debug query | `tinker` REPL | `php artisan tinker` |
| Reset dev state | Migrations + seeders | `php artisan migrate:refresh --seed` |


````

