<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable =['id','name','nationality_id','religion_id','position_id','department_id','signature'];
    public $timestamps = false;

    public function department(){
        return $this->belongsTo(Department::class);
    }
    
    public function position(){
        return $this->belongsTo(Position::class);
    }
    public function nationality(){
        return $this->belongsTo(Nationality::class);
    }
    public function religion(){
        return $this->belongsTo(Religion::class);
    }


}
