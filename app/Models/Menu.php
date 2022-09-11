<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $with = ['children'];

    protected $fillable = ['name', 'url', 'title', 'sequence', 'parent_id', 'is_newtab'];


    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->orderBy('sequence');
    }
}
