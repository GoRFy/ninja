<?php

class Helpers
{
  /**
   * Creates token based on username and email
   * @param array
   * @return string
   */
  public function createToken($user)
  {
    return md5($user["id"] . $user["email"] . $user["username"] . SALT . date("Ymd"));
  }

  /**
    * Create a JSON header to return the message for the ajax-form
    * @param string
    * @return json
    */
  public function getMessageAjaxForm($message,$other="none",$valueWithOther="none",$classe="none"){
    http_response_code(200);
    $response["status"] = "success";
    $response["message"] = $message;
    $response["other"] = $other;
    $response["valueWithOther"] = $valueWithOther;
    $response["classe"] = $classe;

    header('Content-type: application/json');
    echo json_encode($response);
  }


}
