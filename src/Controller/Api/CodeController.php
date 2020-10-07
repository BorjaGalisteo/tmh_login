<?php
declare(strict_types=1);

namespace App\Controller\Api;


use App\Application\Command\CheckVerificationCodeCommand;
use App\Application\Command\CreateVerificationCodeCommand;
use App\Application\Command\GetVerificationCodeCommand;
use App\Application\Service\CheckVerificationCode;
use App\Application\Service\CreateVerificationCode;
use App\Application\Service\GetVerificationCode;
use App\Domain\Service\CheckCode;
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
    private CheckVerificationCode $checkVerificationCode;

    /**
     * CodeController constructor.
     * @param isValidPhoneNumber $isValidPhoneNumber
     * @param CreateVerificationCode $createVerificationCode
     * @param SanitizePhoneNumber $sanitizePhoneNumber
     * @param GetVerificationCode $getVerificationCode
     * @param VerificationCodeToArrayTransformer $verificationCodeToArrayTransformer
     * @param CheckVerificationCode $checkVerificationCode
     */
    public function __construct(
        isValidPhoneNumber $isValidPhoneNumber,
        CreateVerificationCode $createVerificationCode,
        SanitizePhoneNumber $sanitizePhoneNumber,
        GetVerificationCode $getVerificationCode,
        VerificationCodeToArrayTransformer $verificationCodeToArrayTransformer,
        CheckVerificationCode $checkVerificationCode
    ) {
        $this->isValidPhoneNumber                 = $isValidPhoneNumber;
        $this->createVerificationCode             = $createVerificationCode;
        $this->sanitizePhoneNumber                = $sanitizePhoneNumber;
        $this->getVerificationCode                = $getVerificationCode;
        $this->verificationCodeToArrayTransformer = $verificationCodeToArrayTransformer;
        $this->checkVerificationCode              = $checkVerificationCode;
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
        return new JsonResponse(['message' => 'Invalid telephone format'], Http_codes::HTTP_BAD_REQUEST);
    }

    public function getCode(int $code_id)
    {
        try {
            $verificationCode = $this->getVerificationCode->handle(new GetVerificationCodeCommand($code_id));

            return new JsonResponse(
                $this->verificationCodeToArrayTransformer->transform($verificationCode),
                Http_codes::HTTP_OK
            );
        } catch (CodeNotFoundException $e) {
            return new JsonResponse(['message' => 'Not found'], Http_codes::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return new JsonResponse(['message' => 'Internal error'] . $e->getTraceAsString(), Http_codes::HTTP_ERROR);
        }
    }

    public function check(Request $request)
    {
        $telephone_number = (int)$this->sanitizePhoneNumber->sanitize($request->get('telephone_number'));

        try {
            $checked = $this->checkVerificationCode->handle(new CheckVerificationCodeCommand(
                $telephone_number,
                $request->get('verification_code')
            ));
        } catch (CodeNotFoundException $e) {
            return new JsonResponse(['message' => 'This code is not right'], Http_codes::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return new JsonResponse(['message' => 'Internal error'] . $e->getMessage(), Http_codes::HTTP_ERROR);
        }

        return new JsonResponse(['right_code' => $checked->right()], Http_codes::HTTP_OK);
    }
}