<?php
declare(strict_types=1);

namespace App\Controller\Api;


use App\Application\Command\CreateVerificationCodeCommand;
use App\Application\Service\CreateVerificationCode;
use App\Domain\Service\isValidPhoneNumber;
use App\Domain\Service\SanitizePhoneNumber;
use App\Infrastructure\Constant\Http_codes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CodeController extends AbstractController
{
    private isValidPhoneNumber $isValidPhoneNumber;
    private CreateVerificationCode $createVerificationCode;
    private SanitizePhoneNumber $sanitizePhoneNumber;

    /**
     * CodeController constructor.
     * @param isValidPhoneNumber $isValidPhoneNumber
     * @param CreateVerificationCode $createVerificationCode
     * @param SanitizePhoneNumber $sanitizePhoneNumber
     */
    public function __construct(
        isValidPhoneNumber $isValidPhoneNumber,
        CreateVerificationCode $createVerificationCode,
        SanitizePhoneNumber $sanitizePhoneNumber
    ) {
        $this->isValidPhoneNumber     = $isValidPhoneNumber;
        $this->createVerificationCode = $createVerificationCode;
        $this->sanitizePhoneNumber    = $sanitizePhoneNumber;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $telephone_number = $request->get('telephone');
        if ($this->isValidPhoneNumber->handle($telephone_number)) {
            try {
                $telephone_number = $this->sanitizePhoneNumber->sanitize($telephone_number);
                $this->createVerificationCode->handle(new CreateVerificationCodeCommand((int)$telephone_number));
            } catch (\Throwable $e) {
                $message = sprintf("Error, %s", $e->getMessage());

                return new JsonResponse($message, Http_codes::HTTP_CREATED);
            }

            return new JsonResponse('Created', Http_codes::HTTP_CREATED);
        }

        return new JsonResponse('Invalid telephone format', Http_codes::HTTP_BAD_REQUEST);
    }
}