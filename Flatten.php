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
     * @param array $input
     *   Takes an optional array and returns the flattened array
     *   If left blank we will read from / write to files instead
     * @return array / bool
     */
    public function run(array $input = null)
    {
        $data = $input ?: $this->readJsonFile($this->source);

        $flat = $this->flatten($data);

        if ( ! is_null($input) ) {
            return $flat;
        }

        return $this->writeJsonFile($this->destination, $flat);
    }

    public function loadConfig($filename)
    {
        $this->checkFileExists($filename);

        $config = include($filename);

        if ( ! array_key_exists('source', $config) || ! array_key_exists('destination', $config) ) {
            throw new UnexpectedValueException("Please ensure '$filename' specifies a source and a destination");
        }

        $this->source = $config['source'];
        $this->destination = $config['destination'];
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