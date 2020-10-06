<?php
declare(strict_types=1);
namespace App\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CodeController extends AbstractController
{
    public function handle(){
        return $this->render('home.html.twig');
    }
}