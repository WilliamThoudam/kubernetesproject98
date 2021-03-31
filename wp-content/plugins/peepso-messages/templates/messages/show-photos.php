<?php
$PeepSoPhotos = PeepSoPhotos::get_instance();
$PeepSoMessages = PeepSoMessages::get_instance();
?>

<?php
$max_photos = isset($max_photos) ? $max_photos : 5;
$count_photos = isset($count_photos) ? $count_photos : $max_photos ;
$has_extra_photos = FALSE;

if( $count_photos > $max_photos ) {
	$has_extra_photos = TRUE;
}

$counter = 0;

echo '<div class="ps-media__attachment ps-media__attachment--photos">';
while ((++$counter <= $max_photos) && ($photo = $PeepSoPhotos->get_next_photo())) {
	if( TRUE === $has_extra_photos && $counter == $max_photos ) {
		$photo->has_extra_photos = $count_photos - $max_photos +1;
	}
	echo $PeepSoMessages->show_photo($photo);
}
echo '</div>';
?>
