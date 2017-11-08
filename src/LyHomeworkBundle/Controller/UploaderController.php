<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Controller;

use LyHomeworkBundle\Model\Image;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UploaderController extends Controller
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(Serializer $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
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
        $image = $this->serializer->denormalize(
            array_merge($request->request->all(), $request->files->all()),
            Image::class,
            null,
            ['groups' => [Image::GROUP_REQUEST]]
        );

        $validationResult = $this->validateImageAndPrepareErrorResponse($image);
        if ($validationResult instanceof JsonResponse) {
            return $validationResult;
        }

        return new JsonResponse(
            $this->serializer->serialize($image, 'json', ['groups' => Image::GROUP_RESPONSE]), 200, [],
            true
        );
    }

    private function validateImageAndPrepareErrorResponse(Image $image): ?JsonResponse
    {
        $validationResult = $this->validator->validate($image);
        if (0 === $validationResult->count()) {
            return null;
        }
        $result = ['errors' => []];
        foreach ($validationResult as $violation) {
            /** @var ConstraintViolationInterface $violation */
            $result['errors'][] = [
                'path' => $violation->getPropertyPath(),
                'message' => $violation->getMessage()
            ];
        }
        return new JsonResponse($result, 400);
    }
}
