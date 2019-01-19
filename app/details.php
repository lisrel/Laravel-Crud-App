<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class details extends Model
{
    use Sortable;
    protected $fillable = ['first_name', 'surname', 'dob', 'age'];



    public function attributes(){
        return $this->hasOne("App\attributes");
}
}


