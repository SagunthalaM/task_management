<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Task extends Model
{
    use HasFactory;
    use Notifiable;
    protected $table = 'tasks';
    protected $fillable = [
        'task',
        'description',
        'position',
        'progresss',
        'start_date',
        'end_date'
    ] ;

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function getEmailAddresses()
    {
        return $this->users->pluck('email')->toArray();
    }
}
