
<?php
 
 /*
  *
     PHP接口代理转发：
     以Golang接口转发为例；
     如有必要，请设置内网IP为白名单；
     建议内网接口返回格式：Content-Type: text/html; charset=UTF-8；
  *
     使用示例：
     $host = "http://127.0.0.1:80/php-proxy/"; // 外网网址（主网址或有部分路径）
     $intranet = 'http://127.0.0.1:8000/'; // 内网网址（主网址或有部分路径）
     $php_proxy = new php_proxy();
     $back = $php_proxy->request_intranet($host, $intranet);
     echo $back;
  * */
 class php_proxy{
  
     // 发送get、post请求
     public function request_option($request_url='', $method='post', $request_data=[], $to_json=false): string{
         if (empty($request_url)) {
             $back = '{"state":0, "msg":"request_url is null", "content":""}';
         }else{
             if ($method == 'post' || $method == 'POST'){
                 $body = http_build_query($request_data);
                 $options = [
                     'http' => [
                         'method' => 'POST', // 注意要大写
                         'header' => 'Content-type:application/x-www-form-urlencoded',
                         'content' => $body,
                         'ignore_errors'=> true, // 忽略报错，直接返回接口内容
                     ],
                 ];
                 $context = stream_context_create($options);
                 $data = file_get_contents($request_url, false, $context);
             }else if ($method == 'get'|| $method == 'GET'){
                 $curl = curl_init();
                 curl_setopt($curl, CURLOPT_URL, $request_url);
                 curl_setopt($curl, CURLOPT_HEADER, 0); // 不抓取头部信息。只返回数据
                 curl_setopt($curl, CURLOPT_TIMEOUT, (int)60000); // 超时设置
                 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 1表示不返回bool值
                 $data = curl_exec($curl);
                 // $code = curl_getinfo($curl, CURLINFO_HTTP_CODE); // 获取接口状态码
                 curl_close($curl);
             }else{
                 $data = '{"state":0, "msg":"method error. method is only in [get, post], options etc be not supported.", "content":""}';
             }
  
             $back = $data;
         }
  
         if ($to_json == true){
             $res = json_encode($back, true);
         }else{
             $res = $back;
         }
  
         return $res;
     }
  
     // 获取完整网址
     public function get_url(): string{
         if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
             $url = 'https://';
         }else{
             $url = 'http://';
         }
         return $url.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
     }
  
     // 是post
     public function is_post(): bool{
         return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
     }
  
     // 是get
     public function is_get(): bool{
         return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'GET';
     }
  
     // 生成内网网址：把外网网址解析到内网网址
     public function make_request_url($host, $intranet): string{
         return str_replace($host, $intranet, $this->get_url()); // 实际代理地址（就是替换主网址或路径）
     }
  
     // 转发接口
     // 请从此处调用
     public function request_intranet($host, $intranet): string{
         // 测试的内网请求地址：$request_url = http://127.0.0.l:8000/api.gen1/admin
         $request_url = $this->make_request_url($host, $intranet);
         if ($this->is_post()){
             $request_array = $_REQUEST; // 请求参数数组
             $back = $this->request_option($request_url, 'post', $request_array, false);
         }else if ($this->is_get()){
             $request_array = [];
             $back = $this->request_option($request_url, 'get', $request_array, false);
         } else{
             $back = '{"state":0, "msg":"method error. method is only in [get, post], options etc be not supported.", "content":""}';
         }
         return $back;
     }
  
 }
  
  
 // 返回数据
 $host = "http://127.0.0.1:80/php-proxy/"; // 外网网址（主网址或有部分路径）
 $intranet = 'http://127.0.0.1:8000/'; // 内网网址（主网址或有部分路径）
 $php_proxy = new php_proxy();
 $back = $php_proxy->request_intranet($host, $intranet);
 echo $back;
 exit(200);