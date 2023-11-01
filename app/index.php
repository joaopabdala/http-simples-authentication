<?php 

require_once('inc/config.php');

// echo password_hash('5o9iw93l7NHbD2O4KkY0Em2uw0CGPjSH', PASSWORD_DEFAULT);
// echo '<br>';
// echo password_hash('B1IHhpd07CrwXLcrnKq2KK5MYBHHREjY', PASSWORD_DEFAULT);
// die();
function api_request($endpoint, $method = 'GET', $variables = [])
{
    $curl = curl_init();
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic '. base64_encode(API_USER . ':'. API_PASS)
    );
    $url = API_BASE_URL . $endpoint . '/';


    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    if($method == 'GET'){
      
        if(!empty($variables)){
            $url .= '?'. http_build_query($variables);
        }
    }


    if($method == 'POST'){
        $variables = array_merge(['endpoint' => $endpoint], $variables);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $url);
    }

    curl_setopt($curl, CURLOPT_URL, $url);

    $response = curl_exec($curl);

    if(curl_errno($curl)){
        throw new Exception(curl_error($curl));
    }
    curl_close($curl);
    return json_decode($response, true);
}

$variaveis = [
    'id' => '1asd',
    'nome' => 'a',
    'data' => 1234
];

echo '<pre>';

$resultados = api_request('get_datetime');

print_r($resultados);

$status = api_request('status');

echo '<br>';

print_r($status);
