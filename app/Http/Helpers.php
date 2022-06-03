<?php
function shortPhone($phone)
{
    return "0" . substr($phone, -9);
}


function hasPermissionTo($title,$job)
{
    $permissionList = \App\Models\PermissionsList::where('title',$title)->where('job_title_id',$job)->exists();
    return $permissionList;
}

function getRequestStatus($type)
{
    switch ($type) {
        default:
            return '<span class="badge badge-primary">طلب جديد</span>';
        case "WAITING_INFO_COMPLATE":
            return '<span class="badge badge-warning">تم ارسال تنبيه اكمال البيانات</span>';
        case "INFO_COMPLATE_NOTIFY":
            return '<span class="badge badge-danger">تم ارسال التنبيه الثاني لإكمال البيانات</span>';
        case "WAITING_APPROVE":
            return '<span class="badge badge-danger">بانتظار الاعتماد</span>';
        case "APPROVED":
            return '<span class="badge badge-primary">بانتظار تحديد جلسة</span>';
        case "SCHEDULED":
            return '<span class="badge badge-success">تم جدولته</span>';
        case "RESCHEDULED":
            return '<span class="badge badge-primary">معاد جدولته</span>';
        case "COMPLATED":
            return '<span class="badge badge-success">منتهي</span>';
        case "CANCELLED":
            return '<span class="badge badge-danger">ملغي</span>';
    }
}

function getRequestType($type)
{
    if ((int)$type == -1) {
        return "أخرى";
    }

    $reasons = \App\Models\CasesReason::where('reason_id', (int)$type)->first();
    if (!$reasons) {
        return "غير محدد";
    }
    return empty($reasons->title) ? "غير محدد" : $reasons->title;
}

function getRequestSessionStatus($type)
{
    switch ($type) {
        default:
            return '<span class="badge badge-warning">قيد الانتظار</span>';
        case "reschedule":
            return '<span class="badge badge-primary">جلسة معادة جدولتها</span>';
        case "finish":
            return '<span class="badge badge-info">جلسة منتهية بالتحكيم</span>';
        case "unfinish":
            return '<span class="badge badge-secondary">جلسة غير منتهية </span>';
        case "not_responding":
            return '<span class="badge badge-danger">جلسة منتهية بتعذر التحكيم</span>';
    }
}

function timer($_date = "", $format_date = 'd/m/Y', $fixDate = 0)
{
    if (empty($_date)) {
        $_date = time();
    }
    if (!is_numeric($_date) && stristr($_date, '/')) {
        return $_date;
    }

    if (!stristr($_date, '/') && is_numeric($_date) == true) {
        return str_replace(array("am", "pm"), array("ص", "م"), date($format_date, $_date));
    }
}

function formatSeconds($seconds)
{
    $hours = 0;
    $milliseconds = str_replace("0.", '', $seconds - floor($seconds));

    if ($seconds > 3600) {
        $hours = floor($seconds / 3600);
    }
    $seconds = $seconds % 3600;


    return str_pad($hours, 2, '0', STR_PAD_LEFT)
        . gmdate(':i:s', $seconds)
        . ($milliseconds ? ".$milliseconds" : '');
}

function getMeetingLocation($location)
{
    switch ($location) {
        default:
            return "--";
        case "inside_building":
            return "داخل الجمعية";
        case "zoom_meeting":
            return "من على بعد";
        case "booth":
            return "كلاهما";
    }
}


function formatSecondsFromTime($past, $future)
{
    if ($past == 0) return "00:00:00";
    $seconds = ($future - (int)$past);
    $hours = 0;
    $milliseconds = str_replace("0.", '', $seconds - floor($seconds));

    if ($seconds > 3600) {
        $hours = floor($seconds / 3600);
    }
    $seconds = $seconds % 3600;


    return str_pad($hours, 2, '0', STR_PAD_LEFT)
        . gmdate(':i:s', $seconds)
        . ($milliseconds ? ".$milliseconds" : '');
}

function formatSecondsFromPast($time)
{
    if ($time == 0) return "00:00:00";
    $seconds = (time() - (int)$time);
    $hours = 0;
    $milliseconds = str_replace("0.", '', $seconds - floor($seconds));

    if ($seconds > 3600) {
        $hours = floor($seconds / 3600);
    }
    $seconds = $seconds % 3600;


    return str_pad($hours, 2, '0', STR_PAD_LEFT)
        . gmdate(':i:s', $seconds)
        . ($milliseconds ? ".$milliseconds" : '');
}

function fixPhoneNumber($phone)
{
    if (strlen($phone) == 10) {
        $phone = "966" . substr($phone, 1);
    }
    else if (strlen($phone) == 14) {
        $phone = substr($phone, 2);
    }
    else if (strlen($phone) != 12 && strlen($phone) != 13) {
        $phone = "966" . $phone;
    }

    return $phone;
}



function _timestamp($date, $format = 'Y/m/d')
{
    $date = DateTime::createFromFormat($format, $date);
    if (!$date) {
        return time();
    }
    return $date->getTimestamp();
}

function createRandomKey($amount = '5', $keyset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789")
{
    $randKey = '';
    for ($i = 0; $i < $amount; $i++) {
        $randKey .= substr($keyset, rand(0, strlen($keyset) - 1), 1);
    }
    return $randKey;
}

function sendSMS($numbers, $msg = '', $pre = "966")
{
    $msg = str_replace("&", "", $msg);
    $msg = str_replace("+", "", $msg);

    if (is_array($numbers)) {
        $tmpArray = array();
        foreach ($numbers as $key => $value) {
            if (!is_numeric($value) || empty($value) || strlen($value) < 9 || in_array($pre . substr($value, 1), $tmpArray) || (strlen($value) > 14 && in_array($pre . $value, $tmpArray))) {
                unset($numbers[$key]);
            }
            else {
                if (strlen($value) == 10) {
                    $numbers[$key] = $pre . substr($value, 1);
                }
                else if (strlen($value) == 14) {
                    $numbers[$key] = substr($value, 2);
                }
                else if (strlen($value) != 12 && strlen($value) != 13) {
                    $numbers[$key] = $pre . $value;
                }
                $tmpArray[] = $numbers[$key];
            }
        }
        if (!empty($tmpArray)) {
            $phones = join(",", $tmpArray);
        }
        else {
            $phones = '';
        }
    } else {
        if (strlen($numbers) == 10) {
            $phones = $pre . substr($numbers, 1);
        }
        else if (strlen($numbers) == 14) {
            $phones = substr($numbers, 2);
        }
        else if (strlen($numbers) != 12 && strlen($numbers) != 13) {
            $phones = $pre . $numbers;
        }
        else {
            $phones = $numbers;
        }
    }


    if (empty($phones) || $msg == '') {
        $this->SMSerror = "empty numbers or msg";
        return false;
    }

    $phones = str_replace("&", "", $phones);
    $phones = str_replace("+", "", $phones);
    $url = "http://www.isms.ws/api/sendsms.php?username=966550221414&password=225588&message=" . urlencode($msg) . "&numbers=.$phones.&sender=tawafoq&unicode=u&return=full";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $result = curl_exec($ch);
    $result = json_decode($result, true);

    $smsLog = new \App\Models\SmsLog();
    $smsLog->numbers = $phones;
    $smsLog->msg = $msg;
    $smsLog->userid = auth()->user()->userid;
    $smsLog->dateadd = time();
    $smsLog->location = $_SERVER["REQUEST_URI"];
    $smsLog->save();

    return $result;
}

function gen_uuid()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        mt_rand(0, 0xffff),

        mt_rand(0, 0x0fff) | 0x4000,

        mt_rand(0, 0x3fff) | 0x8000,

        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function shortUrl($link)
{

    $bitlyToken = 'c0b29a11df0c7b2203b1cc84e62133b3304d1ce3';
    $post = array(
        'long_url' => $link
    );
    $payload = json_encode($post);

    $headers = array('Authorization: Bearer ' . $bitlyToken,
        'Content-Type: application/json', 'Content-Length: ' . strlen($payload));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api-ssl.bitly.com/v4/bitlinks');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = json_decode(curl_exec($ch), true);
    $return = array("error" => false);
    if (curl_errno($ch)) {
        $return["error"] = true;
        $return["message"] = curl_error($ch);
        $return["link"] = $link;
    }
    curl_close($ch);
    if (count($result["errors"]) > 0) {
        $return["error"] = true;
        $return["message"] = $result["message"];
        $return["link"] = $link;
        return $return;
    }
    $return["link"] = $result["link"];
    return $return;
}

function getShortLink($link)
{
    $info = shortUrl($link);
    return $info["link"];
}
