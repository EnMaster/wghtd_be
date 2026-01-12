<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strumento extends Model
{
    use HasFactory;

    protected $table = 'strumenti';

    protected $fillable = [
        'nome',
        'marca',
        'descrizione',
        'created_by',
    ];

    public function creatore()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function misurazioni()
    {
        return $this->hasMany(Misurazione::class);
    }
}