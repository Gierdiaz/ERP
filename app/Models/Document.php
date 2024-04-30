<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['pdf_path', 'signature'];

    public function isSigned()
    {
        return !is_null($this->signature);
    }
}
