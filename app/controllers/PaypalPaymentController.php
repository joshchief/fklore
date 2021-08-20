<?php

class PaypalPaymentController extends BaseController {

    /**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_apiContext;

    /**
     * Set the ClientId and the ClientSecret.
     * @param
     *string $_ClientId
     *string $_ClientSecret
     */

    /* Paypal Credentials */
    private $_ClientId = 'AR2LsoBlo4bRa1EUv_q-JqUx92Vcf4roj3EFB7CGluG2TgR09X_iO9TB0M8jgA6hya2wtwf0Yqe9NubF';
    private $_ClientSecret='EG_rb6cTXNSMJyrv0h1UDuODWk83S9EzKiyjmXjqc4mN7TbSxtApZYN2ajHOvvu0uRR6g3eEyPyPJsJa';

    /*
     *   These construct set the SDK configuration dynamiclly,
     *   If you want to pick your configuration from the sdk_config.ini file
     *   make sure to update you configuration there then grape the credentials using this code :
     *   $this->_cred= Paypalpayment::OAuthTokenCredential();
    */
    public function __construct()
    {

        // ### Api Context
        // Pass in a `ApiContext` object to authenticate
        // the call. You can also send a unique request id
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly.

        $this->_apiContext = Paypalpayment::ApiContext($this->_ClientId, $this->_ClientSecret);

        // Uncomment this step if you want to use per request
        // dynamic configuration instead of using sdk_config.ini

        $this->_apiContext->setConfig(array(
            'mode' => 'live',
            //'service.EndPoint' => 'https://api.sandbox.paypal.com',
            'service.EndPoint' => 'https://api.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__.'/../PayPal.log',
            'log.LogLevel' => 'FINE'
        ));
    }

    public function index()
    {
        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("paypal");

        $qty = (int) Input::get('shilQty');

        if($qty < 1)
        {
            $qty = 1;
        }

        $item = Paypalpayment::item();

        $item->setName('FolkofLore.com - Gold Shil')
            ->setDescription('Premium in-game currency for FolkofLore.com, non-refundable.')
            ->setCurrency('USD')
            ->setQuantity($qty)
            ->setTax(0)
            ->setPrice(1.00);


        $itemList = Paypalpayment::itemList();
        $itemList->setItems(array($item));


        $details = Paypalpayment::details();
        $details->setShipping("0")
                ->setTax("0")
                //total of items prices
                ->setSubtotal($qty);

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal($qty)
                ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Premium in-game currency for FolkofLore.com, non-refundable.")
            ->setInvoiceNumber(uniqid());
        

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $redirectUrls = Paypalpayment::redirectUrls();
        $redirectUrls->setReturnUrl(url("/payments/success"))
            ->setCancelUrl(url("/payments/fails"));


        $payment = Paypalpayment::payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);
        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create($this->_apiContext);
        } catch (\PPConnectionException $ex) {
            return  "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        return Redirect::to($payment->getApprovalLink());
    }

    public function show($payment_id)
    {
       $payment = Paypalpayment::getById($payment_id,$this->_apiContext);

       dd($payment);
    }

    public function getFails()
    {
       Session::put('error', 'The transaction was canceled or could not complete!');

       return Redirect::to('/shops/premium');
    }

   
    public function getSuccess()
    {
        $paymentId = Input::get('paymentId');
        $PayerID = Input::get('PayerID');

        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("paypal");

        $payment = Paypalpayment::getById($paymentId,$this->_apiContext)->toArray();
        
        if($payment['state'] == 'created')
        {
            // Get the payment Object by passing paymentId
            // payment id was previously stored in session in
            // CreatePaymentUsingPayPal.php
            $payment = Paypalpayment::getById($paymentId, $this->_apiContext);
            
            // PaymentExecution object includes information necessary 
            // to execute a PayPal account payment. 
            // The payer_id is added to the request query parameters
            // when the user is redirected from paypal back to your site
            $execution = Paypalpayment::PaymentExecution();
            $execution->setPayerId($PayerID);
            
            //Execute the payment
            $payment->execute($execution,$this->_apiContext);

            $payment = Paypalpayment::getById($paymentId,$this->_apiContext)->toArray();


            $order = new UserOrders;
            $order->user_id = Auth::user()->id;
            $order->payment_id = $paymentId;
            $order->payer_id = $PayerID;
            $order->paypal_email = $payment['payer']['payer_info']['email'];
            $order->status = $payment['state'];
            $order->item_name = $explode[0];
            $order->item_qty = $payment['transactions'][0]['item_list']['items'][0]['quantity'];
            $order->item_price = $payment['transactions'][0]['related_resources'][0]['sale']['amount']['total'];

            if($payment['state'] == 'pending')
            {
                $order->status_check_timestamp = time();
            }

            $order->save();
        }

        if($payment['state'] == 'approved')
        {
	       $gold = $payment['transactions'][0]['item_list']['items'][0]['quantity'];

	                
	       // Give user their shils
	       $user = User::where('id', '=', Auth::user()->id)->first();
	       $user->increment('gold', $gold);
	       $user->save();

	       Session::flash('success', 'Thank you for your purchase! Your gold shil(s) have been added to your account!');
            
        }
        elseif($payment['state'] == 'pending')
        {
            Session::flash('error', 'Your order is pending! Gold Shilst will be added to your account once your order is approved!');
        }
        else
        {
            Session::flash('error', 'Your order was not completed!');
        }

        return Redirect::to('/shop/premium');
    }
     
     
    /*
    * Process payment using credit card
    */
    public function store()
    {
 
    } 
}