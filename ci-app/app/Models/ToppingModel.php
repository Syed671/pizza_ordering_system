<?php

namespace App\Models;

use CodeIgniter\Model;

class ToppingModel extends Model
{
    protected $table = 'toppings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price'];
}
