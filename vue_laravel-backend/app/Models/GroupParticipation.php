<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupParticipation extends Model
{
    use HasFactory;
    protected $table = 'group_participations';
    protected $fillable = ['user_id','group_id'];
    public $timestamp = false;
    public $timestamps = false;
}
