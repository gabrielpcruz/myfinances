<?php

namespace App\Models;

use App\Exceptions\AccountException;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'account';

    protected $attributes = [
        'description' => ''
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'balance',
        'target',
        'description',
    ];

    /**
     * @var string[]
     */
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'balance' => 'float',
        'target' => 'float'
    ];

    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @param $value
     */
    public function setBalanceAttribute($value)
    {
        $this->attributes['balance'] = parse_db_value($value);
    }

    /**
     * @param $value
     */
    public function setTargetAttribute($value)
    {
        $this->attributes['target'] = parse_db_value($value);
    }

    /**
     * @param $value
     * @return Account
     */
    public function deposit($value)
    {
        if ($value > 0) {
            $this->attributes['balance'] += parse_db_value($value);
            return $this;
        }

        throw new InvalidArgumentException("The value entered cannot be less than zero!");
    }

    /**
     * @param $value
     * @return Account
     * @throws AccountException
     */
    public function draft($value)
    {
        if (parse_db_value($value) <= floatval($this->attributes['balance'])) {
            $this->attributes['balance'] -= parse_db_value($value);
            return $this;
        }

        throw new AccountException("Insufficient balance!");
    }
}
