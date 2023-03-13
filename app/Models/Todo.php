<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PhpParser\Node\Stmt\Return_;

class Todo extends Model
{
    use HasFactory;
    use SoftDeletes;

    const PENDING = 0;
    const ONGOING = 1;
    const COMPLETED = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'status',
        'completed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatus()
    {
        switch ($this->status) {
            case $this::PENDING:
                return "Pending";
                break;
            case $this::ONGOING:
                return "In Progress";
                break;
            case $this::COMPLETED:
                return "Completed";
                break;
        }
    }
}
