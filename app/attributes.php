<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attributes extends Model
{
    protected $fillable =[ 'hair_color', 'weight', 'height'];

    public function details(){
        return $this->BelongsTo("App\details",'id');
    }
}
