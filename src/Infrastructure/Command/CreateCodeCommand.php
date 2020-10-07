<?php
declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Domain\ValueObject\CodeId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;

class CreateCodeCommand extends Command
{
    private const SERVER = 'http://127.0.0.1:8000';
    protected static $defaultName = 'code:generate';

    private Client $client;

    /**
     * CreateCodeCommand constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
        parent::__construct();
    }


    protected function configure()
    {
        $this->setDescription('Creates a new code.')
            ->setHelp('This command allows you to create a code');

        $this->addArgument('telephone', InputArgument::REQUIRED, 'The telephone to send the code.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $codeId      = $this->createCode($input);
        $information = $this->getCode($codeId);
        $output->writeln([
            print_r($information),
        ]);

        return Command::SUCCESS;
    }

    private function createCode(InputInterface $input): CodeId
    {
        $options  = [
            'form_params' => [
                "telephone" => $input->getArgument('telephone'),
            ],
        ];
        $response = $this->client->request('POST', self::SERVER . '/api/code', $options);
        $response = $response->getBody()->getContents();
        $data     = json_decode($response, true);

        return new CodeId($data['id']);
    }

    private function getCode(CodeId $codeId): array
    {
        $url      = self::SERVER . '/api/code/' . $codeId->value();
        $response = $this->client->request('GET', $url);
        $response = $response->getBody()->getContents();
        return json_decode($response, true);
    }
}