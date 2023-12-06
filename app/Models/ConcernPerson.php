<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConcernPerson extends Model
{
  use HasFactory;
  public function getUniversity()
  {
    return $this->hasOne(University::class, 'id', 'university_id');
  }
}
