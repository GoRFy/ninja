<?php

class contactController {

  public function createAction ($args) {
    $view = new View();
    $view->setView("user/contact.tpl");

    $contact = new Contact();
    $formContact = $contact->getForm();
    $contactError = [];

    $view->assign("formContact",$formContact);
    $view->assign("contactError",$contactError);
  }


  public function sendMailAction($args){
      $contact = new Contact();
      $contact->setEmail($_POST['Email']);
        $contact->setMessage($_POST['message']);
      $contact->setSubject($_POST['Sujet']);
      $contact->sendEmail();

  }
}
