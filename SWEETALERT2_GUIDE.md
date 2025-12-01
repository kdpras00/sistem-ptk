# SweetAlert2 Implementation Guide

## Overview
Sistem PTK sekarang menggunakan SweetAlert2 untuk notifikasi yang lebih modern dan user-friendly.

## Cara Menggunakan di Controller

### 1. Success Notification (Toast)
```php
return redirect()->route('admin.ptk.index')
    ->with('success', 'Data PTK berhasil ditambahkan.');
```
**Tampilan**: Toast hijau di pojok kanan atas, otomatis hilang setelah 3 detik

### 2. Error Notification (Modal)
```php
return redirect()->back()
    ->with('error', 'Gagal menghapus data. Data masih digunakan.');
```
**Tampilan**: Modal merah di tengah layar, perlu klik OK untuk menutup

### 3. Warning Notification (Modal)
```php
return redirect()->back()
    ->with('warning', 'Password Anda akan kedaluwarsa dalam 7 hari.');
```
**Tampilan**: Modal kuning di tengah layar, perlu klik OK untuk menutup

### 4. Info Notification (Toast)
```php
return redirect()->back()
    ->with('info', 'Sistem akan maintenance pada hari Minggu.');
```
**Tampilan**: Toast biru di pojok kanan atas, otomatis hilang setelah 3 detik

## Konfirmasi Delete

Untuk konfirmasi delete, gunakan fungsi JavaScript yang sudah tersedia:

### Di Blade Template:
```html
<button type="button" 
        onclick="confirmDelete({{ $item->id }}, '{{ $item->nama }}')" 
        class="text-red-600 hover:text-red-800">
    Hapus
</button>

<form id="delete-form-{{ $item->id }}" 
      action="{{ route('admin.item.destroy', $item) }}" 
      method="POST" 
      class="hidden">
    @csrf
    @method('DELETE')
</form>
```

### Di Script Section:
```javascript
@push('scripts')
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Data?',
            html: `Apakah Anda yakin ingin menghapus <strong>${name}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
```

## Custom SweetAlert2 (Advanced)

Untuk kasus khusus, Anda bisa menggunakan SweetAlert2 langsung:

```javascript
Swal.fire({
    title: 'Custom Title',
    text: 'Custom message here',
    icon: 'question', // success, error, warning, info, question
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'No'
}).then((result) => {
    if (result.isConfirmed) {
        // User clicked Yes
    }
});
```

## Toast Configuration

Toast notifications (success & info) sudah dikonfigurasi dengan:
- Position: `top-end` (pojok kanan atas)
- Timer: 3000ms (3 detik)
- Timer Progress Bar: Ya
- Show Confirm Button: Tidak (otomatis hilang)

## Modal Configuration

Modal notifications (error & warning) sudah dikonfigurasi dengan:
- Position: `center` (tengah layar)
- Timer: Tidak ada (perlu klik tombol)
- Show Confirm Button: Ya
- Confirm Button Color:
  - Error: Merah (`#d33`)
  - Warning: Orange (`#f39c12`)

## Validation Errors

Validation errors otomatis ditampilkan dengan SweetAlert2:
```php
$validated = $request->validate([
    'name' => 'required|max:255',
    'email' => 'required|email|unique:users',
]);
```
Jika validasi gagal, SweetAlert2 akan menampilkan daftar error dalam format list.

## Icon Types

SweetAlert2 mendukung 5 tipe icon:
- `success` - ✓ (hijau)
- `error` - ✗ (merah)
- `warning` - ⚠ (kuning)
- `info` - ℹ (biru)
- `question` - ? (biru)

## Best Practices

1. **Gunakan Toast untuk operasi yang berhasil** - Tidak mengganggu workflow user
2. **Gunakan Modal untuk error dan warning** - Memastikan user membaca pesan
3. **Jangan terlalu sering menampilkan notifikasi** - User bisa kewalahan
4. **Gunakan pesan yang jelas dan singkat** - Mudah dipahami
5. **Konsisten dalam penggunaan** - Semua success menggunakan toast, semua error menggunakan modal

## Contoh Implementasi Lengkap

```php
// Controller
public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|max:255',
        'email' => 'required|email|unique:users',
    ]);

    try {
        User::create($validated);
        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal menambahkan user: ' . $e->getMessage())
            ->withInput();
    }
}

public function destroy(User $user)
{
    try {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal menghapus user. Data masih digunakan.');
    }
}
```

## Dokumentasi Lengkap

Untuk fitur lebih lanjut, kunjungi: https://sweetalert2.github.io/

