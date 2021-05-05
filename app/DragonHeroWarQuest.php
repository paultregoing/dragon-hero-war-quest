<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

use App\Creature\Dragon;

final class DragonHeroWarQuest extends Command
{
    private $config;
    private $story;
    private $input;
    private $output;
    private $questionHelper;
    private $dragons = [];

    public function __construct(array $config, array $story, InputInterface $input, OutputInterface $output)
    {
        $set = new HelperSet();
        $set->set(new QuestionHelper());
        $this->setHelperSet($set);
        $this->questionHelper = $this->getHelper('question');

        $this->config = $config;
        $this->input = $input;
        $this->output = $output;
        $this->story = $story;

        $this->setCustomStyles();
        $this->initDragons($config['dragons']);
    }

    public function start(): void
    {

        $this->output->writeln($this->story['intro']);
        $this->promptToContinue();
        $this->output->writeln($this->story['buildup']);
        $this->promptToContinue();
        $this->startBattle();
    }

    private function startBattle(): void
    {
        foreach ($this->dragons as $dragon) {
            $this->output->writeln(sprintf(
                $this->story['enterTheDragon'],
                $dragon->getAdjective(),
                $dragon->getColour(),
                $dragon->getName()
            ));

            $this->dramaticPause(false);
        }

        $this->output->writeln("\n<info>The dragons eye each other warily, a low rumble rising from their throats...</>\n");

        $this->dramaticPause();
        $this->applySpecialBuffs();
        $this->dramaticPause();

        $dragon0 = $this->dragons[0];
        $dragon1 = $this->dragons[1];

        while ($dragon0->getHealth() > 0 && $dragon1->getHealth() > 0) {
            $this->rollForInitiative();

            if ($dragon0->getInitiative() > $dragon1->getInitiative()) {
                $this->output->writeln(sprintf(
                    $this->story['initiative'],
                    $dragon0->getColour(),
                    $dragon0->getName()
                ));

                $this->gottaCatchEmAll($dragon0, $dragon1);
                if (!$this->checkForDeath()) {
                    $this->gottaCatchEmAll($dragon1, $dragon0);
                }
            } elseif ($dragon0->getInitiative() < $dragon1->getInitiative()) {
                $this->output->writeln(sprintf(
                    $this->story['initiative'],
                    $dragon1->getColour(),
                    $dragon1->getName()
                ));

                $this->gottaCatchEmAll($dragon1, $dragon0);
                if (!$this->checkForDeath()) {
                    $this->gottaCatchEmAll($dragon0, $dragon1);
                }
            } elseif ($dragon0->getInitiative() === $dragon1->getInitiative()) {
                $this->output->writeln("\n<info>Both dragons attack simultaneously!</>");

                $this->gottaCatchEmAll($dragon1, $dragon0);
                $this->gottaCatchEmAll($dragon0, $dragon1);
                $this->checkForDeath();
            }

            $this->checkForDeath();
            $this->resetInitiative();
            $this->dramaticPause();
        }
    }

    private function gottaCatchEmAll(Dragon $aggressor, Dragon $defender): void
    {
        $attack = $aggressor->getAttack();
        $critAttack = false;

        $defence = $aggressor->getDefence();
        $critDefence = false;

        if ($aggressor->testLuck()) {
            $attack = $attack * 2;
            $critAttack = true;
        }

        if ($defender->testLuck()) {
            $defence = $defence * 2;
            $critDefence = true;
        }

        $damage = $attack - $defence;

        if ($damage > 0) {
            if ($critAttack) {
                $this->output->writeln(sprintf(
                    $this->story['critHit'],
                    $aggressor->getColour(),
                    $aggressor->getName(),
                    $this->story['attackVerbs'][rand(0, 3)],
                    $defender->getColour(),
                    $defender->getName(),
                    $damage
                ));
            } else {
                $this->output->writeln(sprintf(
                    $this->story['hit'],
                    $aggressor->getColour(),
                    $aggressor->getName(),
                    $this->story['attackVerbs'][rand(0, 3)],
                    $defender->getColour(),
                    $defender->getName(),
                    $damage
                ));
            }

            if ($critDefence) {
                $this->output->writeln(sprintf(
                    $this->story['critDef'],
                    $defender->getColour(),
                    $defender->getName()
                ));
            }

            $defender->takeDamage($damage);
        } else {
            $this->output->writeln(sprintf(
                $this->story['miss'],
                $aggressor->getColour(),
                $aggressor->getName(),
                $this->story['attackVerbs'][rand(0, 3)],
                $defender->getColour(),
                $defender->getName()
            ));
        }
    }

    private function checkForDeath(): void
    {
        $dragon0 = $this->dragons[0];
        $dragon1 = $this->dragons[1];

        if ($dragon0->getHealth() <= 0 xor $dragon1->getHealth() <= 0) {
            $deadDragon = ($dragon0->getHealth()) ? 0 : 1;


            $this->output->writeln(sprintf(
                $this->story['onDefeat'],
                $this->dragons[$deadDragon]->getColour(),
                $this->dragons[$deadDragon]->getName()
            ));

            $this->dramaticPause();
            $this->output->writeln($this->story['tablesTurn']);
            $this->dramaticPause();
            $this->output->writeln($this->story['uhOh']);
            $this->dramaticPause();

            $this->output->writeln(sprintf(
                $this->story['ohDear'],
                $this->dragons[$deadDragon]->getColour(),
                $this->dragons[$deadDragon]->getName()
            ));

            $this->dramaticPause();
            $this->output->writeln($this->story['requiescat']);

            die(0);
        } elseif ($dragon0->getHealth() <= 0 && $dragon1->getHealth() <= 0) {
            $this->output->writeln($this->story['stalemate']);

            die(0);
        }
    }

    private function applySpecialBuffs(): void
    {
        $dragon0 = $this->dragons[0];
        $dragon1 = $this->dragons[1];

        if ($dragon0->getSpecial()[2] === $dragon1->getColour()) {
            $setMethod = 'set' . ucwords($dragon0->getSpecial()[1]) . 'Mod' ;

            $this->output->writeln(sprintf(
                $this->story['dragonSpecial'],
                $dragon0->getColour(),
                $dragon0->getName(),
                $dragon0->getSpecial()[1],
                $dragon1->getColour(),
                $dragon1->getName(),
            ));

            $dragon0->$setMethod(
                $dragon0->getSpecial()[0]
            );
        }

        if ($dragon1->getSpecial()[2] === $dragon0->getColour()) {
            $setMethod = 'set' . ucwords($dragon1->getSpecial()[1]) . 'Mod';

            $this->output->writeln(sprintf(
                $this->story['dragonSpecial'],
                $dragon1->getColour(),
                $dragon1->getName(),
                $dragon1->getSpecial()[1],
                $dragon0->getColour(),
                $dragon0->getName(),
            ));

            $dragon1->$setMethod(
                $dragon1->getSpecial()[0]
            );
        }
    }

    private function rollForInitiative(): void
    {
        $this->dragons[0]->setInitiative(rand(1, 20));
        $this->dragons[1]->setInitiative(rand(1, 20));
    }

    private function resetInitiative(): void
    {
        $this->dragons[0]->setInitiative(0);
        $this->dragons[1]->setInitiative(0);
    }

    private function dramaticPause(bool $long = false): void
    {
        $long ? sleep(rand(6, 9)) : sleep(rand(2, 4));
    }

    private function initDragons(array $config): void
    {
        shuffle($config);
        array_pop($config);

        foreach ($config as $stats) {
            $dragon = new Dragon();

            foreach ($stats as $k => $v) {
                $method = 'set' . ucwords($k);
                $dragon->$method($v);
            }

            $this->dragons[] = $dragon;
        }

    }

    private function promptToContinue(): void
    {
        $this->questionHelper->ask($this->input, $this->output, new ConfirmationQuestion(
            "\nPress <enter> to continue...\n",
            true
        ));
    }

    private function setCustomStyles(): void
    {
        $this->output->getFormatter()->setStyle('red', new OutputFormatterStyle(
            'white',
            'red',
            ['bold']
        ));

        $this->output->getFormatter()->setStyle('blue', new OutputFormatterStyle(
            'white',
            'blue',
            ['bold']
        ));

        $this->output->getFormatter()->setStyle('green', new OutputFormatterStyle(
            'black',
            'green',
            ['bold']
        ));
    }
}