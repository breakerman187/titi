<?php

class PayMaya{
  public $checker_info;
  public $checker_data;
  public $cc;
  public $mm;
  public $yyyy;
  public $cvv;
  public $log;
  
  public function __construct($card){
    
    list($this->cc, $this->mm, $this->yyyy, $this->cvv) = $card;
    $this->log[] = 'OK';
    $this->checker_data['files']['global']['main_checkout'] = 'main_checkout_paymaya.txt';
    $this->checker_data['files']['cookies'] = ['first' => mt_rand().'.txt', 'second' => mt_rand().'.txt'];
    $this->checker_data['paymaya']['ua'] = 'Mozilla/5.0 (Linux; Android 7.0; SM-G892A Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/60.0.3112.107 Mobile Safari/537.36';
    
  }
  
  public function log($data){
    $this->log[] = $data;
  }
  
  public function gst($str, $tite, $salsal){
  
    $c = explode($tite, $str);
    $d = explode($salsal, $c[1]);
    return $d[0];
  
  }
  
  public function genesis(){
    
    echo $genesis = shell_exec("curl 'https://store.paymaya.com/cart/add' \
      -H 'authority: store.paymaya.com' \
      -H 'pragma: no-cache' \
      -H 'cache-control: no-cache' \
      -H 'upgrade-insecure-requests: 1' \
      -H 'origin: https://store.paymaya.com' \
      -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryDtVvem6kZ9UlsquF' \
      -H 'user-agent: ".$this->checker_data['paymaya']['ua']."' \
      -H 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9' \
      -H 'sec-fetch-site: same-origin' \
      -H 'sec-fetch-mode: navigate' \
      -H 'sec-fetch-user: ?1' \
      -H 'sec-fetch-dest: document' \
      -H 'referer: https://store.paymaya.com/products/paymaya-contactless-card?variant=29369121603653' \
      -H 'accept-language: en-US,en;q=0.9' \
      --data-binary $'------WebKitFormBoundaryDtVvem6kZ9UlsquF\r\nContent-Disposition: form-data; name=\"form_type\"\r\n\r\nproduct\r\n------WebKitFormBoundaryDtVvem6kZ9UlsquF\r\nContent-Disposition: form-data; name=\"utf8\"\r\n\r\n✓\r\n------WebKitFormBoundaryDtVvem6kZ9UlsquF\r\nContent-Disposition: form-data; name=\"id\"\r\n\r\n29369121603653\r\n------WebKitFormBoundaryDtVvem6kZ9UlsquF\r\nContent-Disposition: form-data; name=\"quantity\"\r\n\r\n1\r\n------WebKitFormBoundaryDtVvem6kZ9UlsquF\r\nContent-Disposition: form-data; name=\"add\"\r\n\r\n\r\n------WebKitFormBoundaryDtVvem6kZ9UlsquF--\r\n' \
      --compressed \
      --cookie-jar /home/bitnami/stack/nginx/html/'".$this->checker_data['files']['cookies']['first']."'");
    
    if(substr_count($genesis, '429 Too Many Requests') > 0){
      return false;
    }
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://store.paymaya.com/cart');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/'.$this->checker_data['files']['cookies']['first']);
    curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/'.$this->checker_data['files']['cookies']['first']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "updates%5B%5D=1&checkout=Check+out");

    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Authority: store.paymaya.com';
    $headers[] = 'Pragma: no-cache';
    $headers[] = 'Cache-Control: no-cache';
    $headers[] = 'Upgrade-Insecure-Requests: 1';
    $headers[] = 'Origin: https://store.paymaya.com';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $headers[] = 'User-Agent: '.$this->checker_data['paymaya']['ua'];
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    $headers[] = 'Sec-Fetch-Site: same-origin';
    $headers[] = 'Sec-Fetch-Mode: navigate';
    $headers[] = 'Sec-Fetch-User: ?1';
    $headers[] = 'Sec-Fetch-Dest: document';
    $headers[] = 'Referer: https://store.paymaya.com/cart';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    echo $data = curl_exec($ch);
    curl_close($ch);
    
    $this->checker_data['paymaya']['checkout_url'] = (string)$this->gst($data, 'You are being <a href="', '"');
    fwrite(fopen($this->checker_data['files']['global']['main_checkout'], 'w'), $this->checker_data['paymaya']['checkout_url']);
    return true;
  }
  
  public function unconditional(){
    $url = file_get_contents($this->checker_data['files']['global']['main_checkout']);
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://southstardrug.com.ph/25718849583/checkouts/e77ab3d7e2f840d7f5520e94c43bbe41/forward?complete=1&previous_step=payment_method&step=');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Authority: store.paymaya.com';
    $headers[] = 'Pragma: no-cache';
    $headers[] = 'Cache-Control: no-cache';
    $headers[] = 'Upgrade-Insecure-Requests: 1';
    $headers[] = 'User-Agent: '.$this->checker_data['paymaya']['ua'];
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    $headers[] = 'Sec-Fetch-Site: none';
    $headers[] = 'Sec-Fetch-Mode: navigate';
    $headers[] = 'Sec-Fetch-User: ?1';
    $headers[] = 'Sec-Fetch-Dest: document';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $data = curl_exec($ch);
    curl_close($ch);
    
    foreach(explode('<br />', nl2br(trim($this->gst($data, '<input type="submit" name="commit" value="Continue to payment" class="full-page-overlay__btn btn hidden-if-js" />'."\n", '</form')))) as $f_d){
      $this->checker_data['paymaya']['form1']['data'][$this->gst($f_d, 'name="', '"')] = $this->gst($f_d, 'value="', '"');
    }
    
    $te = http_build_query($this->checker_data['paymaya']['form1']['data']);
    unset($this->checker_data['paymaya']['form1']['data']);
    $this->checker_data['paymaya']['form1']['data'] = $te;
    
  }
  
  public function love(){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://lhux1e6adl.execute-api.ap-southeast-1.amazonaws.com/production/purchase');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->checker_data['paymaya']['form1']['data']);

    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Authority: lhux1e6adl.execute-api.ap-southeast-1.amazonaws.com';
    $headers[] = 'Pragma: no-cache';
    $headers[] = 'Cache-Control: no-cache';
    $headers[] = 'Upgrade-Insecure-Requests: 1';
    $headers[] = 'Origin: https://store.paymaya.com';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36';
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    $headers[] = 'Sec-Fetch-Site: cross-site';
    $headers[] = 'Sec-Fetch-Mode: navigate';
    $headers[] = 'Sec-Fetch-Dest: document';
    $headers[] = 'Referer: https://store.paymaya.com/';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $data = curl_exec($ch);
    curl_close($ch);
    
    $this->checker_data['paymaya']['checkout_pay_url'] = $this->gst($data, 'location: ', "\n");
    $this->checker_data['payamya']['checkout_id'] = trim($this->gst($this->checker_data['paymaya']['checkout_pay_url'].'madebyredpenguin', 'https://payments.paymaya.com/v2/checkout?id=', 'madebyredpenguin'));
    
  }
  
  public function is(){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://payments.paymaya.com/v2/payments/auth');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"checkoutId":"'.$this->checker_data['payamya']['checkout_id'].'","card":{"number":"'.$this->cc.'","expMonth":"'.$this->mm.'","expYear":"'.$this->yyyy.'","cvc":"'.$this->cvv.'"},"buyer":{"firstName":"Red","lastName":"Penguin"}}');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Connection: keep-alive';
    $headers[] = 'Pragma: no-cache';
    $headers[] = 'Cache-Control: no-cache';
    $headers[] = 'Accept: application/json, text/plain, */*';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36';
    $headers[] = 'Content-Type: application/json;charset=UTF-8';
    $headers[] = 'Origin: https://payments.paymaya.com';
    $headers[] = 'Sec-Fetch-Site: same-origin';
    $headers[] = 'Sec-Fetch-Mode: cors';
    $headers[] = 'Sec-Fetch-Dest: empty';
    $headers[] = 'Referer: https://payments.paymaya.com/v2/checkout?id=e5564fcc-5b10-452d-a249-94406c37efce';
    $headers[] = 'Accept-Language: en-US,en;q=0.9';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $data = json_decode(curl_exec($ch), true);
    curl_close($ch);
    extract($data['3dsValues']);
    $url =$data['3dsUrl'];
    $this->checker_data['construct'] = ['url' => $url, 'TermUrl' => $TermUrl, 'PaReq' => $PaReq, 'MD' => $MD];
    
  }
  
  public function orchestrate(){
    
    $_SESSION['values'] = $this->checker_data['construct'];
    $id = $this->checker_data['payamya']['checkout_id'];
    $card = ''.$this->cc.'|'.$this->mm.'|'.$this->yyyy.'|'.$this->cvv.'';
    echo json_encode(['checkout_id' => $id, 'card' => $card]);
    
  }
  
  public function exhibitForm($argdd){
    extract($argdd);
    echo "<form action='$url' id='3ds' method='POST'><input type='hidden' name='PaReq' value='$PaReq'><input type='hidden' name='MD' value='$MD'><input type='hidden' name='TermUrl' value='$TermUrl'>".'<script type="text/javascript">window.onload=function(){document.forms["3ds"].submit();}</script>';
  }
  
  public function removeFiles($in){
    unlink((string)$in);
  }
  
  public function catchError(){
    
    foreach($this->log as $log){
      
      fwrite(fopen('error'.time(), 'a'), $log."\r\n");
      
    }
    
  }
  
}

?>