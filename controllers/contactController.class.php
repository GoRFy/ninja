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

}
