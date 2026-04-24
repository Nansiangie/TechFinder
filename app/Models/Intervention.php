<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intervention extends Model
{
    use HasFactory;
    protected $table = 'intervention';
    protected $primaryKey = 'code_int';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'date_int',
        'description_int',
        'code_user_client', 
        'code_user_tech',
        'code_comp',
    ];

    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'code_user_client', 'code_user');
    }

    public function technicien()
    {
        return $this->belongsTo(Utilisateur::class, 'code_user_tech', 'code_user');
    }

    public function competence()
    {
        return $this->belongsTo(Competence::class, 'code_comp', 'code_comp');
    }
}
