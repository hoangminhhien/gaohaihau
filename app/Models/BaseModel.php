<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Awobaz\Compoships\Database\Eloquent\Model;
class BaseModel extends Model
{
  use SoftDeletes;
}
