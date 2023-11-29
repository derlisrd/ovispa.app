<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimiento extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'movimientos';
    protected $fillable = ['user_id','detalles','tipo','valor','modo','category_id','created_at'];
    protected $hidden = [ 'updated_at', 'deleted_at','user_id'];
}
