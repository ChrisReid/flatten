# Flatten

Takes an input file as JSON and flattens it to an output file as JSON

Changelog

0.0.3   Consumable as a micro service
        - http://{base}/service.php?source=[1,2,3,[4,5,6],7,[8],[9,10,[11,12]],[13,[14,[15,16,[17,18,19]],20]]]

0.0.2   Now accessible via command line
        - php command.php test.json outputs.json

0.0.1   Class takes arguments via constructor
        - new Flatten($source, $destination);
        or config file returning source and destination keys