<?php

/**
 * Класс статусов
 *
 * Класс служит для получения и обработки статуса платежа.
 * Также содержит метод сверки цифровой подписи
 *
 *
 * @package Interkassa
 * @author www.gateon.net <www.smartbyte.pro>
 * @version 1.1
 */

class Interkassa_Status {

    protected $_verified = false;
    protected $_timestamp;
    protected $_state;
    protected $_trans_id;
    protected $_currency;
    protected $_fees_payer;
    protected $_shop;
    protected $_payment;

    /**
     * Создание экземпляра класса
     *
     * @param Interkassa_Shop $shop
     * @param array $source
     *
     * @see Interkassa_Status::__constructor()
     *
     * @return Interkassa_Status
     */
    public static function factory(Interkassa_Shop $shop, array $source) {
        return new Interkassa_Status($shop, $source);
    }

    /**
     * Конструктор
     *
     * @param Interkassa_Shop $shop
     * @param array $source the data source to use, e.g. $_POST.
     *
     */
    public function __construct(Interkassa_Shop $shop, array $source) {
        $this->_shop = $shop;

        foreach (array(
            'ik_co_id' => 'Shop id',
            'ik_pm_no' => 'Payment id',
            'ik_am' => 'Payment amount',
            'ik_desc' => 'Payment description',
            'ik_pw_via' => 'Payway Via',
            'ik_sign' => 'Payment Signature',
            'ik_cur' => 'Currency',
            'ik_inv_prc' => 'Payment Time',
            'ik_inv_st' => 'Payment State',
            'ik_trn_id' => 'Transaction',
            'ik_ps_price' => 'PaySystem Price',
            'ik_co_rfn' => 'Checkout Refund'
        ) as $field => $title)
            if (!isset($source[$field]))
                throw new Interkassa_Exception($title . ' not received');

        $received_id = strtoupper($source['ik_co_id']);
        $shop_id = strtoupper($shop->getId());

        if ($received_id !== $shop_id)
            throw new Interkassa_Exception('Received shop id does not match current shop id');

        if ($this->_checkSignature($source))
            $this->_verified = true;
        else
            throw new Interkassa_Exception('Signature does not match the data');

        $payment = $shop->createPayment(array(
            'id' => $source['ik_pm_no'],
            'amount' => $source['ik_am'],
            'description' => $source['ik_desc']
        ));

        if (!empty($source['ik_x_baggage']))
            $payment->setBaggage($source['ik_x_baggage']);

        $this->_payment = $payment;
        $this->_timestamp = $source['ik_inv_prc'];
        $this->_state = (string) $source['ik_inv_st'];
        $this->_trans_id = (string) $source['ik_trn_id'];
        $this->_currency = $source['ik_cur'];
        $this->_fees_payer = $source['ik_ps_price'] - $source['ik_co_rfn'];
    }

    /**
     * Получение даты и времени
     *
     * @return int
     */
    public function getTimestamp() {
        return $this->_timestamp;
    }

    /**
     * Обработка даты
     *
     * @see http://php.net/http://ua2.php.net/manual/en/class.datetime.php
     *
     * @return DateTime
     */
    public function getDateTime() {
        return new DateTime('@' . $this->getTimestamp());
    }

    /**
     * Получение статуса платежа
     *
     * Returns {@link Interkassa::STATE_SUCCESS} or {@link Interkassa::STATE_FAIL}
     *
     * @return string
     */
    public function getState() {
        return $this->_state;
    }

    /**
     * Получение ид транзацкии
     *
     * This id is provided by interkassa
     *
     * @return string
     */
    public function getTransId() {
        return $this->_trans_id;
    }

    /**
     * Получение валюты платежа
     *
     * Returns the currency exchange rate defined in shop preferences at the
     * time of the transaction
     *
     * @return float
     */
    public function getCurrencyName() {
        return $this->_currency;
    }

    /**
     * Получение платильщика
     *
     * @return float
     */
    public function getFeesPayer() {
        return $this->_fees_payer;
    }

    /**
     * Получение данных о верификации
     *
     * @return bool
     */
    public function getVerified() {
        return $this->_verified;
    }

    /**
     * Получение платежа
     *
     * @return Interkassa_Payment
     */
    public function getPayment() {
        return $this->_payment;
    }

    /**
     * Получение объекта
     *
     * @return Interkassa_Shop
     */
    public function getShop() {
        return $this->_shop;
    }

    /**
     * Сверка сигнатуры
     *
     * @param array $source the data source
     *
     * @return bool
     */
    final protected function _checkSignature($source) {
        $post = $source;
        unset($post['ik_sign']);
        ksort($post, SORT_STRING);
        array_push($post, $this->getShop()->getSecretKey());
        $signature = base64_encode(md5(implode(':', $post), true));
        return $source['ik_sign'] === $signature;
    }

}
