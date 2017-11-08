<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Controller;

use LyHomeworkBundle\Model\Image;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class UploaderController extends Controller
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function swaggerAction(): Response
    {
        return $this->render('@LyHomework/swagger.html.twig');
    }

    /**
     * @Route("/upload-image", name="uploadImage")
     */
    public function uploadImageAction(Request $request): Response
    {
        /** @var UploadedFile $image */
        $uploadedImage = $request->files->get('image');
        $width = $request->get('width');
        $height = $request->get('height');

        $image = (new Image())
            ->setHeight(100)
            ->setWidth(200)
            ->setHumanReadableFileSize("2.2 MB")
            ->setMimeType("image/jpeg")
            ->setMirrored("/images/sdsdfsdfsdf.jpg");

        return new JsonResponse($this->serializer->serialize($image, 'json'), 200, [], true);
    }
}
