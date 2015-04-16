
<section class="instagram">

<? $posts = [] ?>
<?php
	function fetchData($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);

		$result = curl_exec($ch);

		curl_close($ch);
		return $result;
	}

	$accessToken = "XXX";
	$userId = "XXX";
	$result = fetchData("https://api.instagram.com/v1/users/" . $userId . "/media/recent/?access_token=" . $accessToken);
	$result = json_decode($result);
	$count = 10;
?>

<? try { ?>

	<? if($result!==false): ?>
		<? for($i = 0; $i < $count; $i++) :?>
			<? $post = $result->data[$i]; ?>
			<? $caption = (isset($post->caption->text)) ? $post->caption->text : false ;?>
			<? $likes = (isset($post->likes->count)) ? $post->likes->count : false ;?>
			<? $posts[(int)$post->created_time] = [
				'content'=>$post->images->standard_resolution->url,
				'likes'=>$post->likes->count,
				'url'=>$post->link,
				'caption'=>$caption,
			] ?>
		<? endfor; ?>
	<? endif; ?>

<? } catch (Exception $e) { ?>
	<p>Instagram Feed is Down</p>
<? } ?>

<?
	$i = 0;
	foreach ($posts as $time => $post):
		$i++;
		if ($i <= 10) {
?>

	<article class="post-wrap">
		<a href="<?= $post['url'] ?>" target="_blank">
			<figurestyle="background-image:url('<?= $post['content'] ?>');">
				<figcaption>
					<? if ($post['likes']): ?>
						<div class="likes-wrap">
							<p class="likes-wrap--likes"><?= $post['likes'] ?>
						</div>
					<? endif; ?>
					<? if ($post['caption']): ?>
						<div class="caption-wrap">
							<p class="post__instagram--caption"><?= substr($post['caption'], 0, 45) ?>...</p>
						</div>
					<? endif; ?>
				</figcaption>
			</figure>
		</a>
	</article>

		<? } ?>
	<? endforeach ?>
</section>
