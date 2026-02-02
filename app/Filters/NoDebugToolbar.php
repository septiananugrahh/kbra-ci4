<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class NoDebugToolbar implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    // Do nothing
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Clean debug toolbar from response
    $body = $response->getBody();

    $body = preg_replace('/<!-- DEBUG-VIEW START.*?-->/s', '', $body);
    $body = preg_replace('/<!-- DEBUG-VIEW ENDED.*?-->/s', '', $body);
    $body = preg_replace('/<script id="debugbar_loader".*?<\/script>/s', '', $body);
    $body = preg_replace('/<script id="debugbar_dynamic_script".*?<\/script>/s', '', $body);
    $body = preg_replace('/<style id="debugbar_dynamic_style".*?<\/style>/s', '', $body);
    $body = preg_replace('/<div id="toolbarContainer".*?<\/div>/s', '', $body);

    return $response->setBody($body);
  }
}
