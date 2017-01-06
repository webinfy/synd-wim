<?php

namespace App\Controller\Admin;

use Cake\Network\Exception\UnauthorizedException;
use App\Controller\AppController;
use Cake\Event\Event;

class MerchantsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');
        $this->loadModel('Webfronts');
        $this->loadModel('WebfrontFields');
        $this->loadModel('WebfrontPaymentAttributes');
        $this->loadModel('SubMerchants');
        $this->loadModel('MerchantProfiles');
        $this->loadModel('SplitSettlements');
        $this->loadModel('SplitSettlementMappings');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('admin');
        $this->Auth->allow(['login']);
        $action = $this->request->params['action'];
        if (!in_array($action, ['login'])) {
            if (!$this->Auth->user('id')) {
                return $this->redirect(HTTP_ROOT);
            } else if ($this->Auth->user('type') != 1) {
                throw new UnauthorizedException;
            }
        }
    }

    public function ajaxAddSplitSettlement() {
        $data = $this->request->data;
        if (!empty($data['payment_filed'])) {
            $splitSettlement = $this->SplitSettlements->newEntity();
            $splitSettlement->merchant_id = $data['merchant_id'];
            $splitSettlement->webfront_id = $data['webfront_id'];
            $this->SplitSettlements->save($splitSettlement);
            foreach ($data['payment_filed'] as $key => $value) {
                $splitSettlementMapping = $this->SplitSettlementMappings->newEntity();
                $splitSettlementMapping->split_settlement_id = $splitSettlement->id;
                $splitSettlementMapping->webfront_payment_attribute_id = $key;
                $splitSettlementMapping->sub_merchant_id = $value;
                $this->SplitSettlementMappings->save($splitSettlementMapping);
            }
            echo json_encode(['status' => 'success', 'msg' => 'SplitSettlement Added Successfully!!']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured. Please try again!!']);
        }
        exit;
    }

    public function ajaxGetSplitSettlements($id = NULL) {
        $splitSettlements = $this->SplitSettlements->find()->contain(['Users', 'Webfronts']);
        if ($splitSettlements->count() > 0) {
            echo json_encode(['status' => 'success', 'split_settlements' => $splitSettlements]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxDeleteSplitSettlements($id = NULL) {
        $this->viewBuilder()->layout('ajax');
        $entity = $this->SplitSettlements->get($id);
        if ($this->SplitSettlements->delete($entity)) {
            echo json_encode(['status' => 'success', 'msg' => 'Split Settlement deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', "Some error occured. Please try again!!"]);
        }
        exit;
    }

    public function ajaxGetSplitSettlement($id = NULL) {
        $splitSettlement = $this->SplitSettlements->find()->contain(['SplitSettlementMappings'])->where(['SplitSettlements.id' => $id])->first();
        if (!empty($splitSettlement)) {
            echo json_encode(['status' => 'success', 'split_settlement' => $splitSettlement]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxNameAvail() {
        $this->viewBuilder()->layout('ajax');
        $name = urldecode(trim($this->request->query['name']));
        $query = $this->Users->find()->where(['name' => $name]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'success', 'avail' => 1]);
        } else {
            echo json_encode(['status' => 'success', 'avail' => 0]);
        }
        exit;
    }

    //Check Merchnat Email availibility
    public function ajaxEmailAvail() {
        $this->viewBuilder()->layout('ajax');
        $email = urldecode(trim($this->request->query['email']));
        $query = $this->Users->find()->where(['email' => $email, 'type !=' => 4]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'success', 'avail' => 1]);
        } else {
            echo json_encode(['status' => 'success', 'avail' => 0]);
        }
        exit;
    }

    public function ajaxAddMerchant() {

        $data = $this->request->data;
        $password = trim($data['merchant']['password']);
        $confirmPassword = trim($data['merchant']['confirm_password']);

        if ($password != $confirmPassword) {
            echo json_encode(['status' => 'error', 'msg' => 'Password & Retype Password does\'t  match.']);
            exit;
        }

        $email = filter_var($data['merchant']['email'], FILTER_SANITIZE_EMAIL);
        $phone = trim($data['merchant']['phone']);

        $query = $this->Users->find()->where(['Users.email' => $email, 'Users.type IN' => [1, 2, 3]]);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'error', 'msg' => 'Email Not Available!!.']);
            exit;
        }

        $query = $this->Users->find()->where(['Users.phone' => $phone, 'Users.type IN' => [1, 2, 3]]);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'error', 'msg' => 'Phone No. Not Available!!.']);
            exit;
        }

        $user = $this->Users->newEntity();
        $user->uniq_id = $this->Custom->generateUniqNumber();
        $user->name = $data['merchant']['name'];
        $user->email = $email;
        $user->password = $password;
        $user->phone = $phone;
        $user->type = 3;
        $user->is_active = 1;
        $this->Users->save($user);

        $merchantProfile = $this->MerchantProfiles->newEntity();
        $merchantProfile = $this->MerchantProfiles->patchEntity($merchantProfile, $data['merchant_profile']);
        $merchantProfile->merchant_id = $user->id;
        $merchantProfile->logo = '';

        if ($this->MerchantProfiles->save($merchantProfile)) {

            if (isset($data['croppedImage']) && !empty($data['croppedImage'])) {
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['croppedImage']));
                if ($data) {
                    $logo = time() . rand(100, 999) . '.png';
                    file_put_contents(MERCHANT_LOGO . $logo, $data);
                    if ($logo) {
                        $merchantProfile->logo = $logo;
                        $this->MerchantProfiles->save($merchantProfile);
                    }
                }
            }

            echo json_encode(['status' => 'success', 'msg' => 'Merchant added successfully!!.']);
        } else {
            $this->Users->delete($user);
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured.Please try again!!.']);
        }
        exit;
    }

    public function ajaxAddMerchantXXX() {

        $data = $this->request->data;
        $password = trim($data['merchant']['password']);
        $confirmPassword = trim($data['merchant']['confirm_password']);

        if ($password != $confirmPassword) {
            echo json_encode(['status' => 'error', 'msg' => 'Password & Retype Password does\'t  match.']);
            exit;
        }

        $email = $data['merchant']['email'];
        $query = $this->Users->find()->where(['Users.email' => $email, 'Users.type IN' => [1, 2, 3]]);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'error', 'msg' => 'Email not Available!!.']);
            exit;
        }

        $user = $this->Users->newEntity();
        $user->uniq_id = $this->Custom->generateUniqNumber();
        $user->name = $data['merchant']['name'];
        $user->email = $email;
        $user->password = $password;
        $user->phone = "";
        $user->type = 3;
        $user->is_active = 1;

        if ($this->Users->save($user)) {
            $merchantProfile = $this->MerchantProfiles->newEntity();
            $merchantProfile = $this->MerchantProfiles->patchEntity($merchantProfile, $data['merchant_profile']);
            $merchantProfile->merchant_id = $user->id;
            $merchantProfile->logo = '';
            if (isset($data['croppedImage']) && !empty($data['croppedImage'])) {
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['croppedImage']));
                if ($data) {
                    $logo = time() . rand(100, 999) . '.png';
                    file_put_contents(MERCHANT_LOGO . $logo, $data);
                    if ($logo) {
                        $merchantProfile->logo = $logo;
                    }
                }
            }
            $this->MerchantProfiles->save($merchantProfile);
            echo json_encode(['status' => 'success', 'msg' => 'Merchant added successfully!!.']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured.Please try again!!.']);
        }
        exit;
    }

    public function ajaxFetchMerchants() {
        $query = $this->Users->find()->contain(['MerchantProfiles'])->where(['Users.type' => 3, 'Users.access' => 1])->order(['Users.id' => 'DESC']);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'success', 'merchants' => $query]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxGetEditMerchant($id = NULL) {
        $query = $this->Users->find()->contain(['MerchantProfiles'])->where(['Users.id' => $id]);
        if ($query->count() > 0) {
            $user = $query->first();
            $user['password'] = '';
            echo json_encode(['status' => 'success', 'data' => $user]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxEditMerchant($id = NULL) {
        $data = $this->request->data;

        $name = $data['merchant']['name'];
        $email = filter_var($data['merchant']['email'], FILTER_SANITIZE_EMAIL);
        $phone = trim($data['merchant']['phone']);

        $query = $this->Users->find()->where(['Users.id !=' => $id, 'Users.email' => $email, 'Users.type IN' => [1, 2, 3]]);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'error', 'msg' => 'Email Not Available!!.']);
            exit;
        }
        $query = $this->Users->find()->where(['Users.id !=' => $id, 'Users.phone' => $phone, 'Users.type IN' => [1, 2, 3]]);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'error', 'msg' => 'Phone No. Not Available!!.']);
            exit;
        }


        $fields = ['name' => $name, 'email' => $email, 'phone' => $phone];
        $isUpdated = $this->Users->query()->update()->set($fields)->where(['id' => $id])->execute();

        $oldLogo = @$data['merchant_profile']['logo'];

        if ($isUpdated) {

            if (empty($data['merchant_profile']['id'])) {
                $merchantProfile = $this->MerchantProfiles->newEntity();
                $merchantProfile->merchant_id = $id;
                $this->MerchantProfiles->save($merchantProfile);
                $merchantId = $merchantProfile->id;
            } else {
                $merchantId = $data['merchant_profile']['id'];
            }

            $fields = [
                //'phone' => $data['merchant_profile']['phone'],
                'address' => $data['merchant_profile']['address'],
                'description' => $data['merchant_profile']['description'],
                'payuid' => $data['merchant_profile']['payuid'],
                'website' => $data['merchant_profile']['website'],
                'facebook_url' => $data['merchant_profile']['facebook_url'],
                'twitter_url' => $data['merchant_profile']['twitter_url'],
                'convenience_fee_amount' => $data['merchant_profile']['convenience_fee_amount'],
                'payu_key' => $data['merchant_profile']['payu_key'],
                'payu_salt' => $data['merchant_profile']['payu_salt'],
                'regd_no' => $data['merchant_profile']['regd_no'],
                'city' => $data['merchant_profile']['city'],
                'state' => $data['merchant_profile']['state'],
                'country' => $data['merchant_profile']['country'],
//                'contact1_name' => $data['merchant_profile']['contact1_name'],
//                'contact1_email' => $data['merchant_profile']['contact1_email'],
//                'contact1_phone' => $data['merchant_profile']['contact1_phone'],
//                'contact2_name' => $data['merchant_profile']['contact2_name'],
//                'contact2_email' => $data['merchant_profile']['contact2_email'],
//                'contact2_phone' => $data['merchant_profile']['contact2_phone'],
            ];

            if (!empty($data['croppedImage'])) {
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['croppedImage']));
                if ($data) {
                    $logo = time() . rand(100, 999) . '.png';
                    file_put_contents(MERCHANT_LOGO . $logo, $data);
                    if ($logo) {
                        $fields['logo'] = $logo;
                        if (!empty($oldLogo)) {
                            if (is_file(MERCHANT_LOGO . $oldLogo) && file_exists(MERCHANT_LOGO . $oldLogo)) {
                                unlink(MERCHANT_LOGO . $oldLogo);
                            }
                        }
                    }
                }
            }

            $this->MerchantProfiles->query()->update()->set($fields)->where(['id' => $merchantId])->execute();

            $merchant = $this->Users->get($id, ['contain' => ['MerchantProfiles']]);
            echo json_encode(['status' => 'success', 'msg' => 'Merchant updated successfully!!.', 'merchant' => $merchant]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured,try later.']);
        }
        exit;
    }

    public function ajaxEditMerchantXX($id = NULL) {
        $data = $this->request->data;

        $name = $data['merchant']['name'];
        $email = trim($data['merchant']['email']);
        $fields = ['name' => $name, 'email' => $email, 'phone' => ''];
        $isUpdated = $this->Users->query()->update()->set($fields)->where(['id' => $id])->execute();

        $oldLogo = @$data['merchant_profile']['logo'];
        $convenience_fee_amount = $data['merchant_profile']['convenience_fee_amount'];
//        $user = $this->Users->newEntity();
//        $user->id = $id;
//        $user->name = $data['merchant']['name'];
//        $user->email = trim($data['merchant']['email']);
//        if ($this->Users->save($user)) {

        if (true || $isUpdated) {

            $merchantProfile = $this->MerchantProfiles->newEntity();
            $merchantProfile = $this->MerchantProfiles->patchEntity($merchantProfile, $data['merchant_profile']);
            $merchantProfile->merchant_id = $id;
            if (!empty($data['croppedImage'])) {
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['croppedImage']));
                if ($data) {
                    $logo = time() . rand(100, 999) . '.png';
                    file_put_contents(MERCHANT_LOGO . $logo, $data);
                    if ($logo) {
                        $merchantProfile->logo = $logo;
                        if (!empty($oldLogo)) {
                            if (is_file(MERCHANT_LOGO . $oldLogo) && file_exists(MERCHANT_LOGO . $oldLogo)) {
                                unlink(MERCHANT_LOGO . $oldLogo);
                            }
                        }
                    }
                }
            }
            $this->MerchantProfiles->save($merchantProfile);
            //print_r($merchantProfile);exit;
            $this->MerchantProfiles->query()->update()->set(['convenience_fee_amount' => $convenience_fee_amount])->where(['id' => $merchantProfile->id])->execute();
            $merchant = $this->Users->get($id, ['contain' => ['MerchantProfiles']]);
            echo json_encode(['status' => 'success', 'msg' => 'Merchant updated successfully!!.', 'merchant' => $merchant]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured,try later.']);
        }
        exit;
    }

    public function ajaxDeleteMerchant($id = NULL) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Users->find()->where(['Users.id' => $id]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error']);
            exit;
        }
        $entity = $this->Users->get($query->first()->id);
        if ($this->Users->delete($entity)) {
            echo json_encode(['status' => 'success', 'msg' => 'Merchant deleted successfully']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxInActivateMerchant($id = NULL) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Users->find()->where(['Users.id' => $id]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error', 'User id is not present']);
            exit;
        } else {
            $this->Users->query()->update()->set(['is_active' => 0])->where(['id' => $id])->execute();
            $merchants = $this->Users->find()->contain(['MerchantProfiles'])->where(['Users.type' => 3, 'Users.access' => 1])->order(['Users.id' => 'DESC']);
            echo json_encode(['status' => 'success', 'msg' => 'Merchant In-activated successfully.', 'merchants' => $merchants]);
        }
        exit;
    }

    public function ajaxActivateMerchant($id = NULL) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Users->find()->where(['Users.id' => $id]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error', 'msg' => 'User id is not present']);
            exit;
        } else {
            $this->Users->query()->update()->set(['is_active' => 1])->where(['id' => $id])->execute();
            $merchants = $this->Users->find()->contain(['MerchantProfiles'])->where(['Users.type' => 3, 'Users.access' => 1])->order(['Users.id' => 'DESC']);
            echo json_encode(['status' => 'success', 'msg' => 'Merchant activated successfully.', 'merchants' => $merchants]);
        }
        exit;
    }

    /////////////////////////////////////////////
    public function ajaxAddSubMerchant() {
        $data = $this->request->data;
        $subMerchant = $this->SubMerchants->newEntity();
        $subMerchant = $this->SubMerchants->patchEntity($subMerchant, $data['submerchant']);
        if ($this->SubMerchants->save($subMerchant)) {

            $apiUrl = 'https://www.payumoney.com/auth/op/oneStepRegisterMerchant?externalMerchantId=[MERCHANT_ID]&merchantEmail=shashwat.tiwari@payu.in&merchantPhone=6123445612&merchantName=[MERCHANT_NAME]&panCardNo=ABCDE1231F&businessRegisteredAddress={"addressLine":"12 skdfhskf","city":"Gurgaon","state":"Haryana","zipcode":"122001"}&businessOperationAddress={"addressLine":"12 skdfhskf","city":"Gurgaon","state":"Haryana","zipcode":"122001"}&category=Ecommerce&businessFillingStatus=Individual&contactEmail=[CONTACT_EMAIL]&contactName=Shashwat&accountNumber=123456789012348&payeeName=abc&payeeBankName=ABHYUDAYA  COOPERATIVE BANK LIMITED&payeeIFSCCode=ABHY0065001&payeeBankAccountType=Current&payeeBankBranch=RTGS-HO&payeeBankBranchCity=GREATER MUMBAI&payeeBankBranchState=MAHARASHTRA&merchantNEFTPreformaCode=dssfg&merchantRTGSPreformaCode=sbdb&tdrCharges=&bulkFlag=0';
            $apiUrl = str_replace("[MERCHANT_ID]", $subMerchant->payumid, $apiUrl);
            $apiUrl = str_replace("[CONTACT_EMAIL]", $subMerchant->email, $apiUrl);
            $apiUrl = str_replace("[MERCHANT_NAME]", $subMerchant->name, $apiUrl);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, []);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                $sad = curl_error($ch);
                throw new \Exception($sad);
            }
            $response = json_decode($result, true);
            curl_close($ch);

            if ($response['status'] == '0') {
                $subMerchant->result = $response['result'];
                $this->SubMerchants->save($subMerchant);
                echo json_encode(['status' => 'success', 'msg' => $response['message']]);
            } else {
                $this->SubMerchants->delete($subMerchant);
                echo json_encode(['status' => 'error', 'msg' => $response['message']]);
            }
            //            echo json_encode(['status' => 'success', 'msg' => 'Sub-Merchant added succesasfully!!.']);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured.Please try again!!.']);
        }
        exit;
    }

    public function ajaxFetchSubMerchants() {
        $data = $this->request->data;
        $conditions = [];
        $keyword = !empty($data['keyword']) ? trim($data['keyword']) : '';
        if (!empty($data['searchby']) && $data['searchby'] == 'merchant') {
            $conditions[] = ['Users.name LIKE' => "%" . $keyword . "%"];
        } else if (!empty($data['searchby']) && $data['searchby'] == 'submerchant') {
            $conditions[] = ['SubMerchants.name LIKE' => "%" . $keyword . "%"];
        }
        $submerchants = $this->SubMerchants->find('all')->where($conditions)->contain(['Users'])->order(['SubMerchants.id' => 'DESC']);
        echo json_encode(['status' => 'success', 'submerchants' => $submerchants]);
        exit;
    }

    public function ajaxDeleteSubMerchant($id = NULL) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->SubMerchants->find()->where(['SubMerchants.id' => $id]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error']);
            exit;
        }
        $entity = $this->SubMerchants->get($query->first()->id);
        if ($this->SubMerchants->delete($entity)) {
            echo json_encode(['status' => 'success', 'msg' => 'SubMerchant deleted successfully']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxGetSubMerchantDetails($id = NULL) {
        $query = $this->SubMerchants->find()->where(['SubMerchants.id' => $id])->contain(['Users']);
        if ($query->count()) {
            echo json_encode(['status' => 'success', 'submerchant' => $query->first()]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxEditSubMerchant($id = NULL) {
        $data = $this->request->data;
        $subMerchant = $this->SubMerchants->newEntity();
        $subMerchant->id = $data['submerchant']['id'];
        $subMerchant->merchant_id = $data['merchant_id'];
        $subMerchant->name = $data['submerchant']['name'];
        if ($this->SubMerchants->save($subMerchant)) {
            $submerchant = $this->SubMerchants->get($subMerchant->id);
            echo json_encode(['status' => 'success', 'msg' => 'SubMerchant updated successfully.', 'submerchant' => $submerchant]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured,try later.']);
        }
        exit;
    }

    public function ajaxGetAllMerchants() {
        $query = $this->Users->find()->where(['Users.type' => 3, 'Users.access' => 1])->order(['Users.name' => 'DESC']);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'success', 'merchants' => $query]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxWebfronts($merchantId) {
        $webfronts = $this->Webfronts->find()->where(['Webfronts.merchant_id' => $merchantId, 'Webfronts.is_deleted !=' => 1])->order(['Webfronts.id' => 'DESC']);
        echo json_encode(['status' => 'success', 'webfronts' => $webfronts]);
        exit;
    }

    public function ajaxFetchPaymentFields($webfrontId) {
        $paymentFileds = $this->WebfrontPaymentAttributes->find('all')->where(['webfront_id' => $webfrontId])->order(['id' => 'DESC']);
        $webfront = $this->Webfronts->get($webfrontId);
        $submerchants = $this->SubMerchants->find('all')->where(['SubMerchants.merchant_id' => $webfront->merchant_id])->order(['SubMerchants.id' => 'DESC']);
        if ($paymentFileds->count() > 0) {
            echo json_encode(['status' => 'success', 'payment_fileds' => $paymentFileds, 'submerchants' => $submerchants]);
        } else {
            echo json_encode(['status' => 'success', 'payment_fileds' => [], 'submerchants' => []]);
            //echo json_encode(['status' => 'error']);
        }
        exit;
    }

}
