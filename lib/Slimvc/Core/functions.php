<?php
/**
 * Checks if an array is associative, returns true for yes, or not.
 * some examples as below,
 *     var_dump(is_assoc_array(array('a', 'b', 'c'))); // false
 *     var_dump(is_assoc_array(array("0" => 'a', "1" => 'b', "2" => 'c'))); // false
 *     var_dump(is_assoc_array(array("1" => 'a', "0" => 'b', "2" => 'c'))); // true
 *     var_dump(is_assoc_array(array("a" => 'a', "b" => 'b', "c" => 'c'))); // true
 *
 * @param array $var the array to be checked
 *
 * @return boolean
 */
function is_assoc_array($var)
{
    if (!is_array($var)) {
        return false;
    }
    return array_diff_assoc(array_keys($var), range(0, sizeof($var)))
    ? true
    : false;
}

/**
 * Converts camelized field names for setters and geters
 *
 * $this->setMyField($value) === $this->setData('my_field', $value)
 * Uses cache to eliminate unneccessary preg_replace
 *
 * @param string $name The camelized field name to be converted
 *
 * @return string
 */
function underscore($name)
{
    return strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $name));
}

/**
 * Tiny function to enhance functionality of ucwords
 * Will capitalize first letters and convert separators if needed
 *
 * @param string $str     The string to be capitalized
 * @param string $destSep The destinate seperator
 * @param string $srcSep  The source seperator
 *
 * @return string
 */
function uc_words($str, $destSep = '', $srcSep = '_')
{
    return str_replace(' ', $destSep, ucwords(str_replace($srcSep, ' ', $str)));
}

/**
 * Escape invalid characters in a real file path, such as '.', '/', '\'
 *
 * @param string $path the real path string to be escaped
 *
 * @return string
 */
function escape_real_path($path)
{
    return str_replace(array('.', '/', '\\'), '', $path);
}

/**
 * Checks if a string starts with another string
 *
 * @param string  $haystack The string to search in
 * @param string  $needle   The string to be checked with
 * @param boolean $case     Case sensitive or not
 *
 * @return boolean
 */
function str_starts_with($haystack, $needle, $case = true)
{
    if ($case) {
        return (strcmp(substr($haystack, 0, strlen($needle)), $needle)===0);
    }
    return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle)===0 );
}

/**
 * Checks if a string ends with another string
 *
 * @param string  $haystack The string to search in
 * @param string  $needle   The string to be checked with
 * @param boolean $case     Case sensitive or not
 *
 * @return boolean
 */
function str_ends_with($haystack, $needle, $case=true)
{
    if ($case) {
        return(
            strcmp(substr($haystack, strlen($haystack)-strlen($needle)), $needle)===0
        );
    }
    return (
        strcasecmp(substr($haystack, strlen($haystack)-strlen($needle)), $needle)===0
    );
}

/**
 * deal with the case-sensitive issue for in_array function
 *
 * @param mixed $needle   The searched value.
 * @param array $haystack The array.
 *
 * @return boolean
 */
function in_arrayi($needle, $haystack)
{
    for ($h = 0; $h < count($haystack); $h++) {
        $haystack[$h] = strtolower($haystack[$h]);
    }
    return in_array(strtolower($needle), $haystack);
}
