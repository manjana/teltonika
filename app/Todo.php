<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Zizaco\Entrust\EntrustPermission;

/**
 * Class Permission
 * @package App\Model
 */
class Todo extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];

    /**
     * @var string
     */
    protected $table = 'todo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data',
    ];

    public $timestamps = true;

    /**
     * Return the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}