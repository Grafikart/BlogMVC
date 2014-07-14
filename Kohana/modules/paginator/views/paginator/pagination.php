<?php
$first_string = '<<&nbsp;';
$previous_string = 'Previous Page';
$next_string = 'Next Page';
$last_string = '&nbsp;>>';
?>
<style type="text/css">
    <!--
    .pagination a {
        border: 1px solid #CCCCCC;
        margin: 2px;
        padding: 0.1em 0.2em;
    }
    -->
</style>
<p class="pagination">
	<?php
	if ($first)
	{
		echo '<a href="' . $first . '" rel="first">' . $first_string . '</a>';
	}
	if ($previous)
	{
		echo '<a href="' . $previous . '" rel="previous">' . $previous_string . '</a>';
	}
	foreach ($pages_in_range as $key => $value)
	{
		$value ? print('<a href="' . $value . '">' . $key . '</a>')  : print $key;
	}
	if ($next)
	{
		echo '<a href="' . $next . '" rel="next">' . $next_string . '</a>';
	}
	if ($last)
	{
		echo '<a href="' . $last . '" rel="last">' . $last_string . '</a>';
	}
	?>
</p>
