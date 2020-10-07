<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Contract\CodeRepositoryInterface;
use App\Domain\Entity\VerificationCode;
use App\Domain\ValueObject\CodeId;
use App\Infrastructure\Exception\CodeException;
use App\Infrastructure\Exception\CodeNotFoundException;
use App\Infrastructure\Models\Code;
use App\Infrastructure\Transformer\CodeEntityToModelTransformer;
use App\Infrastructure\Transformer\CodeModelToEntityTransformer;
use App\Repository\CodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class MySqliCodeRepository implements CodeRepositoryInterface
{
    private EntityManagerInterface $em;
    private CodeEntityToModelTransformer $codeEntityToModelTransformer;
    /** @var CodeModelToEntityTransformer */
    private $codeModelToEntityTransformer;

    /**
     * MySqliCodeRepository constructor.
     * @param EntityManagerInterface $em
     * @param CodeEntityToModelTransformer $codeEntityToModelTransformer
     * @param CodeModelToEntityTransformer $codeModelToEntityTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        CodeEntityToModelTransformer $codeEntityToModelTransformer,
        CodeModelToEntityTransformer $codeModelToEntityTransformer
    ) {
        $this->em                           = $em;
        $this->codeEntityToModelTransformer = $codeEntityToModelTransformer;
        $this->codeModelToEntityTransformer = $codeModelToEntityTransformer;
    }

    /**
     * @param VerificationCode $verificationCode
     * @return CodeId
     * @throws Exception
     */
    public function create(VerificationCode $verificationCode): CodeId
    {
        try {
            $code = $this->codeEntityToModelTransformer->transform($verificationCode);
            $this->em->persist($code);
            $this->em->flush();

            return new CodeId($code->getId());
        } catch (\Throwable $e) {
            $message = sprintf('Error trying to create verification code: %s', $e->getMessage());

            throw new Exception($message);
        }
    }

    /**
     * @param CodeId $codeId
     * @return VerificationCode
     * @throws CodeException
     * @throws CodeNotFoundException
     */
    public function get(CodeId $codeId): VerificationCode
    {

        /** @var CodeRepository $repo */
        $repo = $this->em->getRepository(Code::class);
        /** @var Code $code */
        $code = $repo->find($codeId->value());
        if (null === $code) {
            throw CodeNotFoundException::becauseOf('Not found');
        }
        try {
            return $this->codeModelToEntityTransformer->transform($code);
        } catch (\Throwable $e) {
            throw CodeException::becauseOf($e->getMessage());
        }
    }
}