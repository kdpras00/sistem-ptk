<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_type',
        'model_type',
        'model_id',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Get the user that performed the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the model that the activity was performed on.
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * Scope for filtering by activity type
     */
    public function scopeByActivityType($query, $type)
    {
        if ($type) {
            return $query->where('activity_type', $type);
        }
        return $query;
    }

    /**
     * Scope for filtering by user
     */
    public function scopeByUser($query, $userId)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }
        return $query;
    }

    /**
     * Scope for recent activities
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Create a log entry
     */
    public static function log($activityType, $description, $modelType = null, $modelId = null, $properties = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'activity_type' => $activityType,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}

