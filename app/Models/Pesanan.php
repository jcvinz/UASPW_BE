<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'no_telp', 'alamat', 'paket', 'harga', 'promo',  'status', 'totalHarga'
    ];

    public function getCreatedAtAttribute() {
        if(!is_null($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    } // convert format created_at menjadi Y-m-d H:i:s

    public function getUpdatedAtAttribute() {
        if(!is_null($this->attributes['updated_at'])) {
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    } // convert format updated_at menjadi Y-m-d H:i:s
}
