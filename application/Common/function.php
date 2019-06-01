<?php

if (! function_exists('get_client_ip')) {
    function get_client_ip() {
        $real_ip = getenv('HTTP_X_REAL_IP');

        if($real_ip) {
            return $real_ip;
        }

        if(getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }elseif(getenv('HTTP_CLIENT_IP')){
            $ip = getenv('HTTP_CLIENT_IP');
        }else{
            $ip = getenv('REMOTE_ADDR');
        }
        return $ip;
    }
}

if (! function_exists('list_to_tree')) {
    function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0) {
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}

if (! function_exists('export_csv')) {
    function export_csv($data, $titles, $fileName = '') {
        $csvData = '';

        $nums = count($titles);

        for ($i = 0; $i < $nums - 1; ++$i) {
            $csvData .= $titles[$i] . ',';
        }
        if ($nums > 0) {
            $csvData .= $titles[$nums - 1] . "\r\n";
        }

        foreach ($data as $k => $row) {
            $csvDataTmp = '';
            foreach ($row as $key => $r) {
                $row[$key] = str_replace("\"", "\"\"", $r);

                $csvDataTmp .= ',' . trim($row[$key]);
            }
            $csvData .= substr($csvDataTmp, 1) . "\r\n";
            unset($data[$k]);
        }

        $fileName = empty($fileName) ? date('Y-m-d-H-i-s', time()) : $fileName;

        header("Content-Type: application/force-download");
        header("Content-type:text/csv;charset=utf-8");
        header("Content-Disposition:filename={$fileName}.csv");

        echo iconv('utf-8', 'gb2312', $csvData);
    }
}