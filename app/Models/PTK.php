<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTK extends Model
{
    use HasFactory;

    protected $table = 'ptk';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'nuptk',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'no_telepon',
        'email',
        'status_kepegawaian',
        'jabatan',
        'pangkat_golongan',
        'tmt_pengangkatan',
        'pendidikan_terakhir',
        'jurusan',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tmt_pengangkatan' => 'date',
    ];

    /**
     * Get the user that owns the PTK record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the documents for the PTK.
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'ptk_id');
    }

    /**
     * Get the full name attribute
     */
    public function getFullNameAttribute()
    {
        return $this->nama_lengkap;
    }

    /**
     * Scope for searching PTK
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nip', 'like', "%{$search}%")
                ->orWhere('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('nuptk', 'like', "%{$search}%")
                ->orWhere('jabatan', 'like', "%{$search}%");
        });
    }

    /**
     * Scope for filtering by status kepegawaian
     */
    public function scopeByStatusKepegawaian($query, $status)
    {
        if ($status) {
            return $query->where('status_kepegawaian', $status);
        }
        return $query;
    }

    /**
     * Scope for filtering by jenis kelamin
     */
    public function scopeByJenisKelamin($query, $jenisKelamin)
    {
        if ($jenisKelamin) {
            return $query->where('jenis_kelamin', $jenisKelamin);
        }
        return $query;
    }
}

