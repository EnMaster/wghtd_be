<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Misurazione extends Model
{
    use HasFactory;

    protected $table = 'misurazioni';

    protected $fillable = [
        'user_id',
        'peso',
        'data',
        'ora',
        'strumento_id',
        'stomaco_vuoto',
    ];

    protected $casts = [
        'data' => 'date',
        'stomaco_vuoto' => 'boolean',
        'peso' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function strumento()
    {
        return $this->belongsTo(Strumento::class);
    }
}