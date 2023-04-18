<?php

if (!function_exists('getColor')) {

    function getColor($num) {
        $hash = md5('color' . $num); // modify 'color' to get a different palette
        return array(
            hexdec(substr($hash, 0, 2)), // r
            hexdec(substr($hash, 2, 2)), // g
            hexdec(substr($hash, 4, 2))); //b
    }
}

if (!function_exists('hexToRgb')) {

    function hexToRgb($hex) {
        $split = str_split($hex, 2);
        $r = hexdec($split[0]);
        $g = hexdec($split[1]);
        $b = hexdec($split[2]);

        return "rgb(" . $r . ", " . $g . ", " . $b . ")";
    }
}

if (!function_exists('random_color_part')) {

    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('random_color')) {
    function random_color() {
        return random_color_part() . random_color_part() . random_color_part();
    }
}

if (!function_exists('rupiah')) {

    /**
     * convert string date system to string date indo
     *
     * @param string
     * @return string
     */
    function rupiah($string)
    {
        return number_format($string,2,",",".");
    }
}


if (!function_exists('tanggalIndo')) {

    /**
     * convert string date system to string date indo
     *
     * @param string
     * @return string
     */
    function tanggalIndo($date,$short_month = false)
    {
    	$time = strtotime($date);

    	return date('d',$time)." ".bulanIndo(date('m',$time),$short_month)." ".date('Y',$time);
    }
}

if (!function_exists('ApiClient')) {

    function ApiClient()
    {
        $client = new \GuzzleHttp\Client(['base_uri' => \config('app.whatsapp.uri')]);
        
        return $client;
    }
}

if (!function_exists('requestMessageText')) {

    function requestMessageText($url, $number, $message, $device = 'iphone-7')
    {
        $reqParams = [
            'token' => getTokenWA(),
            'url' => getUrlWA().'/'.$url,
            'method' => 'POST',
            'payload' => json_encode([
                'message' => $message,
                'phone_number' => $number,
                'message_type' => 'text',
                'device_id' => $device
            ])
        ];
        
        return $reqParams;
    }
}


if (!function_exists('apiKirimWaRequest')) {
    /**
     * Make a request to API KirimWA.id
     *
     * @param Array $params
     * @return Array
     * @throws Exception
     */
    function apiKirimWaRequest(array $params) {
        $httpStreamOptions = [
            'method' => $params['method'] ?? 'GET',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . ($params['token'] ?? '')
            ],
            'timeout' => 15,
            'ignore_errors' => true
        ];

        if ($httpStreamOptions['method'] === 'POST') {
            $httpStreamOptions['header'][] = sprintf('Content-Length: %d', strlen($params['payload'] ?? ''));
            $httpStreamOptions['content'] = $params['payload'];
        }

        // Join the headers using CRLF
        $httpStreamOptions['header'] = implode("\r\n", $httpStreamOptions['header']) . "\r\n";

        $stream = stream_context_create(['http' => $httpStreamOptions]);
        $response = @file_get_contents($params['url'], false, $stream);

      // Headers response are created magically and injected into
      // variable named $http_response_header
        $httpStatus = $http_response_header[0];

        preg_match('#HTTP/[\d\.]+\s(\d{3})#i', $httpStatus, $matches);

        if (! isset($matches[1])) {
            throw new Exception('Can not fetch HTTP response header.');
        }

        $statusCode = (int)$matches[1];
        if ($statusCode >= 200 && $statusCode < 300) {
            return ['body' => $response, 'statusCode' => $statusCode, 'headers' => $http_response_header];
        }

        throw new Exception($response, $statusCode);
    }
}

if (!function_exists('getTokenWA')) {

    function getTokenWA()
    {
        return \config('app.whatsapp.token');
    }
}

if (!function_exists('getUrlWA')) {

    function getUrlWA()
    {
        return \config('app.whatsapp.uri');
    }
}

if (!function_exists('ApiHeader')) {

    function ApiHeader()
    {
        $headers = [
            'Authorization' => 'Bearer ' . \config('app.whatsapp.token'),        
            'Accept'        => 'application/json'
        ];

        return $headers;
    }
}

if (!function_exists('statusOrder')) {

    /**
     * convert string date system to string date indo
     *
     * @param string
     * @return string
     */
    function statusOrder($status)
    {
        $param = "";
        if ($status == "keranjang")
        {
            $param = 0;
        }
        else if ($status == "baru")
        {
            $param = 1;
        }
        else if ($status == "diterima")
        {
            $param = 2;
        }
        else if ($status == "diproses")
        {
            $param = 3;
        }
        else if ($status == "dikirim")
        {
            $param = 4;
        }
        else if ($status == "sampai")
        {
            $param = 5;
        }
        else if ($status == "selesai-order")
        {
            $param = 6;
        }
        else if ($status == "dibatalkan")
        {
            $param = 7;
        }
        else if ($status == "selesai-dibatalkan")
        {
            $param = 8;
        }

        return $param;
    }
}

if (!function_exists('bulanIndo')) {

    /**
     * conver number of month to month name
     *
     * @param int
     * @return string
     */
    function bulanIndo($no,$short = false) {
        $no = (int) $no;
        switch ($no) {
            case 1:return $short ? 'Jan' : 'Januari';break;
            case 2:return $short ? 'Feb' : 'Februari';break;
            case 3:return $short ? 'Mar' : 'Maret';break;
            case 4:return $short ? 'Apr' : 'April';break;
            case 5:return $short ? 'Mei' : 'Mei';break;
            case 6:return $short ? 'Jun' : 'Juni';break;
            case 7:return $short ? 'Jul' : 'Juli';break;
            case 8:return $short ? 'Agu' : 'Agustus';break;
            case 9:return $short ? 'Sep' : 'September';break;
            case 10:return $short ? 'Okt' : 'Oktober';break;
            case 11:return $short ? 'Nov' : 'November';break;
            case 12:return $short ? 'Des' : 'Desember';break;
        }
        return '-';
    }
}

if (!function_exists('role')) {

    /**
     * conver number of month to month name
     *
     * @param int
     * @return string
     */
    function role($role) {

        $param = 0;
        
        if ($role == 'admin')
        {
            $param = 1;
        }
        else if ($role == 'pelanggan')
        {
            $param = 2;
        }
        else if ($role == 'pimpinan')
        {
            $param = 3;
        }

        return $param;
    }
}


if (!function_exists('listtahun')) {

    function listtahun($mundurBerapaTahun) {
        $tahun = [];
        for($i=date('Y'); $i>=date('Y')-$mundurBerapaTahun; $i-=1){
            $tahun[] = (object) [
                'tahun' => ''.$i
            ];
        }
        return $tahun;
    }
}

if (!function_exists('listBulan')) {

    function listBulan() {
        $bulan = [
            (object)[
                'nama' => 'Januari',
                'value' => 1,
            ],
            (object)[
                'nama' => 'Februari',
                'value' => 2,
            ],
            (object)[
                'nama' => 'Maret',
                'value' => 3,
            ],
            (object)[
                'nama' => 'April',
                'value' => 4,
            ],
            (object)[
                'nama' => 'Mei',
                'value' => 5,
            ],
            (object)[
                'nama' => 'Juni',
                'value' => 6,
            ],
            (object)[
                'nama' => 'Juli',
                'value' => 7,
            ],
            (object)[
                'nama' => 'Agustus',
                'value' => 8,
            ],
            (object)[
                'nama' => 'September',
                'value' => 9,
            ],
            (object)[
                'nama' => 'Oktober',
                'value' => 10,
            ],
            (object)[
                'nama' => 'November',
                'value' => 11,
            ],
            (object)[
                'nama' => 'Desember',
                'value' => 12,
            ]
        ];
        return $bulan;
    }
}

if (!function_exists('rangeDate')) {

    /**
     * conver number of month to month name
     *
     * @param int
     * @return string
     */
    function rangeDate($date_start,$date_end,$short_month = false, $separator = '-') {
        $start=strtotime($date_start);
        $end=strtotime($date_end);

        if ($date_start == $date_end) 
        {
            return date('d',$start).' '.bulanIndo(date('m',$start),$short_month).' '.date('Y',$start);
        }
        elseif (date('Y-m',$start) == date('Y-m',$end)) 
        {
            return date('d',$start)." {$separator} ".date('d',$end).' '.bulanIndo(date('m',$start),$short_month).' '.date('Y',$start);
        }
        elseif (date('Y',$start) == date('Y',$end))
        {
            return date('d',$start).' '.bulanIndo(date('m',$start),$short_month)." {$separator} ".date('d',$end).' '.bulanIndo(date('m',$end),$short_month).' '.date('Y',$end);
        }
        else
        {
            return date('d',$start).bulanIndo(date('m',$start),$short_month).' '.date('Y',$start)." {$separator} ".date('d',$end).' '.bulanIndo(date('m',$end),true).' '.date('Y',$end);
        }
    }
}

if (!function_exists('hashDecoded')) {

    /**
     * decode hashids
     *
     * @param string
     * @return string
     */
    function hashDecoded($hash) {
        $decode = \Hashids::decode($hash);
        return count($decode) > 0  ? $decode[0] : false;
    }
}

if (!function_exists('dayToNumber')) {

    /**
     * convert day to number
     *
     * @param string
     * @return int
     */
    function dayToNumber($day) {
        switch ($day) {
            case 'senin':return 1;break;
            case 'selasa':return 2;break;
            case 'rabu':return 3;break;
            case 'kamis':return 4;break;
            case 'jumat':return 5;break;
            case 'sabtu':return 6;break;
            case 'minggu':return 7;break;
        }
        return 0;
        
    }
}

if (!function_exists('numberToDay')) {

    /**
     * convert number to day
     *
     * @param string
     * @return int
     */
    function numberToDay($number) 
    {
        switch ($number) {
            case 1:return 'senin';break;
            case 2:return 'selasa';break;
            case 3:return 'rabu';break;
            case 4:return 'kamis';break;
            case 5:return 'jumat';break;
            case 6:return 'sabtu';break;
            case 7:return 'minggu';break;
        }
        return '';
        
    }
}

if (!function_exists('differentTime')) {

   
    function differentTime($tanggal) 
    {
        $startTime = \Carbon\Carbon::parse($tanggal);
        $finishTime = \Carbon\Carbon::parse(\Carbon\Carbon::now());

        $detik = $finishTime->diffInSeconds($startTime);
        $menit = $finishTime->diffInMinutes($startTime);
        $jam = $finishTime->diffInHours($startTime);
        $hari = $finishTime->diffInDays($startTime);

        if ($detik > 0 && $detik <= 60) {
            $time = $detik.' detik yang lalu';
        }else if($detik > 60 && $detik < 3600){
            $time = $menit.' menit yang lalu';
        }else if($detik > 3600 && $detik < 86400){
            $time = $jam.' jam yang lalu';
        }else if($detik > 86400 && $detik < 172800){
            $time = $hari.' jam yang lalu';
        }else{
            $time = date('G:i', strtotime($tanggal));
        }

        return $time;
        
    }
}

if (!function_exists('slug')) {

    /**
     * convert raw string to slug format
     *
     * @param string
     * @param string (nullable)
     * @return string
     */
    function slug($str,$delimiter = '-')
    {
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace("/[']/", '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }
}

if (!function_exists('numberToNameColumn')) {

    /**
     * convert number to name column excel
     *
     * @param int
     * @return string
     */
    function numberToNameColumn($num) {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num - 1) / 26);
        if ($num2 > 0) {
            return numberToNameColumn($num2) . $letter;
        } else {
            return $letter;
        }
    }
}