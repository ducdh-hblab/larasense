<?php

if (!function_exists('scan_folder')) {
    /**
     * @param $path
     * @param array $ignore_files
     * @return array
     */
    function scan_folder($path, $ignore_files = [])
    {
        try {
            if (is_dir($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..', '.DS_Store'], $ignore_files));
                natsort($data);
                return $data;
            }
            return [];
        } catch (\Exception $ex) {
            return [];
        }
    }
}

if (!function_exists('human_file_size')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function human_file_size($bytes, $decimals = 2)
    {
        $sz = 'BKMGTPE';
        $factor = (int)floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $sz[$factor];
    }
}

if (!function_exists('upload_max_size')) {
    function upload_max_size()
    {
        return convertToByte(ini_get('upload_max_filesize'));
    }
}

if (!function_exists('convertToByte')) {
    function convertToByte($size)
    {
        $sSuffix = strtoupper(substr($size, -1));
        if (!in_array($sSuffix, array('P', 'T', 'G', 'M', 'K'))) {
            return (int)$size;
        }
        $iValue = substr($size, 0, -1);

        switch ($sSuffix) {
            case 'P':
                $iValue *= pow(1024, 5);
                break;
            case 'T':
                $iValue *= pow(1024, 4);
                break;
            case 'G':
                $iValue *= pow(1024, 3);
                break;
            case 'M':
                $iValue *= pow(1024, 2);
                break;
            case 'K':
                $iValue *= pow(1024, 1);
                break;
        }

        return (int)$iValue;
    }
}
