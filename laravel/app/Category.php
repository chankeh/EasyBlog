<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'categories';  // use the 'categories' table when working with this Category model.
    public function posts()
    {
        $this->hasMany('App\Post');
    }

}
