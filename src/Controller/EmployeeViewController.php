<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeViewController extends AbstractController
{
    /**
     * @Route("/employee/view", name="employee_view")
     */
    public function index(): Response
    {
        return $this->render('employee_view/index.html.twig', [
            'controller_name' => 'EmployeeViewController',
        ]);
    }
}
