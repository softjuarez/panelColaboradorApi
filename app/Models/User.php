<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'sqlsrv';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function proveedores(): BelongsToMany
    {
        return $this->belongsToMany(Proveedor::class, ProveedorUsuario::getTableName(), 'usuario_id', 'proveedor_id', 'id', 'NUMERO');
    }

    public function hasPermission($permissionName): bool
    {
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                if($permission->code == $permissionName){
                    return true;
                }
            }
        }

        return false;
    }

    public function fichas(): BelongsToMany {
        return $this->belongsToMany(Ficha::class, 'ficha_usuario', 'usuario_id', 'ficha_id')->withPivot('referencia');
    }

    public function fichaActiva()
    {
        $object = DB::table('ficha_activa')->where('usuario_id', Auth::id())->first();
        return $object->ficha_id ?? 0;
    }

    public function nombreDeFichaActiva()
    {
        $ficha = Ficha::find($this->fichaActiva());
        return $ficha->NOMBRE ?? 'Sin ficha asiganda.';
    }

    public function subordinados(): HasMany
    {
        return $this->hasMany(User::class, 'jefe_id', 'id');
    }

    public function autorizaLimiteMayor(): HasMany
    {
        return $this->hasMany(User::class, 'validador_monto_mayor', 'id');
    }

    public function autorizaLimiteMenor(): HasMany
    {
        return $this->hasMany(User::class, 'validador_monto_menor', 'id');
    }

    public function configuracion()
    {
        return $this->hasOne(ConfiguracionUsuario::class);
    }

    public function gestionActiva()
    {
        return $this->hasOne(Gestor::class)->active();
    }

    public function Jefe()
    {
        return $this->belongsTo(User::class, 'jefe_id', 'id');
    }
}
