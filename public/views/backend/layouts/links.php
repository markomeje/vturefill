<div class="form-group input-group-lg mb-0">
    <select class="custom-select backend-links border text-muted" data-url="<?= DOMAIN; ?>">
    	<?php if(empty($backendLinks)): ?>
    		<option value="">No links yet</option>
        <?php else: ?>
            <?php foreach($backendLinks as $link): ?>
                <option value="<?= $link; ?>" <?= ($activeController == $link) ? "selected" : ""; ?>>
                	<?= ucfirst($link); ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>
