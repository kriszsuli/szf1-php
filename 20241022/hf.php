<?php
    // Source: https://github.com/ekohrt/animal-fun-facts-dataset/blob/main/animal-fun-facts-dataset.csv
    // Csak egy kis részlet, 7735 elemet nem fogok egyesével beírni 😭
    $facts = [
        "Aardvarks are sometimes called 'ant bears', 'earth pigs', and 'cape anteaters'.",
        "Aardvarks have rather primitive brains that are very small for the size of the animal. Some have suggested they are not particularly bright...",
        "Aardvarks teeth are lined with fine upright tubes and have no roots or enamel.",
        "The aardvarks Latin family name 'Tubulidentata' means 'tube toothed'.",
        "Baby aardvarks are born with front teeth that fall out and never grow back.",
        "Aardvarks are living fossils not having changed for millions of years.",
        "Aardvarks will occasionally stand, and even take a step or two, on their hind legs.",
        "Aardvarks can use their powerful tails as a whip-like weapon of defense.",
        "Wild dogs are known by many different names including painted dog, painted wolf, cape hunting dog, African hunting dog, singing dog and ornate wolf.",
        "They are the most efficient hunters of any large predator with an 80% success rate.",
        "Wild dogs don't use a kill bite when hunting, the pack will actually begin to eat their prey alive, which may be a big reason for their unpopularity, but is often actually a quicker ending.",
        "The African Wild Dog is the second largest dog species after the grey wolf.",
        "The Andalusian was used in battle and is extremely agile.",
        "Over 80% of Andalusians are grey in color.",
        "The long mane is sometimes braided in a pattern called 'plaited'.",
        "The Andalusian and the Lusitano were once the same breed.",
        "The Lusitano was bred in Portugal.",
        "The Andalusian horse is used in dressage displays.",
        "The Lipizzaner horse is descended from the Andalusian.",
        "The giant anteater can consume 30,000 individual insects in one day.",
        "The giant anteater's hair is 18 inches long.",
        "Anteaters walk on their balled-up fists to keep their claws sharp for digging.",
        "The silky, or pygmy anteater, weighs only about one pound, while the giant anteater can be 120 pounds and 7 feet long.",
        "The silky anteater is the smallest but probably the loudest and will emit a very shrill scream when threatened.",
        "Anteaters have no teeth.",
        "A giant anteater's tongue is well over two feet long - or 1.5 to 2 times the length of its head.",
        "Anteater babies ride on their mothers' backs for about a year.",
        "The armadillo's armor is made out of bone.",
        "Only one species, the three-banded, can roll into a ball.",
        "Armadillos can carry leprosy.",
        "The armadillo is a mammal and gives birth to live young.",
        "Armadillos can swim underwater and hold their breath for 5 minutes.",
        "The nine-banded armadillo is the state animal of Texas.",
        "Baboons have cheek pouches like hamsters.",
        "The mandrill is the largest monkey species.",
        "Baboons spend most of their time on the ground - not in trees.",
        "Baboons threaten each other with slow-motion 'yawns' displaying their canine teeth.",
        "Baboons walk on all-fours like a dog.",
        "Baboons have lighter-colored skin on their eyelids and they will flash their lids to communicate.",
        "Male baboons are usually twice as large as female baboons - sometimes even larger.",
        "Baboons do not use tools, but have been known to throw rocks, hit things with sticks, and wash some food items.",
        "A group of badgers is called a 'cette'.",
        "Badgers live in huge underground burrows that can include up to 1/2 mile of tunnels.",
        "Badgers can dig both forwards and backwards and often dig backwards disappearing straight into the ground when confronted by an enemy.",
        "Badgers do not hibernate but may enter a state called 'torpor' where they sleep deeply for up to three weeks.",
        "The word 'badger' comes from the French word 'becheur' which means 'digger'.",
        "Badgers have a third eyelid that protects their eyes while they dig."
    ];

    $num = rand(3, 10);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Random facts</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: sans-serif;
                background-color: #f1f1f1;
            }

            .container {
                width: min(1000px, 80%);
                margin: 0 auto;
                padding: 0 20px;
            }

            h1 {
                font-weight: 600;
                text-align: center;
            }

            .fact {
                background-color: #ffffff;
                border-radius: 12px;
                padding: 30px;
                font-size: 18px;
                text-align: left;
            }

            .fact::before{
                content: '💡 '; /* just to make it a bit fancier */
            }

            .facts {
                display: flex;
                flex-wrap: wrap;
                flex-direction: column;
                gap: 20px;
                justify-content: center;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <h1>Random facts</h1>

            <div class="facts">
                <?php
                    shuffle($facts);

                    for ($i = 0; $i < $num; $i++) {
                        echo "<div class='fact'>{$facts[$i]}</div>";
                    }
                ?>
            </div>
        </div>

    </body>
</html>
