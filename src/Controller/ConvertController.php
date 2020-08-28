<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use App\Form\ConvertFormType;
use App\Entity\CurrencyConverter;

class ConvertController extends AbstractController
{
    /**
    * @Route("/", name="homepage")
    */
    public function homepage(Request $request)
    {
        $converter = new CurrencyConverter('PLN', 'EUR');
        $form = $this->createForm(ConvertFormType::class, $converter);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $converted = $converter->convert();
            $form = $this->createForm(ConvertFormType::class, $converter);
            if (!$converted) {
                $form->addError(new FormError('Błąd połączenia z serwerem API'));
            }
        }
        
        return $this->render('convert/convertForm.html.twig', [
            'form' => $form->createView(), 'converter' => $converter]);
    }
}
