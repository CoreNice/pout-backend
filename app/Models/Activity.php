<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'activities';

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'image',
        'status',
        'created_at',
        'updated_at',
    ];

    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            if (str_starts_with($value, 'http')) {
                return $value;
            }

            try {
                return url(\Illuminate\Support\Facades\Storage::url($value));
            } catch (\Throwable $e) {
                return $value;
            }
        }

        return 'https://miirzidqxixntjwqfnul.supabase.co/storage/v1/object/public/pout-pictures/public/pout.jpg';
    }

    public static function booted()
    {
        static::creating(function ($model) {
            if (!$model->created_at) {
                $model->created_at = now();
            }
            $model->updated_at = now();
        });

        static::updating(function ($model) {
            $model->updated_at = now();
        });
    }
}
