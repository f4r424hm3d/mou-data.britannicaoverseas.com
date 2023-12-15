<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
  use HasFactory;
  protected $guarded = [];
  public function concernPeople()
  {
    return $this->hasMany(ConcernPerson::class);
  }
  public function getLastComment()
  {
    return $this->hasOne(UniversityFollowup::class, 'university_id', 'id')->orderBy('id', 'desc');
  }
  public function getAllComment()
  {
    return $this->hasMany(UniversityFollowup::class, 'university_id', 'id');
  }
}
