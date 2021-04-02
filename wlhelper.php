<?php

$searchIn = 1; // If 0 - search on WeLeakInfo API, if 1 - search in LeakCheck
$type = "email"; // Set your type element for search e.g. email | Btw WeLeakInfo API sucks, so only works if type is an email. Also you can search by nickname or phone number but no change the type. You must set type as email.
$apiKey = "XXXX-XXXX-XXXX-XXXX"; // Set your api key. | Api key format: XXXX-XXXX-XXXX-XXXX

$leaksElements = [

/*
  If you want use this script you
  must remove e-mail addresses below.
*/

"test@test.ru", 
"propablyNotExistingEmail1@example.com",
"propablyNotExistingEmail2@example.com",
"test@example.com"

];

class WeLeakHelper
{

    public function __construct()
    {
        echo "\n";
        echo "\033[31m    \n";
        echo "           \ \      / / |   | | | | ____| |   |  _ \| ____|  _ \ \n";
        echo "            \ \ /\ / /| |   | |_| |  _| | |   | |_) |  _| | |_) |\n";
        echo "             \ V  V / | |___|  _  | |___| |___|  __/| |___|  _ < \n";
        echo "              \_/\_/  |_____|_| |_|_____|_____|_|   |_____|_| \_\ \n";
        echo "\n";
        echo "                              Created by VendeN                  \033[\n";
        echo "\n";
    }

    public function check($searchIn, $type, $apiKey, $leaksElements):void
        {

            foreach ($leaksElements as $leak)
            {
                if ($searchIn == 0)
                {
                    $url = "http://api.weleakinfo.to/api?value=$leak&type=$type&key=$apiKey";
                    $ch = curl_init($url);

                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                    $output = curl_exec($ch);
                    $json = json_decode($output, true);
                    echo "\n";
                    echo "\e[92mSearching on: WeLeakInfo.to";
                    echo "\n";
                    if ($json["success"] === true)
                    {
                        echo "\033[33m!! $leak is vulnerable !! \n";
                        for ($i = 0;$i < count($json["result"]);$i++)
                        {
                            if (count($json["result"]["$i"]["sources"]) === 0)
                            {
                                echo "\e[92m" . $json["result"]["$i"]["line"] . " from unknown database" . "\n";
                            }
                            else
                            {
                                for ($l = 0;$l < count($json["result"]["$i"]["sources"]);$l++)
                                {
                                    echo "\e[92m" . $json["result"]["$i"]["line"] . " from database " . "\033[34m" . $json["result"]["$i"]["sources"]["$l"] . "\n";
                                }
                            }
                        }
                    }
                    else
                    {
                        echo "\e[31mNot found passwords for: " . $leak . "\n";
                    }
                    echo "\e[39m";
                }
                elseif ($searchIn == 1)
                {

                    $url = "https://leakcheck.net/api/?key=$apiKey&check=$leak&type=$type";
                    $ch = curl_init($url);

                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                    $output = curl_exec($ch);
                    $json = json_decode($output, true);
                    echo "\n";
                    echo "\e[92mSearching on: LeakCheck.net\n";
                    echo "\n";
                    if ($json["success"] === true)
                    {
                        echo "\033[33m!! $leak is vulnerable !! \n";
                        for ($i = 0;$i < count($json["result"]);$i++)
                        {
                            if (count($json["result"]["$i"]["sources"]) === 0)
                            {
                                echo "\e[92m" . $json["result"]["$i"]["line"] . " from unknown database" . "\n";
                            }
                            else
                            {
                                for ($l = 0;$l < count($json["result"]["$i"]["sources"]);$l++)
                                {
                                    echo "\e[92m" . $json["result"]["$i"]["line"] . " from database " . "\033[34m" . $json["result"]["$i"]["sources"]["$l"] . "\n";
                                }
                            }
                        }
                    }
                    else
                    {
                        echo "\e[31mNot found passwords for: " . $leak . "\n";
                    }
                    echo "\e[39m";
                }
                else {
                  echo "\e[31mInvalid platform please check yours configuration and try again.\n";
                  echo "\e[39m";
                }
            }
        }

    }

    $weLeakHelper = new WeLeakHelper();
    $weLeakHelper->check($searchIn, $type, $apiKey, $leaksElements);
    
