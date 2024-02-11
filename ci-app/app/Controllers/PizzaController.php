<?php

namespace App\Controllers;

use App\Models\PizzaModel;
use App\Models\ToppingModel;
use App\Models\PizzaSizeModel;
use App\Models\PizzaOrderModel;

class PizzaController extends BaseController
{
	
    public function order()
    {

        $pizzaModel = new PizzaModel();
        $toppingModel = new ToppingModel();
        $pizzaOrderModel = new PizzaOrderModel();
        $pizzaSizeModel = new PizzaSizeModel();
		
		$data['randomNumber'] = rand(1000, 9999);
		session()->set('random', $data['randomNumber']);
		
		if (!session()->has('order_id')) {
			$order_id = $pizzaOrderModel->selectMax('order_id')->get()->getRow();
			if ($order_id->order_id) {
				$sessionId = session()->set('order_id', $order_id->order_id+1);
			} else {
				$sessionId = session()->set('order_id', 1);
			}
		}
		
		//Pizza Name
        $data['pizzas'] = $pizzaModel->findAll();		
		
		//get topping details
        $data['toppings'] = $toppingModel->findAll();
		
		//get added pizza name and price join with pizza table 
        $data['onePizza'] = $pizzaOrderModel->getOrderWithJoin(session()->get('order_id'));
				
        return view('order_form', $data);
    }
	
	public function submitData(){
		
		$pizzaOrderModel = new PizzaOrderModel();
		$pizzaSizeModel = new PizzaSizeModel();
		
        $rules = [
                'pizzaName' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'You must choose a Pizza.',
				],
			],
            'pizzaSize' => [
				'rules'  => 'required',
				'errors' => [
					'required' => 'You must choose a Pizza Size.',
				],
			]
		];
			

            if (!$this->validate($rules)) {
                $validation = $this->validator;
				session()->setFlashdata('error',$validation);
				
            } else {
				
                $randm = hash('sha256',$this->request->getPost('randm'));
				$rand = hash('sha256',session()->get('random'));
				
				if($randm == $rand){
					
					$pizzaId = $this->request->getPost('pizzaName');
					$sizeId = $this->request->getPost('pizzaSize');
					
					$onePizza = $pizzaSizeModel->where('id',$sizeId)->find();
					//get pizza price and others details for one pizza added
					$onePizzaPrice = $onePizza[0]['price'];

					$orderData = [
						'pizza_id' => $pizzaId,
						'size_id' => $sizeId,
						'total_amount' => $onePizzaPrice,
						'order_id' => session()->get('order_id')
					];
					
					// Code to insert $orderData into pizza_orders table
					$pizzaOrderModel->insert($orderData);
				}
			}
			
			return redirect()->to('/');
			
		
	}
	
	
	public function finalSubmit(){
		
		$pizzaOrderModel = new PizzaOrderModel();
		
		$rules = [
                'toppings' => 'permit_empty',
            ];
			
		if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
		
			$toppings = $this->request->getPost('toppings');
			
			
			
			if(isset($toppings)){
				$toppingsString = implode(',',$toppings);	
			}
			else{
				$toppingsString = '';
			}
			
			
			$getOrderId = session()->get('order_id');
			
			
			$data['pizzaOrder'] = $pizzaOrderModel->select('pizzas.name,pizzas_details.size,pizza_orders.total_amount')->join('pizzas', 'pizzas.id = pizza_orders.pizza_id')->join('pizzas_details', 'pizzas_details.id = pizza_orders.size_id')->where('order_id',$getOrderId)->findAll();	
			
			$sumAmount = 0;
			foreach($data['pizzaOrder'] as $data){
				
				$sumAmount  += $data['total_amount'];
				
			}
						
			$orderDataFinal = [
			'order_id' => $getOrderId,
			'topping_ids' => $toppingsString,
			'pizza_amout' => $sumAmount
			];
				
			$pizzaOrderModel->insertFinal($orderDataFinal);
			
		}
		return redirect()->to('checkout');
		
	}
	
	
	public function checkout(){
		
		$pizzaOrderModel = new PizzaOrderModel();
		$toppingModel = new ToppingModel();
		
		$getOrderId = session()->get('order_id');
		$data['pizzaOrder'] = $pizzaOrderModel->select('pizzas.name,pizzas_details.size,pizza_orders.total_amount')->join('pizzas', 'pizzas.id = pizza_orders.pizza_id')->join('pizzas_details', 'pizzas_details.id = pizza_orders.size_id')->where('order_id',$getOrderId)->findAll();
		
		
		$data['finalOrder'] = $pizzaOrderModel->finalOrder($getOrderId);
		//print_r($data['finalOrder']);exit;
		
		if(!empty($data['finalOrder'][0]->topping_ids)){
			
			$toppingIds = $data['finalOrder'][0]->topping_ids;

			$toppingIdsArray = explode(',',$toppingIds);
			//print_r($toppingIdsArray);exit;
			
			//$toppingsPrice = 0;
			foreach ($toppingIdsArray as $toppingId) {
				$data['topping'][] = $toppingModel->find($toppingId);
			}
			
		}
		//print_r($data['topping']);exit;
		session()->destroy();
		
		return view('checkout', $data);
		
	}
	
	
	public function getPizzaSize(){
		
		$pizzaNameId = $this->request->getPost('pizza_name');
		
		$pizzaSizeModel = new PizzaSizeModel();
		
		$pizzaSize = $pizzaSizeModel->where('name_relation',$pizzaNameId)->findAll();
		
		return $this->response->setJSON($pizzaSize);
		
		
		
	}
}
