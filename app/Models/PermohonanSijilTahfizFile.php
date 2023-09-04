<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermohonanSijilTahfizFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'permohonan_sijil_tahfiz_id',
        'file_upload_name',
        'file_upload_path',
        'document_type',
        'created_by',
        'deleted_by',
    ];

    protected $guarded = ['id'];
}
