<?php

namespace Drupal\mypage\Controller;

use Drupal\Core\Controller\ControllerBase;

class HomepageController extends ControllerBase
{

  public function home()
  {
    return [
      '#title' => $this->t('Welcome to my site!'),
    ];
  }

}