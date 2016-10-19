<?php
/**
 *
 * Interkassa shop class
 *
 * Служит для получения секретного ключа и номера кошелька, также имеет
 * несколько полезных методов
 *
 * @package Interkassa
 * @author www.gateon.net <www.smartbyte.pro>
 * @version 1.1
 */

class Interkassa_Shop {

    /**
     * номер кошелька
     *
     * @var string
     */
    protected $_id;

    /**
     * секретный ключ
     *
     * @var string
     */
    protected $_secret_key;

    /**
     * test ключ
     *
     * @var string
     */
    protected $_secret_test_key;

    /**
     * метод создания
     *
     * @param array $options
     *
     * @see Interkassa_Shop::__construct()
     *
     * @return Interkassa_Shop
     */
    public static function factory(array $options) {
        return new Interkassa_Shop($options);
    }

    /**
     * Конструктор
     *
     * Принимаемые параметры конфигурации:
     * - id;
     * - secret_key;
     *
     * @param array $options shop configuration. See above
     *
     * @throws Interkassa_Exception if any option values are missing
     */
    public function __construct(array $options) {
        if (!isset($options['id'])) {
            throw new Interkassa_Exception('Shop id is required');
        }

        if (!isset($options['secret_key'])) {
            throw new Interkassa_Exception('Secret key is required');
        }

        $this->_id = $options['id'];
        $this->_secret_key = $options['secret_key'];
        $this->_secret_test_key = $options['test_key'];
    }

    /**
     * Создание экземпляра платежа
     *
     * @param array $data payment data
     *
     * @see Interkassa_Payment::__construct()
     *
     * @return Interkassa_Payment
     */
    public function createPayment(array $data) {
        return Interkassa_Payment::factory($this, $data);
    }

    /**
     * Получение статуса
     *
     * @param array $source source array to use. Defaults to $_REQUEST
     *
     * @return Interkassa_Status
     *
     * @see Interkassa_Status::__construct()
     *
     * @throws Interkassa_Exception if received shop id does not match current shop id
     */
    public function receiveStatus(array $source = null) {
        if ($source == null) {
            $source = $_REQUEST;
        }

        return Interkassa_Status::factory($this, $source);
    }

    /**
     * Получение ид магазина
     *
     * @return string
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Получение секретного ключа
     *
     * @return string
     */
    public function getSecretKey() {
        return $this->_secret_key;
    }

    public function getSecretTestKey(){
        return $this->_secret_test_key;
    }

    public function checkIP(){
        $ip_stack = array(
            'ip_begin'=>'151.80.190.97',
            'ip_end'=>'151.80.190.104'
        );

        if(!ip2long($_SERVER['REMOTE_ADDR'])>=ip2long($ip_stack['ip_begin']) && !ip2long($_SERVER['REMOTE_ADDR'])<=ip2long($ip_stack['ip_end'])){
            $this->wrlog('REQUEST IP'.$_SERVER['REMOTE_ADDR'].'doesnt match');
            die('Ты мошенник! Пшел вон отсюда!');
        }
        return true;
    }
}
