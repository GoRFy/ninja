<?php

class landingController {
  public function welcomeAction ($args) {
    $view = new View();
    $view->setView("landing/landing.tpl", "empty");
  }

  public function legalsAction ($args) {
    $view = new View();
    $view->setView("landing/legals.tpl");
  }

  public function planAction ($args) {
    $view = new View();
    $view->setView("landing/plan.tpl");
  }

}
