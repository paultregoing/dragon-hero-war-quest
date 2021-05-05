<?php

$intro = [
    "<info>You are standing in a peaceful forest glade, surrounded on all sides by tightly clustered trees.",
    "The wind blows gently through the tree-tops, the gentle susurration calms your spirits.",
    "Thinking of spirits, you remember the flask at your hip. The liquid burns your throat in a pleasant way.",
    "There are no obvious exits, so you decide to sit...</>\n"
];

$buildup = [
    "<info>After a while, you hear a sound... like huge wings flapping in the distance",
    "There are still no obvious exits, so you continue to sit. Somewhat uneasily.",
    "You remember the tales associated with this place, of great winged beasts that ",
    "would do battle with fire and claw.",
    "The sound is getting louder...</>\n"
];

$stalemate = [
    "\n\n<info>The great beasts fall to the ground together, their death throes churning the ground.",
    "You reach for your flask and ponder the senselessness of it all...</>\n"
];

$attackVerbs = [
    "claws",
    "swipes",
    "flames",
    "bites"
];

return [
    "intro" => $intro,
    "buildup" => $buildup,
    "enterTheDragon" => "A %s <%s>%s</> appears!",
    "dragonSpecial" => "<%s>%s</> gets a bonus (of %s) against <%s>%s</>",
    "hit" => "<%s>%s</> %s at <%s>%s</> for <error>%s</> damage!",
    "miss" => "<%s>%s</> %s at <%s>%s</> but misses!",
    "critHit" => "<%s>%s</> %s at <%s>%s</> with <comment>extreme force</> for <error>%s</> damage! <error>(critical hit)</>",
    "critDef" => " - <%s>%s</> skillfully evades the brunt of the attack! <error>(critical dodge)</>",
    "attackVerbs" => $attackVerbs,
    "initiative" => "\n\n<%s>%s</> <info>takes the initiative...</>",
    "onDefeat"=> "\n\n<info>As the <%s>%s</> towers over its vanquished foe a stillness descends upon the glade...\n\n",
    "tablesTurn" => "<comment>PUNY HUMAN</> <info>- the words appear in your mind, unspoken...</>\n\n",
    "uhOh" => "\n\n<comment>DO OUR STRUGGLES AMUSE YOU?</>\n\n",
    "ohDear" => "\n\n<comment>YOU ARE NOT FIT TO CLEAN OUR SCALES</> <info>- The <%s>%s</> now towers ominously over YOU...</>",
    "requiescat" => "\n\n<info>The last thing you hear is the ferocious HAWUMPH of dragon fire as you are reduced to ashes...</>",
    "stalemate" => $stalemate,
];
