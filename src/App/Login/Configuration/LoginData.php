<?php


namespace src\App\Login\Configuration;


class LoginData
{
    /**
     * @var string
     */
    private $token;
    
    /**
     * @var string
     */
    private $password;
    
    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $filePath = __DIR__ . '/' . 'login.json';
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
//        $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->password = $data['password'];
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}