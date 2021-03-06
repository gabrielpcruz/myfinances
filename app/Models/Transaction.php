<?php

namespace App\Models;

use App\Enum\TransactionType;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'transaction';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $guarded = [
        'id'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function Account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = parse_db_value($value);
    }

    /**
     * @param $value
     */
    public function setTypeAttribute($value)
    {
        if (!in_array($value, [TransactionType::INPUT, TransactionType::OUTPUT])) {
            throw new InvalidArgumentException("Report a valid transaction type!");
        }

        $this->attributes['type'] = $value;
    }
}
