#!/usr/bin/env php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;

use App\DragonHeroWarQuest;

(new SingleCommandApplication())
    ->setName('DragonHeroWarQuest')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $config = require_once(__DIR__ . '/app/config/app.php');
        $story = require_once(__DIR__ . '/app/config/story.php');

        $dragonWar = new DragonHeroWarQuest($config, $story, $input, $output);

        $dragonWar->start();
    })
    ->run();