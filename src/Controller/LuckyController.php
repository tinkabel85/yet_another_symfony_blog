<?php

namespace App\Controller;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends AbstractController
{

  public function __construct(
    private CountryRepository $countryRepository,
    private EntityManagerInterface $entityManager
  ) {
  }

  // public function number(): Response
  // {
  //   $number = random_int(0, 100);

  //   return $this->render('lucky/number.twig', [
  //     'number' => $number,
  //   ]);
  // }

  public function find(): Response
  {
    //var_dump($this->entityManager->getConnection()->fetchAllAssociative('show tables'));
    //die();
    $country = $this->countryRepository->find('AFG');
    
    //update
    // $country->setName(substr(($country->getName()), 0, -2));
    // $this->entityManager->persist($country);
    // $this->entityManager->flush();

    //delete
    // $this->entityManager->remove($country);
    // $this->entityManager->flush();


    //$country = $this->countryRepository->findOneBy(['Code' => 'ABW']);

    // $aruba1 = new Country();
    // $aruba1->setCode('aw2')->setName('Aruba1');
    // $this->entityManager->persist($aruba1);
    // $this->entityManager->flush();

    return $this->render('lucky/number.twig', [
      'country' => $country->getName(),
    ]);
  }
}
