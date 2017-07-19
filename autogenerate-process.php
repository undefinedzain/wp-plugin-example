<?php
	// header("location:../../../wp-admin/admin.php?page=post-generator&success=true");

	class Spintax
	{
	    function process($text)
	    {
	        return preg_replace_callback(
	            '/\{(((?>[^\{\}]+)|(?R))*)\}/x',
	            array($this, 'replace'),
	            $text
	        );
	    }
	    function replace($text)
	    {
	        $text = $this->process($text[1]);
	        $parts = explode('|', $text);
	        return $parts[array_rand($parts)];
	    }
	}

    function setTitle($arrays, $i = 0)
    {
    	if (!isset($arrays[$i])) {
	        return array();
	    }
	    if ($i == count($arrays) - 1) {
	        return $arrays[$i];
	    }

	    // $spintax = new Spintax();
	    // get combinations from subsequent arrays
	    $tmp = setTitle($arrays, $i + 1);

	    $result = array();

	    // concat each array from tmp with each element from $arrays[$i]
	    foreach ($arrays[$i] as $v) {
	        foreach ($tmp as $t) {
	            $result[] = is_array($t) ? 
	                array_merge(array($v), $t) :
	                array($v, $t);
	        }
	    }

	    return $result;
    }


	/* EXAMPLE USAGE */
	$spintax = new Spintax();
	// $string = '{Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {Smith|Williams|Davis}!';
	sleep(2);
	// echo $spintax->process($string).'<br>';

	$title = $_POST['post_title'];
	$sufixs = $_POST['post_sufix'];
	$prefixs = $_POST['post_prefix'];
	$content = $_POST['post_content'];

	$prefix_array = explode(',', $prefixs);
	$sufix_array = explode(',', $sufixs);
	$words = [];
	$words[] = $prefix_array;
	$words[] = $sufix_array;

	$titles_result = setTitle($words);

	$last_title_result = [];
	$last_content_result = [];

	for ($m=0; $m < count($titles_result); $m++) { 
		$last_title_result[$m] = $titles_result[$m][0].' '.$title.' '.$titles_result[$m][1];
	}

	for ($z=0; $z < count($last_title_result); $z++) { 
		$last_content_result[$z] = $spintax->process($content);
	}

	$last_result = [];
	// $last_result['titles'] = $last_title_result;
	// $last_result['contents'] = $last_content_result;

	for ($p=0; $p < count($last_content_result); $p++) { 
		$new_array = [];
		$new_array['title'] = $last_title_result[$p];
		$new_array['content'] = $last_content_result[$p];
		array_push($last_result, $new_array);
	}

	echo json_encode($last_result);
	/* NESTED SPINNING EXAMPLE */
	// echo $spintax->process('{Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}');

?>