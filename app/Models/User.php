<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Currenciable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Currenciable;

    const USER_ROLE = [
        'admin' => 1,
        'client' => 2,
        'employee' => 3,
        'investor' => 4,
        'user' => 0
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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
    ];

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class,'user_id');
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class,'user_id');
    }

    public static function getWarehouse()
    {
        if (session()->get('warehouse')){
            return Warehouse::find(session()->get('warehouse'));
        }else{
            return Warehouse::whereHas('users', function($q) {
                    $q->where('users.id', \auth()->id());
                    $q->where('warehouse_users.default', true);
                })
                ->first();
        }
    }

    public static function getCurrency()
    {
        return Auth::user()->currencies;
    }

    public function warehouses()
    {
        return $this->belongsToMany(
            Warehouse::class,
            'warehouse_users',
            'user_id',
            'warehouse_id')->withPivot('default');
    }

    public function money_transfers()
    {
        return $this->hasMany(Transferable::class, 'user_id')->where('transferable_type', MoneyTransfer::class);
    }

    public function product_transfers()
    {
        return $this->hasMany(Transferable::class, 'user_id')->where('transferable_type', ProductTransfer::class);
    }


    public function scopeSearch($value, $search)
    {
//        dd($value);
    }

    public function scopeFilter($value, $array)
    {
        return $value
            ->when(isset($array['user_id']), function ($q) use ($array) {
                $q->whereLike('user_id', $array['user_id']);
            })
            ->when(isset($array['search']), function ($q) use ($array) {
                Post::whereRaw('MATCH (title, body) AGAINST (?)' , array($search))->get();
                $q->whereLike('user_id', $array['user_id']);
            })
            ->when(isset($array['status']), function ($q) use ($array) {
                $q->whereLike('status', $array['status']);
            })
            ->when(isset($array['active']), function ($q) use ($array) {
                $q->whereActive($array['active']);
            })
            ->when(isset($array['length']), function ($q) use ($array) {
                $q->skip($array['start'] ?? 0)->take($array['length']);
            });
    }

}
