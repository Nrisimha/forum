<?php
namespace Shared;

class SalaLogin{
  private $loginUrl    = "http://war2.salagame.com/api/member/op/login";
  private $registerUrl = "http://war2.salagame.com/api/member/op/registe";
  private $forgotUrl   = "http://war2.salagame.com/api/member/op/forgot_pass";

  /**
   * login
   * 
   * @param string $email
   * @param string $password
   * @return boolean
   */
  public function login($email,$password){
    $url = $this->loginUrl
           .'?account='.$email
           .'&password='.$password;
    $content = $this->curl($url);
    $pattern = '/"status":true/s';
    return preg_match($pattern, $content);
  }

  /**
   * forgot
   *
   * @param string $email
   * @return void
   */
  public function forgot($email){
    $url = $this->forgotUrl
           .'?account='.$email;
    $content = $this->curl($url);
    $pattern = '/"status":true/s';
    return preg_match($pattern, $content);
  }//login

  /**
   * register
   *
   * @param string $email
   * @param string $password - minimum lenght 6 char
   * @return void
   */
  public function register($email,$password){
    $url = $this->registerUrl
        .'?account='.$email
        .'&password='.$password
        .'&re_password='.$password;
    $content = $this->curl($url);
    $pattern = '/"status":true/s';
    return preg_match($pattern, $content);
  }//register

  /**
   * curl
   *
   * @param url $url
   * @return void
   */
  private function curl($url){
    $curl_handle=curl_init();
    curl_setopt($curl_handle, CURLOPT_URL,$url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Salagame.net PHP Client');
    $result = curl_exec($curl_handle);
    curl_close($curl_handle);
    return $result;
  }//curl
}