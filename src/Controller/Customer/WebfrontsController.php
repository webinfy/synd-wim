<?php

namespace App\Controller\Customer;

use Cake\Network\Exception\UnauthorizedException;
use App\Controller\AppController;
use Cake\Event\Event;

//use Cake\Datasource\ConnectionManager;

class WebfrontsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');
        $this->loadModel('Users');
        $this->loadModel('Payments');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('');
        $this->Auth->allow(['payment']);
    }

    public function payment($webfront = NUll, $uniqId = null) {
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniqId]);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }
        $payment = $query->contain(['Users'])->first();
        $webfront = $this->Webfronts->find()->where(['Webfronts.id' => $payment->webfront_id])->first();
        $merchant = $this->Users->find()->where(['Users.id' => $webfront->merchant_id])->contain(['MerchantProfiles'])->first();
        $this->set(compact('payment', 'webfront', 'merchant'));
    }

}
