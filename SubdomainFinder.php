<?php

/**
 * Search subdomain based on input.
 *
 * @param  string  $domain
 *
 * @return array
 */
function searchSubdomain(string $domain) : array
{
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://sonar.omnisint.io/subdomains/' . $domain,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'GET'
    ]);

    $httpRequest = curl_exec($ch);

    curl_close($ch);

    return json_decode($httpRequest);
}

$argument = readline("Input Main Domain : ");

if ($argument === "") {
    echo "You must input main domain!";

    die;
} elseif (!preg_match("/^(?!\-)(?:(?:[a-zA-Z\d][a-zA-Z\d\-]{0,61})?[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/", $argument)) {
    echo "Domain is not valid!";

    die;
}
    
echo "Please Wait..." . PHP_EOL;

$subdomains = searchSubdomain($argument);

foreach ($subdomains as $key => $subdomain) {
    if ($key === 0) {
        echo "================================" . PHP_EOL;
    }

    echo($key + 1) . ". " . $subdomain . PHP_EOL;
}
