<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UploaderController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function swaggerAction(Request $request)
    {
        return $this->render('@LyHomework/swagger.html.twig');
    }
}
