<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the tasks associated with the project.
     *
     * @return HasMany
     */
    public function tasks(): HasMany 
    {
        return $this->hasMany(Task::class);
    }
}
