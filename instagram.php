<?php

function pr($data)
{
    echo "<pre>";
    print_r($data); // or var_dump($data);
    echo "</pre>";
}

?>

<?php
	// instagram user id lookup here https://codeofaninja.com/tools/find-instagram-user-id
	$instagram_uid = "XXX";

	// instruction to get your access token here https://www.codeofaninja.com/2015/05/get-instagram-access-token.html
	$access_token = "XXX.XXX.XXXXX";
	$photo_count = 500;

	$json_link = "https://api.instagram.com/v1/users/{$instagram_uid}/media/recent/?";
	$json_link .= "access_token={$access_token}&count={$photo_count}";

	$json = file_get_contents($json_link);
	$obj = json_decode($json, true, 1024);

	$tags_array = [];

	foreach ($obj['data'] as $post):

		$insta_img = str_replace("http://", "https://", $post['images']['standard_resolution']['url']);
		$insta_link = $post['link'];

		$insta_text = (isset($post['caption']['text'])) ? $post['caption']['text'] : false;
		$insta_likes = (isset($post['likes']['count'])) ? $post['likes']['count'] : false;
		$insta_username = $post['user']['username'];

		$insta_date = date("F j, Y", $post['created_time']);

		$insta_tags = (isset($post['tags'])) ? $post['tags'] : false;

		// pr($insta_tags);
		array_push($tags_array, $insta_tags);
		$flat_tags_array = call_user_func_array('array_merge', $tags_array);
		// die;

		?>

		<a href="<?php echo $insta_link ?>" target="_blank" class="insta__wrap" data-tags="<?php echo implode(" ",$insta_tags); ?>">

			<img data-original="<?php echo $insta_img ?>" alt="Instagram <?php echo $insta_username . ' ' . $insta_text ?>" class="insta__img">

			<noscript>
				<img src="<?php echo $insta_img ?>" alt="Instagram <?php echo $insta_username . ' ' . $insta_text ?>" class="insta__img">
			</noscript>

			<div class="insta__overlay">

				<p class="insta__copy"><?php echo $insta_text ?></p>
				<p class="insta__date"><?php echo $insta_date ?></p>

			</div>

		</a>



		<?php
	endforeach;
	$unique_tags_array = array_unique($flat_tags_array);
	// pr($unique_tags_array);

?>
