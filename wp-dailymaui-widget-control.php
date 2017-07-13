<p>
<label for="dailymaui_title">Title: <input  name="dailymaui_title" type="text" value="<?php echo $title; ?>" /></label>
</p>
<p>
<label for="dailymaui_size">Style: <select  name="dailymaui_size" size="1">
	<option value="small" <?php echo $selected_small; ?>>Small (160 x 250)</option>
	<option value="medium" <?php echo $selected_medium; ?>>Medium (250 x 350)</option>
	<option value="thumb" <?php echo $selected_thumb; ?>>Date Only (150 x 105)</option>
	<option value="date" <?php echo $selected_date; ?>>Thumbnail (200 x 175)</option>
	<option value="classic" <?php echo $selected_full; ?>>Classic (250 x 300)</option>
</select></label>
			
<input type="hidden" id="dailymaui_submit" name="dailymaui_submit" value="1" />
</p>