<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// 1. On importe la bonne classe d'authentification
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

// 2. On change "extends Model" par "extends Authenticatable"
class Utilisateur extends Authenticatable
{
    use HasFactory;

    protected $table = 'utilisateur';
    protected $primaryKey = 'code_user';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'code_user', 'nom_user', 'prenom_user', 'login_user',
        'password_user', 'tel_user', 'sexe_user', 'role_user', 'etat_user',
    ];

    //hacher le mot de passe
    public function setPasswordUserAttribute($value){
        $this->attributes['password_user'] = Hash::make($value);
    }
    function interventions()
    {
        return $this->hasMany(intervention::class, 'code_user', 'code_user');
    }


    function competences()
    {

        return $this->belongsToMany(Competence::class, 'user_competences', 'code_user', 'code_comp');
    }

    public function userCompetences()
    {
        return $this->hasMany(User_Competence::class, 'code_user', 'code_user');
    }

    public function getAuthPassword()
    {
        return $this->password_user;
    }

    public function getAuthPasswordName()
    {
        return 'password_user';
    }

    // 1. Dire à Laravel quelle est la colonne de l'identifiant
    public function getAuthIdentifierName()
    {
        return 'code_user';
    }

    // 2. Dire à Laravel comment récupérer la valeur de cet identifiant
    public function getAuthIdentifier()
    {
        return (string) $this->code_user;
    }

}
