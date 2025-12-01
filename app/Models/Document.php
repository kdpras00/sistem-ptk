<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'ptk_id',
        'category_id',
        'uploaded_by',
        'nomor_dokumen',
        'nama_dokumen',
        'deskripsi',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'tanggal_dokumen',
        'tanggal_upload',
        'status',
    ];

    protected $casts = [
        'tanggal_dokumen' => 'date',
        'tanggal_upload' => 'date',
        'file_size' => 'integer',
    ];

    /**
     * Get the PTK that owns the document.
     */
    public function ptk()
    {
        return $this->belongsTo(PTK::class);
    }

    /**
     * Get the category that owns the document.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user who uploaded the document.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Scope for active documents only
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for searching documents
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nomor_dokumen', 'like', "%{$search}%")
                ->orWhere('nama_dokumen', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }

    /**
     * Scope for filtering by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }

    /**
     * Scope for filtering by PTK
     */
    public function scopeByPTK($query, $ptkId)
    {
        if ($ptkId) {
            return $query->where('ptk_id', $ptkId);
        }
        return $query;
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}

