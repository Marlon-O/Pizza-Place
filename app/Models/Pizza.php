<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pizza extends Model
{
    protected $primaryKey = 'pizza_id'; // Custom primary key
    public $incrementing = false; // Disable auto-incrementing since the primary key is a string
    protected $keyType = 'string'; // Specify the key type as a string

    protected $fillable = ['pizza_id', 'pizza_type_id', 'size', 'price'];

    /**
     * Get the pizzaType that owns the Pizza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pizzaType(): BelongsTo
    {
        return $this->belongsTo(PizzaType::class, 'pizza_type_id');
    }

    /**
     * Get all of the orderDetails for the Pizza
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'pizza_id');
    }
}
