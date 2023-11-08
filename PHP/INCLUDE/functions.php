<?php
function validate(array $input, bool $checkNull = true) {
    $output = [];
    foreach ($input as $key => $value) {
        if (empty($_POST[$key])) {
            if ($checkNull == true) {
                return $_SESSION['error'] = $key. ' is leeg, vul in AUB';
            } else {
                $output[$key] = null;
            }
        } else {
            $output[$key] = checkData($value);
        }
    }
    return $output;
}

/**
 * @param string $data The data to be reformed to prevent an SQL injection.
 * @return string The checked data.
 */
function checkData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * @param string $sessionToken The name of the session token.
 * @return bool True if the session token exists, false if it doesn't.
 */
function sessionCheck(string $sessionToken) {
    if (isset($_SESSION[$sessionToken])) {
        return true;
    }
    return false;
}

/**
 * @param string $sessionToken The name of the session token.
 * @return string The session token surrounded by a div. 
 */
function sessionSet(string $sessionToken) {
    if (isset($_SESSION[$sessionToken])) {
        $buffer = $_SESSION[$sessionToken];
        unset($_SESSION[$sessionToken]);
        return
        '<div class="err__block">
            <div class="err__message">
                <span>'.$buffer.'</span>
            </div>
        </div>';
    }
}
?>