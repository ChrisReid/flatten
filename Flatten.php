<?php

class Flatten {

    /**
     * @var string
     * Source Filename
     */
    protected $source;

    /**
     * @var string
     * Destination Filename
     */
    protected $destination;

    /**
     * @param string $source
     * @param string $destination
     */
    public function __construct($source = 'test.json', $destination = 'flat.json')
    {
        $this->source = $source;
        $this->destination = $destination;
    }

    /**
     * @return bool
     * Returns true on successful write
     */
    public function run()
    {
        $source = $this->readJsonFile($this->source);

        $flat = $this->flatten($source);

        return $this->writeJsonFile($this->destination, $flat);
    }

    protected function checkFileExists($filename)
    {
        if ( ! file_exists($filename) ) {
            throw new FileDoesNotExistException("$filename does not exist.");
        }
    }

    /**
     * @param $filename
     * @return array
     */
    protected function readJsonFile($filename)
    {
        $this->checkFileExists($filename);
        $data = file_get_contents($filename);

        return json_decode($data);
    }

    /**
     * @param $filename
     * @param $data
     * @return bool (Success)
     */
    protected function writeJsonFile($filename, $data)
    {
        $json = json_encode($data, true);

        return file_put_contents($filename, $json) !== false;
    }

    /**
     * @param array $input
     * @return array
     *
     * Returns the flattened input array
     */
    protected function flatten(array $input)
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($input));
        $output = [];
        
        foreach($iterator as $value) {
          $output[] = $value;
        }

        return $output;
    }

    /**
     * @param $data
     *
     * Used for testing / development purposes in lieu of Laravel's dd()
     */
    protected function displayJson($data)
    {
        echo json_encode($data, true) . PHP_EOL;
    }
}