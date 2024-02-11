<?php

namespace App\Models;

use CodeIgniter\Model;

class PizzaOrderModel extends Model
{
    protected $table            = 'pizza_orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pizza_id', 'size_id','total_amount','order_id'];
	
	
	public function getOrderWithJoin($order_id)
    {
        return $this->select('pizzas.name,pizzas_details.size,pizzas_details.price')->where('order_id',$order_id)->join('pizzas', 'pizzas.id = pizza_orders.pizza_id','left')->join('pizzas_details', 'pizzas_details.id = pizza_orders.size_id','left')->find();
    }
	
	public function insertFinal($data){
		
		$this->db->table('final_orders')->insert($data);
		
		
	}
	
	public function finalOrder($getOrderId){
		
		return $this->db->table('final_orders')->select('*')->get()->getResult();

		
		
	}
}
