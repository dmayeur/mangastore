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


    public function __construct() {
        $this->model = new UserModel();
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


    public function getByUsername($id) {
        $serie = $this->model->getByUsername($id);
    }

    public function createAccount($body) {
        $this->bodyRequestToParameters($body);

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

    public function login($body) {
        $this->bodyRequestToParameters($body);

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

            // $this->setHttpHeaders(200);
            $userInfos['username'] = $user['username'];
            $userInfos['email'] = $user['email'];
            $userInfos['role'] = $user['role'];
            $userInfos['id'] = $user['id'];
            $auth = new Auth();
            $message = [
                'message' =>  "Connexion réussie",
                'token' => $auth->encode($userInfos),
                'role' => $userInfos['role']
            ];

            $this->sendResponse(200,$message);

        } else {
            $this->sendResponse(401, [
                'errorMessage' =>  "Le mot de passe est incorrect."
            ]);
        }
    }

    public function isAdmin() {
        //The role check is done with the router, so if we are here it means the user is an admin
        $this->sendResponse(204,'The user is admin');
    }

    /**
     * [getUser get the user info thanks to a token]
     */
    public function getUser(){
        $auth = new Auth();
        try {
            $user = $auth->headerToken();
        } catch (Exception $e) {
            throw new RestException("Erreur d'authentication",401);
        }

        $userInfos = $this->model->getDetails($user->id);

        if($userInfos){
            $this->sendResponse(200, $userInfos);
        } else {
            $this->sendResponse(404,[
                "errorMessage" => 'Aucun utilisateur trouvé.'
            ]);
        }
    }

    /**
     * [getReview get the review for a serie for a user]
     */
    public function getReview($id){
        $auth = new Auth();
        try {
            $user = $auth->headerToken();
        } catch (Exception $e) {
            throw new RestException("Erreur d'authentication",401);
        }

        $reviewModel = new ReviewModel();
        $review = $reviewModel->getReview($id,$user->id);

        if($review){
            $this->sendResponse(200, $review);
        } else {
            $this->sendResponse(404,[
                "errorMessage" => 'Aucune critique trouvé.'
            ]);
        }
    }


}
