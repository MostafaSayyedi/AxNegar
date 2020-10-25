<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $params = array();
    private $MerchantID;
    private $Amount;
    private $Description;
    private $id;
    private $CallbackURL;
    public $order_id;
    private $name;
    private $phone;
    private $mail;
    private $reseller;


    protected $fillable = [
        'track_id', 'id_code', 'status', 'order_id', 'amount', 'description', 'images', 'type', 'paymentable_id', 'paymentable_type'
    ];
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct($amount, $orderId = null, $name = null, $phone = null, $mail = null, $description = null, $reseller = null)
    {
        $this->order_id = $orderId;
        $this->Amount = $amount;
        $this->name = $name;
        $this->phone = $phone;
        $this->mail = $mail;
        $this->Description = $description;
        $this->CallbackURL = env('IDPAY_REDIRECT');
        $this->reseller = $reseller;
    }

    public function setAttr()
    {
        $this->params = [
            'order_id' => $this->order_id,
            'amount' => $this->Amount,
            'name' => $this->name,
            'phone' => $this->phone,
            'mail' => $this->mail,
            'desc' => $this->Description,
            'callback' => $this->CallbackURL,
            'reseller' => $this->reseller,
        ];
    }

    public function paymenable()
    {
        return $this->morphTo();
    }



    public function doPayment()
    {
        $this->setAttr();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-API-KEY: ' . env('IDPAY_API_KEY'),
            'X-SANDBOX: 1'
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);

        var_dump($result);
        return $result;
    }

    public function verifyPayment($id, $status)
    {
        $params = array(
            'id' => session()->get('wallet_pay_id'),
            'order_id' => $this->order_id,
        );
//        dd($params);
        if ($status == 10) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment/verify');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-API-KEY: ' . env('IDPAY_API_KEY'),
                'X-SANDBOX: 1',
            ));

            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result);
            return $result;
        } else {
            return false;
        }

    }
}
