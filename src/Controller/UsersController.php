<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Validation\Validation;
use Cake\Datasource\ConnectionManager;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');
        $this->loadModel('Users');
        $this->loadModel('ForgotPasswordOtps');
        $this->loadModel('AdminSettings');
        $this->loadModel('MailTemplates');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
//        $this->viewBuilder()->layout('customer');
        $this->Auth->allow(['login', 'logout', 'ajaxCheckLogin', 'forgotPassword', 'forgotPasswordOtp', 'resendOtp', 'resetPassword']);
    }

//Forgot password section Starts here by prakash
    public function forgotPassword() {
        if ($this->request->is('post')) {
            $phone = trim($this->request->data['phone']);
            $query = $this->Users->find()->where(['Users.type !=' => 4, 'OR' => [['Users.phone' => $phone], ['Users.email' => $phone]]]);
            if ($query->count() <= 0) {
                $this->Flash->error(__("Phone/Email does't exist!!."));
            } else {
                $userDetails = $query->first();
                $otp = $this->ForgotPasswordOtps->newEntity();
                $otp->uniqid = $this->Custom->generateUniqId();
                $otp->user_id = $userDetails->id;
                $otp->otp = $this->Custom->generateOTP();
                $otp->created = time();
                if ($this->ForgotPasswordOtps->save($otp)) {
                    $this->_sendOtp($otp->uniqid);
                    $this->Flash->success(__('OTP sent successfully. Please check your mail!!.'));
                    return $this->redirect(HTTP_ROOT . "forgot-password-otp/{$otp->uniqid}");
                } else {
                    $this->Flash->error(__('Some error occured.Please try again!!'));
                    return $this->redirect($this->referer());
                }
            }
        }
    }

    public function _sendOtp($uniqid) {

        $getOtp = $this->ForgotPasswordOtps->find()->where(['ForgotPasswordOtps.uniqid' => $uniqid])->contain(['Users'])->first();
        $adminSetting = $this->AdminSettings->find()->where(['id' => 1])->first();

        /* ======================For SMS Sending Starts here=================================== */
        if (!empty($getOtp->user->phone)) {
            $phone = $getOtp->user->phone;
            $sms = "Your otp is [OTP].";
            $message = $this->Custom->formatEmail($sms, [
                'OTP' => $getOtp->otp
            ]);
            $this->Custom->sendSMS($phone, $message, 'otp');
        }
        /* ======================For SMS Sending Ends here==================================== */

        $mailTemplate = $this->MailTemplates->find()->where(['name' => 'FORGOT_PASSWORD_OTP', 'is_active' => 1])->first();
        $message = $this->Custom->formatEmail($mailTemplate['content'], [
            'NAME' => $getOtp->user->name,
            'OTP' => $getOtp->otp
        ]);
        $this->Custom->sendEmail($getOtp->user->email, $adminSetting->from_email, $mailTemplate->subject, $message, $adminSetting->bcc_email);


        return TRUE;
    }

    public function resendOtp($uniqid) {
        $this->viewBuilder()->layout('');
        $this->_sendOtp($uniqid);
        $this->Flash->success(__('OTP Resent Successfully, Please check your mail!!.'));
        return $this->redirect($this->referer());
    }

    public function forgotPasswordOtp($uniqid = NULL) {
        $query = $this->ForgotPasswordOtps->find()->where(['ForgotPasswordOtps.uniqid' => $uniqid]);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }
        if ($this->request->is('post')) {
            $getOtp = $query->contain(['Users'])->first();
            $otp = $this->request->data['otp'];
            if ($getOtp->otp == $otp) { //echo 'Jai Jagannath Swami';exit;
                $qstr = $this->Custom->generateUniqId();
                $status = $this->Users->query()->update()->set(["qstr" => $qstr])->where(['id' => $getOtp->user->id])->execute();
                if ($status) {
                    //$this->_forgotPasswordMail($getOtp->user->id);
                    //$this->Flash->success(__("OTP validated successfully!!.,Please check your email for reset your password."));
                    return $this->redirect(HTTP_ROOT . "reset-password/" . $getOtp->user->uniq_id . "/" . $qstr);
                } else {
                    $this->Flash->error(__('Some error occured.Please try again!!'));
                    return $this->redirect($this->referer());
                }
            } else {
                $this->Flash->error(__('Invalid OTP!!'));
                return $this->redirect($this->referer());
            }
        }
    }

    public function _forgotPasswordMail($userId) {
        $adminSetting = $this->AdminSettings->find()->where(['id' => 1])->first();
        $mailTemplate = $this->MailTemplates->find()->where(['name' => 'FORGOT_PASSWORD_MAIL', 'is_active' => 1])->first();
        $userDetails = $this->Users->find()->where(['Users.id' => $userId])->first();
        $text_link = HTTP_ROOT . "reset-password/" . $userDetails->uniq_id . "/" . $userDetails->qstr;
        $link = "<a targrt='_blank' style='background: none repeat scroll 0 0 #C20E09; border-radius: 4px;color: #FFFFFF;display: block;font-size: 14px; font-weight: bold;margin: 15px 1px;padding: 5px 10px;text-align: center;width: 232px;text-decoration:none;' href='" . $text_link . "'>Click here to change your password</a>";
        $message = $this->Custom->formatForgotPassword($mailTemplate['content'], $userDetails->name, $text_link, $link);
        $this->Custom->sendEmail($userDetails->email, $adminSetting->from_email, $mailTemplate->subject, $message, $adminSetting->bcc_email);
        return TRUE;
    }

    public function resetPassword($uniq_id = NULL, $qstr = NULL) {
        $query = $this->Users->find()->where(['Users.uniq_id' => $uniq_id, 'Users.qstr' => $qstr]);
        if ($query->count() <= 0) {
            $this->Flash->error(__('Invalid Link!!'));
            return $this->redirect(HTTP_ROOT);
        }

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $password = $data['password'];
            $confPassword = $data['conf_password'];
            if (strlen($password) <= 8) {
                $this->Flash->error(__('Password length should not be less than 8 character!!'));
                return $this->redirect($this->referer());
            } else if ($password != $confPassword) {
                $this->Flash->error(__("Password & Confrim password does't matches!!"));
                return $this->redirect($this->referer());
            } else {
                $getUser = $this->Users->find()->where(['Users.uniq_id' => $uniq_id])->first();
                $user = $this->Users->newEntity();
                $user->password = $password;
                $user->qstr = '';
                $user->id = $getUser->id;
                if ($this->Users->save($user)) {
                    $this->Auth->setUser($this->Users->get($getUser->id));
                    $this->ForgotPasswordOtps->deleteAll(['ForgotPasswordOtps.user_id' => $getUser->id]);
                    return $this->redirect(HTTP_ROOT);
                }
            }
        }
    }

//Forgot password section ends here by prakash

    public function ajaxCheckLogin() {
        $this->viewBuilder()->layout('ajax');
        if ($this->Auth->user('id')) {
            echo json_encode(['status' => 'loggedin', 'user' => $this->Auth->user()]);
        } else {
            echo json_encode(['status' => 'loggedout']);
        }
        exit;
    }

    public function login() {
        $this->viewBuilder()->layout('');
        //Redirect if Alreday Login
        if ($this->Auth->user('id')) {
            if ($this->Auth->user('type') == 1) {
                return $this->redirect(HTTP_ROOT . 'admin/#/dashboard');
            } else if ($this->Auth->user('type') == 2) {
                return $this->redirect(HTTP_ROOT . 'branchadmin/#/dashboard');
            } else if ($this->Auth->user('type') == 3) {
                return $this->redirect(HTTP_ROOT . 'merchant/#/dashboard');
            } else {
                return $this->redirect(HTTP_ROOT . 'customer/#/payment-and-bills');
            }
        }
        //Login and Redirect to appropriate user dashboard
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->request->data['username'] = trim($this->request->data['username']);
            $this->request->data['password'] = trim($this->request->data['password']);
            if (Validation::email($this->request->data['username'])) {
                $this->Auth->config('authenticate', [
                    'Form' => [
                        'fields' => ['username' => 'email'],
                        'scope' => ['type !=' => 4]
                    ]
                ]);
                $this->Auth->constructAuthenticate();
                $this->request->data['email'] = $this->request->data['username'];
                unset($this->request->data['username']);
            }

            $user = $this->Auth->identify();
            if ($user && in_array($user['type'], [1, 2, 3])) {

                if (!empty($data['rememberme'])) {
                    $rememberme = urlencode(base64_encode($user['id'] . '-' . $user['uniq_id']));
                    setcookie('rememberme', $rememberme, time() + (86400 * 30), "/"); //For 30 day setting cookie
                }

                if ($user['type'] == 3 && in_array($user['access'], [2, 3])) {
                    $mainMerchant = $this->Users->get($user['created_by']);
                    if (empty($mainMerchant)) {
                        $this->Flash->error(__('Invalid Email or Password, try again'));
                        return $this->redirect($this->referer());
                    }
                    $mainMerchant->access = $user['access'];
                    $mainMerchant->submerchant = $user;
                    $user = $mainMerchant->toArray();
                }

                $this->Auth->setUser($user);
                $this->Flash->success(__('Logged in successfully.'));

                //User Login Information//           
                $ip = $this->Custom->getRealIpAddress();
                $date = date('Y-m-d H:i:s');
                $this->loadModel('UserLogins');
                $query = $this->UserLogins->find()->where(['user_id' => $this->Auth->user('id')])->order(['UserLogins.id' => 'DESC']);
                if ($query->count() > 0) {
                    $userLogin = $query->first();
                    $this->Users->query()->update()->set(['last_login_date' => $userLogin->login_date, 'last_login_ip' => $userLogin->login_ip])->where(['id' => $this->Auth->user('id')])->execute(); //
                } else {
                    $this->Users->query()->update()->set(['last_login_date' => $date, 'last_login_ip' => $ip])->where(['id' => $this->Auth->user('id')])->execute(); //
                }
                $userLogin = $this->UserLogins->newEntity();
                $userLogin->user_id = $this->Auth->user('id');
                $userLogin->login_ip = $ip;
                $userLogin->login_date = $date;
                $this->UserLogins->save($userLogin);
                $conn = ConnectionManager::get('default');
                $stmt = $conn->execute("DELETE FROM `user_logins` WHERE id NOT IN (SELECT id FROM (SELECT id FROM `user_logins` ORDER BY id DESC  LIMIT 2) ul)");
                //User Login Information End// 

                if ($this->Auth->user('type') == 1) {
                    return $this->redirect(HTTP_ROOT . 'admin/#/dashboard');
                } else if ($this->Auth->user('type') == 2) {
                    return $this->redirect(HTTP_ROOT . 'branchadmin/#/dashboard');
                } else if ($this->Auth->user('type') == 3) {
                    return $this->redirect(HTTP_ROOT . 'merchant/#/dashboard');
                } else {
                    return $this->redirect(HTTP_ROOT . 'customer/#/payment-and-bills');
                }
            } else {
                $this->Flash->error(__('Invalid Email or Password, try again'));
                $this->redirect($this->referer());
            }
        }
    }

    public function logout() {
        if (isset($_COOKIE['rememberme'])) {
            setcookie("rememberme", $_COOKIE['rememberme'], time() - (86400 * 30), "/"); //Removing cookie
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        session_destroy();
        $this->Auth->logout();
        $this->redirect(HTTP_ROOT);
    }

    public function ajaxChangePasssword() {
        $data = $this->request->data;
        if (empty($data['old_password'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Please enter current password.']);
        } else if (empty($data['password1'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Please enter new password']);
        } else if (strlen($data['password1']) < 6) {
            echo json_encode(['status' => 'error', 'msg' => 'Password length must be greated that 5 character.']);
        } else if ($data['password1'] != $data['password2']) {
            echo json_encode(['status' => 'error', 'msg' => 'Password & Retype Password does\'t  match.']);
        } else {
            if (!empty($this->Auth->user('submerchant.id'))) {
                $user = $this->Users->get($this->Auth->user('submerchant.id'));
            } else {
                $user = $this->Users->get($this->Auth->user('id'));
            }
            $user = $this->Users->patchEntity($user, ['old_password' => $data['old_password'], 'password' => $data['password1'], 'password1' => $data['password1'], 'password2' => $data['password2']], ['validate' => 'password']);
            if ($this->Users->save($user)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Current password is not correct.']);
            }
        }
        exit;
    }

//    public function ajaxGetProfileData($id = null) {
//        $this->viewBuilder()->layout('ajax');
//        $user = $this->Users->find()->where(['Users.id' => $this->Auth->user('id')])->contain([]);
//        if ($user->count() > 0) {
//            $user = $user->first()->toArray();
//            echo json_encode($user);
//        }
//        exit;
//    }
//    public function ajaxUpdateProfile() {
//        $this->viewBuilder()->layout('ajax');
//        $data = $this->request->data;
//        $email = filter_var($data['user']['email'], FILTER_SANITIZE_EMAIL);
//        $user = $this->Users->newEntity();
//        $user->id = $this->Auth->user('id');
//        $user->name = $data['user']['name'];
//        $user->email = $email;
//        $user->phone = $data['user']['phone'];
//        $user->address = $data['user']['address'];
//        if ($this->Users->save($user)) {
//            if (!empty($data['file']['name'])) {
//                $logo = $this->Custom->uploadImage($data['file']['tmp_name'], $data['file']['name'], MERCHANT_LOGO, 300);
//                if ($logo) {
//                    $this->loadModel('MerchantProfiles');
//                    $query = $this->MerchantProfiles->find()->where(['MerchantProfiles.user_id' => $this->Auth->user('id')]);
//                    if ($query->count() > 0) {
//                        $id = $query->first()->id;
//                        $this->MerchantProfiles->query()->update()->set(['logo' => $logo])->where(['id' => $id])->execute(); //
//                    } else {
//                        $merchantProfile = $this->MerchantProfiles->newEntity();
//                        $merchantProfile->user_id = $this->Auth->user('id');
//                        $merchantProfile->logo = $logo;
//                        $this->MerchantProfiles->save($merchantProfile);
//                    }
//                    echo json_encode(['status' => 'success', 'logo' => MERCHANT_LOGO . $logo]);
//                    exit;
//                }
//            }
//            echo json_encode(['status' => 'success']);
//        } else {
//            echo json_encode(['status' => 'error']);
//        }
//        exit;
//    }
}
