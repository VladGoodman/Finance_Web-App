<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;
    protected $table = 'invites';
    protected $fillable = ['creator_id','recipient_id', 'group_id'];
    public $timestamp = false;
    public $timestamps = false;
}
