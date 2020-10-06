<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Contract\CodeRepositoryInterface;
use App\Domain\Entity\VerificationCode;
use App\Infrastructure\Transformer\CodeEntityToModelTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class MySqliCodeRepository implements CodeRepositoryInterface
{
    private EntityManagerInterface $em;
    private CodeEntityToModelTransformer $codeEntityToModelTransformer;

    /**
     * MySqliCodeRepository constructor.
     * @param EntityManagerInterface $em
     * @param CodeEntityToModelTransformer $codeEntityToModelTransformer
     */
    public function __construct(EntityManagerInterface $em, CodeEntityToModelTransformer $codeEntityToModelTransformer)
    {
        $this->em                           = $em;
        $this->codeEntityToModelTransformer = $codeEntityToModelTransformer;
    }

    /**
     * @param VerificationCode $verificationCode
     * @throws Exception
     */
    public function create(VerificationCode $verificationCode): void
    {
        try {
            $code = $this->codeEntityToModelTransformer->transform($verificationCode);
            $this->em->persist($code);
            $this->em->flush();
        } catch (\Throwable $e) {
            $message = sprintf('Error trying to create verification code: %s', $e->getMessage());

            throw new Exception($message);
        }

    }
}