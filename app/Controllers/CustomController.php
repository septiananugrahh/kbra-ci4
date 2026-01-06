<?php

namespace App\Controllers;

class CustomController extends BaseController
{
  protected $session;
  public function initController($request, $response, $logger)
  {
    parent::initController($request, $response, $logger);
    $this->session = session();
    if (!$this->session->get('logged_in')) {
      $response->redirect('/login')->send();
      exit;
    }
  }

  protected function render(string $contentView, array $data = [])
  {
    $data['content'] = $contentView;
    echo view('layouts/base', $data);
  }
}
