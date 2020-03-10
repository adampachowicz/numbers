<?php

namespace App\Controller;

use App\Entity\Number;
use App\Form\LargestNumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LargestNumberController extends AbstractController
{
    protected $result = [];
    /**
     * @Route("/")
     */
    public function find(Request $request)
    {
        $number = new Number;
        $number->setContent('1234'."\r". '32534'."\r".'99234'."\r". '32534'."\r".'1234'."\r". '32534'."\r".'99234'."\r". '32534'."\r".'99234'."\r". '32534'."\r");
        $form = $this->createForm(LargestNumberType::class, $number);
        $form->handleRequest($request);

        $number->setContent($form->get('content')->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $this->explodeData($form->get('content')->getData());
            if (count($data) > 10) {
                $this->addFlash('danger', 'Podana zbyt duża ilość liczb');
                return $this->render('numbers/index.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            foreach ($data as $numberToCheck) {
                $this->result[] = ['input' => $numberToCheck, 'output' => $this->getData($numberToCheck)];
            }
           return $this->render('numbers/result.html.twig', ['results' => $this->result]);
        }
        return $this->render('numbers/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function explodeData($sendData)
    {
        return explode(PHP_EOL, $sendData);
    }

    public function getData($input)
    {
        $input = str_replace(array(' ', "\n", "\t", "\r"), '', $input);

        if($input >= 1 && $input <= 99999){
            return $this->getHighestNumber($input);
        }
        return  'Podana liczba nie spełnia kryteriów';

    }

    public function getHighestNumber($n)
    {
        if ($n === 0) {
            return 0;
        }
        if ($n === 1) {
            return 1;
        }

        if ($n % 2 == 0) {
            // 2i
            return $this->getHighestNumber($n/2);
        } else {
            // 2i+1
            return $this->getHighestNumber(($n-1)/2) + $this->getHighestNumber(($n-1)/2+1);
        };
    }
}
