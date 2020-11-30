<?php


$type = "email"; // Set your type element for search e.g. email
$apiKey = "IPLH-OQGD-IFOA-MVAY"; // Set your api key. | Api key format: XXXX-XXXX-XXXX-XXXX
$leaksElements = [

  "example@email.com",
  "example2@email.com",
  "example3@email.com",
  "example4@email.com",
  "example5@email.com",
  "example17777@email.com",
  "example8868@email.com",
  "example6788@email.com"
  

];

class WeLeakHelper {
  public function __construct() {

    system('clear');
    echo "\n";
    echo "\033[31m    \n";
    echo "           \ \      / / |   | | | | ____| |   |  _ \| ____|  _ \ \n";
    echo "            \ \ /\ / /| |   | |_| |  _| | |   | |_) |  _| | |_) |\n";
    echo "             \ V  V / | |___|  _  | |___| |___|  __/| |___|  _ < \n";
    echo "              \_/\_/  |_____|_| |_|_____|_____|_|   |_____|_| \_\ \n";
    echo "\n";                                                       
    echo "                              Created by VendeN                  \033[";                                                                                                            
    echo "\n";  

  }

  public function check($type, $apiKey, $leaksElements): void {

    foreach ($leaksElements as $leak) {

        $json_url = "http://api.weleakinfo.to/api?value=$leak&type=$type&key=$apiKey";
        $json = @file_get_contents($json_url);
        $data = json_decode($json, TRUE);
        echo "\n";
    
      if ($json === '{"success":false,"error":"Result not found."}') 
        {
            echo "\e[31mNot found passwords for $type: ".$leak."\n";
        } 
      else 
        {
            echo "\e[92mSuccess i found passwords for $type: $leak \n";
            $decode = json_decode($json, true);
            $arrayLength = $decode['found'] ?? null;
    
            for ($i = 0; $i < $arrayLength; $i++) 
            {
            echo($decode['result'][$i]['line'])."\n";
            }
    }
    }
    echo "\e[39m"; // go back to the default console color.
}
}

$weLeakHelper = new WeLeakHelper();
$weLeakHelper->check($type, $apiKey, $leaksElements);