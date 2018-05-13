<?php


namespace src\App\Login\Entity;


class LoginEntity
{
    /**
     * @var string
     */
    private $password = '';

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return LoginEntity
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}