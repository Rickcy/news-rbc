<?php


namespace app\src\parser;


abstract class Decoder implements IDecoder
{

    protected $url;

    protected $options;

    /**
     * Parser constructor.
     * @param $url
     * @param array $options
     */
    public function __construct($url, $options = [CURLOPT_FOLLOWLOCATION => true, CURLOPT_USERAGENT => 'Yandex'])
    {
        $this->url = $url;
        $this->options = $options;
    }

    protected function getDataByUrl()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        foreach ($this->options as $key => $option) {
            curl_setopt($ch, $key, $option);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if (FALSE === ($retval = curl_exec($ch))) {
            curl_error($ch);
        }
        return $retval;
    }


}