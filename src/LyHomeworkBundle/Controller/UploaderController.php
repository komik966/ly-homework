<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Controller;

use LyHomeworkBundle\Builder\TransformedImageBuilder;
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

    /**
     * @var TransformedImageBuilder
     */
    private $transformedImageBuilder;

    public function __construct(Serializer $serializer, ValidatorInterface $validator, TransformedImageBuilder $transformedImageBuilder)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->transformedImageBuilder = $transformedImageBuilder;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function swaggerAction(): Response
    {
        return $this->render('@LyHomework/swagger.html.twig');
    }

    /**
     * @Route("/transform-image", name="transformImage")
     */
    public function transformImageAction(Request $request): Response
    {
        /** @var Image $image */
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

        try {
            $this->transformedImageBuilder
                ->prepareBuilder($image)
                ->resizeAndFlip()
                ->putImageInfo();
        } catch (\ImagickException $e) {
            return new JsonResponse(
                ['errors' => ['path' => 'imageFile', 'message' => 'Cannot transform image. Is it image format?']],
                400
            );
        }

        return new JsonResponse(
            $this->serializer->serialize(
                $this->transformedImageBuilder->getResultImage(), 'json', ['groups' => [Image::GROUP_RESPONSE]]
            ),
            200,
            [],
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
