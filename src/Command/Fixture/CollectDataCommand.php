<?php

namespace Src\Command\Fixture;

use Src\Database\EntityManagerFactory;
use Src\Entity\StudyLibrary;
use Src\Feature\Db\Library\PhpQuestions;
use Src\OpenAi;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Symfony\Component\String\u;

#[AsCommand(name: 'app:collect')]
class CollectDataCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entityManager = EntityManagerFactory::create();

        $systemMessage = 'Ти викладач програмування, 
        надаєш коротку, але змістовну інформацією, 
        з прикладами на PHP і посиланням на джерело';
        $questions = PhpQuestions::getQuestions();

        $progress = new ProgressBar($output, count($questions));
        foreach ($questions as $question) {
            $ai = new OpenAi();

            $response = $ai->setSystemMessage($systemMessage)
                ->sendMessage($question)
                ->getResponse();

            $library = new StudyLibrary();
            $library->setSubject('PHP')
                ->setTitle(u($question)->replaceMatches('!^\d+\.!iu', ''))
                ->setBody($response);
            $entityManager->persist($library);
            $entityManager->flush();

            $progress->advance();
        }
        $progress->finish();

        return Command::SUCCESS;
    }

}