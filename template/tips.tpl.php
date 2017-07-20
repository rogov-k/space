<? foreach ($data as $line): ?>
	<div class="tip" data-tip="<?php echo $line['id']; ?>"><span><?php echo $line['id']; ?></span><?php echo $line['name']; ?></div>
<? endforeach; ?>