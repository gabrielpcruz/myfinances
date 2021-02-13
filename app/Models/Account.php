<?php

namespace App\Models;

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

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
