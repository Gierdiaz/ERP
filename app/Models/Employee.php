<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected $fillable = ['name'];
}
