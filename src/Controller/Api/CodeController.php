<?php
declare(strict_types=1);

namespace App\Controller\Api;


use App\Application\Command\CreateVerificationCodeCommand;
use App\Application\Command\GetVerificationCodeCommand;
use App\Application\Service\CreateVerificationCode;
use App\Application\Service\GetVerificationCode;
use App\Domain\Service\isValidPhoneNumber;
use App\Domain\Service\SanitizePhoneNumber;
use App\Infrastructure\Constant\Http_codes;
use App\Infrastructure\Exception\CodeNotFoundException;
use App\Infrastructure\Transformer\VerificationCodeToArrayTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CodeController extends AbstractController
{
    private isValidPhoneNumber $isValidPhoneNumber;
    private CreateVerificationCode $createVerificationCode;
    private SanitizePhoneNumber $sanitizePhoneNumber;
    private GetVerificationCode $getVerificationCode;
    private VerificationCodeToArrayTransformer $verificationCodeToArrayTransformer;

    /**
     * CodeController constructor.
     * @param isValidPhoneNumber $isValidPhoneNumber
     * @param CreateVerificationCode $createVerificationCode
     * @param SanitizePhoneNumber $sanitizePhoneNumber
     * @param GetVerificationCode $getVerificationCode
     * @param VerificationCodeToArrayTransformer $verificationCodeToArrayTransformer
     */
    public function __construct(
        isValidPhoneNumber $isValidPhoneNumber,
        CreateVerificationCode $createVerificationCode,
        SanitizePhoneNumber $sanitizePhoneNumber,
        GetVerificationCode $getVerificationCode,
        VerificationCodeToArrayTransformer $verificationCodeToArrayTransformer
    ) {
        $this->isValidPhoneNumber                 = $isValidPhoneNumber;
        $this->createVerificationCode             = $createVerificationCode;
        $this->sanitizePhoneNumber                = $sanitizePhoneNumber;
        $this->getVerificationCode                = $getVerificationCode;
        $this->verificationCodeToArrayTransformer = $verificationCodeToArrayTransformer;
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
                $codeId           = $this->createVerificationCode->handle(new CreateVerificationCodeCommand((int)$telephone_number));
            } catch (\Throwable $e) {
                $message = sprintf("Error, %s", $e->getMessage());
                return new JsonResponse($message, Http_codes::HTTP_CREATED, []);
            }
            return new JsonResponse(['id' => $codeId->value()], Http_codes::HTTP_CREATED);
        }
        return new JsonResponse('Invalid telephone format', Http_codes::HTTP_BAD_REQUEST);
    }

    public function getCode(int $code_id)
    {
        try {
            $verficationCode = $this->getVerificationCode->handle(new GetVerificationCodeCommand($code_id));

            return new JsonResponse(
                $this->verificationCodeToArrayTransformer->transform($verficationCode),
                Http_codes::HTTP_OK
            );
        } catch (CodeNotFoundException $e) {
            return new JsonResponse('Not found', Http_codes::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return new JsonResponse('Internal error'.$e->getMessage(), Http_codes::HTTP_ERROR);
        }
    }
}