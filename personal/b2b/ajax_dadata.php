<?php
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 07.03.2019
 * Time: 09:09
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context;
use Bitrix\Main\IO;
/*ini_set('display_errors','On');
error_reporting('E_ALL');*/

$request = Context::getCurrent()->getRequest();
$inn = $request->getPost("INN");
$response = [];
$file = new IO\File(__DIR__.'/log.dat');


if($request->isAjaxRequest() && $request->getPost("dadata")){
    $url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party";
    $headers = array(
        "Content-type: application/json",
        "Accept: application/json",
        "Authorization: Token 6cb3c00f3ab5bbab52787e39825516de0ca6797c"
    );

    $data = json_encode(['query'=>$inn, "status" =>"ACTIVE"]);
    $file->putContents("Export data from dadata service at: ".date("d-m-Y H:i:s", time())."\n", IO\File::APPEND);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        $response = ['STATUS'=>"error"];
        $file->putContents(curl_error($ch)."\n", IO\File::APPEND);
    } else {
        $response_vars = json_decode($data)->suggestions;
        $response_vars = get_object_vars($response_vars[0]);

        if(!$response_vars['value']){
            $response = ['STATUS'=>"error"];
        }else{
            $name = $response_vars['value'];
            $full_data = get_object_vars($response_vars['data']);
            $management = get_object_vars($full_data['management']);
            $mamagement_name = explode(" ", $management['name']);
            $address = get_object_vars(get_object_vars($full_data['address'])['data']);

            $response = [
                'STATUS'=>"success",
                'WORK_COMPANY'=>$name,
                'KPP' => $full_data['kpp'],
                'INN' => $full_data['inn'],
                'OGRN' => $full_data['ogrn'],
                'NAME' => $mamagement_name[0],
                'LAST_NAME' =>$mamagement_name[1],
                'CITY' => $address['city'],
                'STREET' => $address['street']." ".$address['house']
            ];
        }
        $file->putContents("RESPONSE: ".json_encode($response)."\n", IO\File::APPEND);
    }
    curl_close($ch);

    die(json_encode($response));
}

