<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Base extends Model implements AuditableContract, HasMedia
{
    use AuditableTrait;
    use InteractsWithMedia;
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'id',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    public function scopeSearch($query, $keyword, $fields = [])
    {
        if (empty($fields) && property_exists($this, 'searchable')) {
            $fields = $this->searchable;
        }

        foreach ($fields as $key => $value) {
            $query->orWhere($value, 'LIKE', "%{$keyword}%");
        }

        return $query;
    }
}
