<?php
function gst($str, $tite, $salsal){
  $c = explode($tite, $str);
  $d = explode($salsal, $c[1]);
  return $d[0];
}
extract($_GET);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://payments.paymaya.com/v2/checkout/result?id='.$id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Connection: keep-alive';
$headers[] = 'Pragma: no-cache';
$headers[] = 'Cache-Control: no-cache';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$raw = curl_exec($ch);
$data = json_decode('{'.gst($raw, 'window.SERVER_PARAMS = {', '};').'}', true);
$cS = $data['checkout']['paymentStatus'];
curl_close($ch);
if(strlen($cS) > 2 && $cS != 'AUTHENTICATING'){
  if($cS=='AUTHORIZED'){
    echo json_encode(['result' => 'SUCCESS', 'message' => 'LIVE CARD']);
  }elseif($cS=='PAYMENT_FAILED'){
    echo json_encode(['result' => 'FAILURE', 'message' => '<span class="badge badge-danger">'.$cS.'</span>' ]);
  }elseif($cS=='PAYMENT_SUCCESS'){
    echo json_encode(['result' => 'SUCCESS', 'message' => 'LIVE CARD']);
  }elseif($cS=='AUTH_FAILED'){
    echo json_encode(['result' => 'FAILURE', 'message' => '<span class="badge badge-danger">'.$cS.'</span>' ]);
  }else{
    http_response_code(400);
  }
}else{
  http_response_code(400);
}
?>