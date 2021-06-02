<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountChange extends Model
{
    use HasFactory;

    protected $table = 'account_changes';
    protected $fillable = ['user_id','change_id', 'name_id', 'currency_id', 'quantity'];
    public $timestamp = false;
    public $timestamps = false;
}
