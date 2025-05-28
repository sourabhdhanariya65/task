<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'due_date',
        'status', 
    ];
    protected $dates = ['due_date'];
    protected $casts = [
        'due_date' => 'date',
    ];

    /**
     * Get the project that owns the task.
     *
     * @return BelongsTo
     */
   public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
