<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Command\MarkCodeAsUsedCommand;
use App\Domain\Contract\CodeRepositoryInterface;
use App\Domain\Service\IsAdminCode;
use App\Domain\ValueObject\Code;

class MarkCodeAsUsed
{
    private CodeRepositoryInterface $codeRepository;
    /** @var IsAdminCode */
    private $isAdminCode;

    /**
     * MarkCodeAsUsed constructor.
     * @param CodeRepositoryInterface $codeRepository
     * @param IsAdminCode $isAdminCode
     */
    public function __construct(CodeRepositoryInterface $codeRepository, IsAdminCode $isAdminCode)
    {
        $this->codeRepository = $codeRepository;
        $this->isAdminCode    = $isAdminCode;
    }

    /**
     * @param MarkCodeAsUsedCommand $command
     */
    public function handle(MarkCodeAsUsedCommand $command)
    {
        $code = new Code($command->code());
        if (!$this->isAdminCode->handle($code)) {
            $this->codeRepository->setAsUsed($code);
        }
    }


}