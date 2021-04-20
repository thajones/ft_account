<?php
class OrdersController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("orders");
    }

    public function index() {
        
        try {
            
            $customers = $this->_model->getList();
            
            $this->_view->set('customers', $customers);
            $this->_view->set('title', 'Customer List');
            
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }
    
    
    public function create() {
        try {
            $this->_view->set('title', 'Create Customer');
            
            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();

            $this->_view->set('customers', $customers);
            
            if(!empty($_POST)) {
                $data = $_POST;

                $orderItems = array();

                foreach($data['item'] as $key => $item) {
                    $row = array();
                    $row['item'] = $data['item'][$key];
                    $row['qty'] = $data['qty'][$key];
                    $row['description'] = $data['description'][$key];
                    $row['unit_price'] = $data['unit_price'][$key];;
                    $row['tax'] = $data['tax'][$key];;

                    $orderItems[] = $row;
                }

                unset($data['item'], $data['qty'], $data['description'], $data['unit_price'], 
                $data['tax'], $data['trid'], $data['taxval']);

                //print_r($orderItems);
                //print_r($data); exit;
                $orderId = $this->_model->save($data);
                if($this->_model->save($data)) {

                    $tblOrderItem = new OrderItemsModel();
                    foreach($orderItems as $orderItem) {
                        $orderItem['order_id'] = $orderId;
                        $tblOrderItem->save($orderItem);
                    }

                    $_SESSION['message'] = 'Order added successfully';
                    header("location:". ROOT. "orders"); 
                } else {
                    $_SESSION['error'] = 'Fail to add customer';
                }
            }
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
}