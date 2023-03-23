<?php

namespace App\Controller;

use App\Infrastructure\Curl\CurlService;
use App\Infrastructure\Curl\Strategy\CurlGetStrategy;
use App\Infrastructure\Curl\Strategy\CurlPostStrategy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CurlController extends AbstractController
{

  public function __construct(
    private CurlService $curlService,
  ) {
  }

  public function get(): Response
  {
    $result = $this->curlService->setStrategy(new CurlGetStrategy())->setUrl('https://dummyjson.com/posts')->doRequest();
    $result2 = $this->curlService->setStrategy(new CurlPostStrategy())
      ->setUrl('https://dummyjson.com/products/add')
      ->setData([
        'title' => 'Some product',
      ])
      ->doRequest();

    return $this->json(['result' => json_decode($result)]);
  }
}
