<?php


class XmlParser
{
    public static function parse(SimpleXMLElement $xml)
    {
        $windData = $xml->{"wind"};
        $arrData = array();
        foreach ($windData->children() as $k => $v) {
            $tmp = current($v);
            if ($tmp)
                $arrData[$k] = $tmp;
        }

        return array(
            "city" => array(
                "name" => $xml->{"city"}->attributes()->{"name"},
                "coords" => $xml->{"city"}->{"coord"}->attributes(),
                "sun" => $xml->{"city"}->{"sun"}->attributes()
            ),
            "weather" => array(
                "temperature" => current($xml->{"temperature"}->attributes()),
                "feels like" => current($xml->{"feels_like"}->attributes()),
                "humidity" => current($xml->{"humidity"}->attributes()),
                "pressure" => current($xml->{"pressure"}->attributes()),
                "visibility" => current($xml->{"visibility"}->attributes()),
                "clouds" => current($xml->{"clouds"}->attributes()->{"name"}),
                "wind" => $arrData,
            )
        );
    }
}