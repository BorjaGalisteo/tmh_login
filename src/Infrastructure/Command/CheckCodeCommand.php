<?php
declare(strict_types=1);


namespace App\Infrastructure\Command;


use App\Domain\ValueObject\CodeId;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCodeCommand extends Command
{
    private const SERVER = 'http://127.0.0.1:8000';

    protected static $defaultName = 'code:check';

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

        $this->addArgument('telephone', InputArgument::REQUIRED, 'The telephone.');
        $this->addArgument('code', InputArgument::REQUIRED, 'The generated code.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data     = [
            "telephone_number"  => $input->getArgument('telephone'),
            "verification_code" => $input->getArgument('code'),
        ];
        $params   = http_build_query($data);
        $response = $this->client->request('GET', self::SERVER . '/api/check/?' . $params);
        $response = $response->getBody()->getContents();

        $data = json_decode($response, true);
        $output->writeln([
            'Is a valid code?',
            (int)$data['message'],
        ]);

        return Command::SUCCESS;
    }

    private function prepareParams(InputInterface $input): string
    {
        $data = [
            "telephone_number"  => $input->getArgument('telephone'),
            "verification_code" => $input->getArgument('code'),
        ];
        return http_build_query($data);
    }
}