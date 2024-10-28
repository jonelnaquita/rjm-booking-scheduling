<?php
function gw_send_sms($user, $pass, $sms_from, $sms_to, $sms_msg) {
    $query_string = "api.aspx?apiusername=" . urlencode($user)
        . "&apipassword=" . urlencode($pass)
        . "&senderid=" . urlencode($sms_from)
        . "&mobileno=" . urlencode($sms_to)
        . "&message=" . urlencode($sms_msg)
        . "&languagetype=1";

    $url = "http://gateway.onewaysms.com.au:10001/" . $query_string;
    $response = @file_get_contents($url);

    if ($response !== false) {
        if (trim($response) > 0) {
            return "success";
        } else {
            return "fail: " . htmlspecialchars($response);
        }
    } else {
        return "fail: No contact with gateway";
    }
}
?>
