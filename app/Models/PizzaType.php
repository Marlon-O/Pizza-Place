<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PizzaType extends Model
{
    protected $primaryKey = 'pizza_type_id'; // Custom primary key
    public $incrementing = false; // Disable auto-incrementing since the primary key is a string
    protected $keyType = 'string'; // Specify the key type as a string

    protected $fillable = ['pizza_type_id', 'name', 'category', 'ingredients'];

    /**
     * Get all of the pizzas for the PizzaType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pizzas(): HasMany
    {
        return $this->hasMany(Pizza::class, 'pizza_type_id');
    }
}
