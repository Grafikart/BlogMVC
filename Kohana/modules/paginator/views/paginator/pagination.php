<?php
$first_string = '<<&nbsp;';
$previous_string = 'Previous Page';
$next_string = 'Next Page';
$last_string = '&nbsp;>>';
?>

<ul class="pagination">
	<?php
	if ($first)
	{
		echo '<li><a href="' . $first . '" rel="first">' . $first_string . '</a></li>';
	}
	if ($previous)
	{
		echo '<li><a href="' . $previous . '" rel="previous">' . $previous_string . '</a></li>';
	}
	foreach ($pages_in_range as $key => $value)
	{
		echo '<li' . ((!$value) ? ' class="active"' : '') .'><a href="' . $value . '">' . $key . '</a></li>';
	}
	if ($next)
	{
		echo '<li><a href="' . $next . '" rel="next">' . $next_string . '</a></li>';
	}
	if ($last)
	{
		echo '<li><a href="' . $last . '" rel="last">' . $last_string . '</a></li>';
	}
	?>
</ul>
