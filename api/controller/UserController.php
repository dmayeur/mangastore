<?php

class UserController extends CoreController{
    protected $model;
    protected $request;

    protected $login;

    protected $username;
    protected $password;
    protected $email;

    protected $firstname = null;
    protected $lastname = null;
    protected $address = null;
    protected $zipCode = null;
    protected $city = null;


    public function __construct($request) {

        $this->request = $request;
        $this->model = new UserModel();

        if($this->request->getMethod()==='GET'){
            $this->queryURLtoParameters($this->request->getBody());
        } else {
            $this->bodyRequestToParameters($this->request->getBody());
        }

    }


    public function bodyRequestToParameters($body){
        foreach ($body as $key => $value) {
            switch ($key) {
                case 'login':
                    $this->login=$value;
                    break;
                case 'password':
                    $this->password=$value;
                    break;
                case 'username':
                    $this->username= $value;
                    break;
                case 'email':
                    $this->email= $value;
                    break;
                case 'address':
                    $this->address= $value;
                    break;
                case 'zipcode':
                    $this->zipCode= $value;
                    break;
                case 'city':
                    $this->city= $value;
                    break;
            }
        }
    }

    public function queryURLtoParameters($query) {
        if(empty($query)){
            return;
        }

        //the main controller already split each query part into an array
        foreach ($query as $queryPart) {

            //The parts of the query are separated by an =
            list($key,$value) = explode("=",$queryPart);

            //we do a switch to do a whitelist of acceptable parameters (others are just ignored)
            switch ($key) {
                case 'login':
                    $this->login=$value;
                    break;
                case 'password':
                    $this->password=$value;
                    break;
                case 'username':
                    $this->username= $value;
                    break;
                case 'email':
                    $this->email= $value;
                    break;
            }
        }
    }


    public function getByUsername($id) {
        $serie = $this->model->getByUsername($id);
    }

    public function createAccount() {

        $user = $this->model->getByEmail($this->email);

        if(!$user){
            $user = $this->model->getByUsername($this->username);
        } else {
            $this->setHttpHeaders(403);

            $message = [
                'errorMessage' =>  "L'email est déjà utilisé."
            ];

            $message = json_encode($message, JSON_FORCE_OBJECT);
            echo $message;
            exit();
        }

        //
        if($user) {
            $this->setHttpHeaders(403);
            $message = [
                'errorMessage' =>  "Le nom d'utilisateur est déjà utilisé."
            ];
            $message = json_encode($message, JSON_FORCE_OBJECT);
            echo $message;
            exit();
        }

        $account = [
            $this->username,
            password_hash($this->password, PASSWORD_BCRYPT),
            $this->email,
            $this->firstname,
            $this->lastname,
            $this->address,
            $this->zipCode,
            $this->city
        ];

        $this->model->createAccount($account);
    }

    public function login() {
        $user = $this->model->getByEmail($this->login);
        if(!$user) {
            $user = $this->model->getByUsername($this->login);
        }

        if(!$user) {
            $this->setHttpHeaders(403);
            $message = [
                'errorMessage' =>  "Le nom d'utilisateur ou l'email n'existe pas."
            ];
            $message = json_encode($message, JSON_FORCE_OBJECT);
            echo $message;
            exit;
        }

        if( password_verify($this->password, $user['password']) ) {

            $this->setHttpHeaders(200);
            $userInfos['username'] = $user['username'];
            $userInfos['email'] = $user['email'];
            $userInfos['role'] = $user['role'];
            $auth = new Auth($userInfos);
            $message = [
                'message' =>  "Connexion réussie",
                'token' => $auth->encode(),
                'role' => $userInfos['role']
            ];
            
            $message = json_encode($message, JSON_FORCE_OBJECT);
            echo $message;
            exit;

        } else {

            $this->setHttpHeaders(401);
            $message = [
                'errorMessage' =>  "Le mot de passe est incorrect."
            ];
            $message = json_encode($message, JSON_FORCE_OBJECT);
            echo $message;
            exit;

        }
    }

}
