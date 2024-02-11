<?php

namespace App\Models;

use CodeIgniter\Model;

class PizzaSizeModel extends Model
{
    protected $table = 'pizzas_details';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name_relation', 'size', 'price'];
	
}
