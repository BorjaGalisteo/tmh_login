<?php
declare(strict_types=1);
namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function handle(){
        return $this->render('home.html.twig');
    }
}