<?php
class PaymentsController extends Controller
{
    
    public function __construct($model, $action) {   
        parent::__construct($model, $action);
        $this->_setModel("payments");
    }

    public function index() {
        
        try {
            
            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);
            
            $customerPayTbl = new CustomerPaymentsModel();
            $payments = $customerPayTbl->customlist();
            
            $this->_view->set('payments', $payments);
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
        
    }
    
    /*
    public function create_old() {
        try {

            $this->_view->set('title', 'Add Payment');
            
            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);
            
            $groupTbl = new CustomerGroupsModel();
            $groups = $groupTbl->list();
            $this->_view->set('groups', $groups);
            
            $invoiceTbl = new InvoicesModel();
            $invoices = $invoiceTbl->getInvoiceIds();
            $this->_view->set('invoices', $invoices);

            if(!empty($_POST)) {
                $data = $_POST;
                
                //echo '<pre>'; print_r($data); exit;
                $customerPayments = array();
                $customerPayments['group_id'] = $data['group_id'];
                $customerPayments['customer_id'] = $data['customer_id'];
                $customerPayments['order_id'] = $data['order_id'];
                $customerPayments['invoice_id'] = $data['invoice_id'];
                $customerPayments['payment_date'] = $data['payment_date'];
                $customerPayments['cheque_utr_no'] = $data['cheque_utr_no'];
                $customerPayments['received_amt'] = $data['received_amt'];
                $customerPayments['remarks'] = $data['remarks'];

                $customerPayments['user_id'] = $this->_session->get('user_id'); // created by user

                
                if(!empty($_FILES)){
                    //Get the temp file path
                    $tmpFilePath = $_FILES['utr_file']['tmp_name'];
                    
                    //Make sure we have a file path
                    if ($tmpFilePath != ""){
                        //Setup our new file path
                        $newFileName = time().'_'. $_FILES['utr_file']['name'];
                        $newFilePath =  "./utr_file/".$newFileName;
                        //Upload the file into the temp dir
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $customerPayments['utr_file'] = $newFileName;
                            
                        }
                    }
                }

                $customerPayTbl = new CustomerPaymentsModel();
                $custPaymentId = $customerPayTbl->save($customerPayments);
                
                
                if($custPaymentId) {

                    if(isset($data['tds_data'])) {
                        foreach($data['tds_data'] as $key => $item) {
                            $row = array();
                            $row['customer_payment_id'] = $custPaymentId;
                            $row['invoice_id'] = $item['invoice_id'];
                            $row['basic_value'] = $item['basic_value'];
                            $row['gst_amount'] = $item['gst_amount'];
                            $row['invoice_amount'] = $item['invoice_amount'];
                            $row['tds_percent'] = $item['tds_percent'];
                            $row['tds_deducted'] = $item['tds_deducted'];
                            $row['receivable_amt'] = $item['receivable_amt'];
                            $row['allocated_amt'] = $item['allocated_amt'];
                            $row['balance_amt'] = $item['balance_amt'];
                            //$payments[] = $row;
                            $this->_model->save($row);
                        }
                    }

                    echo json_encode(array("status"=>1, "message"=>"Payment added successfully"));
                    exit;
                    //$_SESSION['message'] = 'Payment added successfully';
                    //header("location:". ROOT. "payments");
                } else {
                    //$_SESSION['error'] = 'Fail to add payment';
                    echo json_encode(array("status"=>0, "message"=>"Fail to add payment"));
                    exit;
                }
            }
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
    */

    public function create() {
        try {
            $this->_view->set('title', 'Add Payment');
            
            $customerList = new CustomersModel();
            $customers = $customerList->getNameList();
            $this->_view->set('customers', $customers);
            
            $groupTbl = new CustomerGroupsModel();
            $groups = $groupTbl->list();
            $this->_view->set('groups', $groups);
            
            $invoiceTbl = new InvoicesModel();
            $invoices = $invoiceTbl->getInvoiceIds();
            $this->_view->set('invoices', $invoices);
            
            
            
            if(!empty($_POST)) {

                $output = array();
                $data = $_POST;
                
                // echo '<pre>'; print_r($data); exit;
                $customerPayments = array();
                $payments = array();
                
                $customerPayments['group_id'] = $data['group_id'];
                $customerPayments['customer_id'] = $data['customer_id'];
                $customerPayments['payment_date'] = $data['payment_date'];
                $customerPayments['cheque_utr_no'] = $data['cheque_utr_no'];
                $customerPayments['received_amt'] = $data['received_amt'];
                $customerPayments['remarks'] = $data['remarks'];
                $customerPayments['user_id'] = $this->_session->get('user_id'); // created by user
                
                if(!empty($_FILES)){
                    //Get the temp file path
                    $tmpFilePath = $_FILES['utr_file']['tmp_name'];
                    
                    //Make sure we have a file path
                    if ($tmpFilePath != ""){
                        //Setup our new file path
                        $newFileName = time().'_'. $_FILES['utr_file']['name'];
                        $newFilePath =  "./utr_file/".$newFileName;
                        //Upload the file into the temp dir
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $customerPayments['utr_file'] = $newFileName;
                            
                        }
                    }
                }

                $customerPayTbl = new CustomerPaymentsModel();
                $custPaymentId = $customerPayTbl->save($customerPayments);
                
                
                if($custPaymentId) {
                    if(isset($data['payment_invoice'])) {
                        foreach($data['payment_invoice'] as $item) {
                            $row = array();
                            $row['customer_payment_id'] = $custPaymentId;
                            $row['order_id'] = $item['order_id'];
                            isset($item['proforma_id']) ? $row['proforma_id'] = $item['proforma_id']:"";
                            isset($item['invoice_id']) ? $row['invoice_id'] = $item['invoice_id']:"";
                            $row['basic_value'] = $item['basic_value'];
                            $row['gst_amount'] = $item['gst_amount'];
                            $row['invoice_amount'] = $item['invoice_amount'];
                            $row['tds_percent'] = $item['tds_percent'];
                            $row['tds_deducted'] = $item['tds_deducted'];
                            $row['receivable_amt'] = $item['receivable_amt'];
                            $row['allocated_amt'] = $item['allocated_amt'];
                            $row['balance_amt'] = $item['balance_amt'];
                            $row['user_id'] = $this->_session->get('user_id'); // created by user

                            //$payments[] = $row;
                            $this->_model->save($row);
                        }
                    }
                    
                    
                    $_SESSION['message'] = 'Payment added successfully';
                    $output['status'] = 1;
                    $output['message'] = 'Payment added successfully';
                    header("location:". ROOT. "payments"); exit;
                    
                } else {
                    $_SESSION['error'] = 'Fail to add payment';
                    $output['status'] = 0;
                    $output['message'] = 'Fail to add payment';
                }

                //echo json_encode($output); exit;
            }
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
    
    public function view($id) {
        try {
            
            $customerPayTbl = new CustomerPaymentsModel();
            $customerPayment = $customerPayTbl->get($id);
            $this->_view->set('customerPayment', $customerPayment);
            
            $invoicePayment = $this->_model->getDetailsByPaymentId($id);
            //print_r($invoicePayment); exit;
            $this->_view->set('invoicePayment', $invoicePayment);
            
            return $this->_view->output();
            
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }

    public function utr_validty() {
            if(!empty($_POST)) {
                if($t = $this->_model->getRecordsByField('cheque_utr_no', $_POST['cheque_utr_no'])) {
                    echo 0;
                } else {
                    echo true;
                }
            } else {
                echo false;
            }
        }
}