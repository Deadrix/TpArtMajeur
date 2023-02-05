<?php

namespace App\Service;

class JsonGenerator
{
    public function generateJsonFile(String $basePath, String $email, String $name, String $question, int $questionId)
    {
        $content = array(
            "Email" => $email,
            "Name" => $name,
            "Question" => $question
        );

        $jsonContent = json_encode($content);
        $fp = fopen($basePath . "JSON_Output/" . $email . "-" . $questionId . ".json", 'w');
        fwrite($fp, $jsonContent);
        fclose($fp);
    }
}