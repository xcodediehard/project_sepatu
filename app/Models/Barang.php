<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function detail_barang()
    {
        return $this->hasMany(DetailBarang::class, "barang_id", "id");
    }

    public function merek_field()
    {
        return $this->belongsTo(Merek::class, 'merek_id', 'id');
    }
    public function detail_barang_field()
    {
        return $this->hasMany(DetailBarang::class, 'barang_id', 'id');
    }
}
