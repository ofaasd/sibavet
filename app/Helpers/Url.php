<?php
	function makeUrl($urlLink = array()){
		$url['cari'] = "?";
		$url['all'] = "?";
		$no = 1;

	    foreach($urlLink as $key => $value){
        	if(!empty($value)){
        		if($no > 1){
        			if($key != "page"){
        				$url['cari'] .= "&";
        			}
        			$url['all'] .= "&";
        		}

        		if($key != "page"){
        			$url['cari'] .= $key."=".$value;
        		}
        		$url['all'] .= $key."=".$value;

        		$no++;
        	}
        }

        if($url['cari'] == '?'){
        	$url['cari'] = "";
        }
        if($url['all'] == '?'){
        	$url['all'] = "";
        }
	    return $url;
	}
?>
