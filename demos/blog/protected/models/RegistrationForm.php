<?php

class RegistrationForm extends CFormModel
{
    public $username;
    public $password;
    public $email;
    public $profile;

    public function rules()
    {
        return array(
            array('username, password, email', 'required'),
            array('email', 'email'),
            array('username, email', 'length', 'max'=>128),
            array('password', 'length', 'max'=>128),
            array('profile', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'profile' => 'Profile',
        );
    }
}
