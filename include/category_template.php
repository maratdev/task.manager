<li>
    <a href="?category=<?= $category['id']?>"><?= $category['title']?></a>
    <?php if (isset($category['childs'])):?>
    <ul>
        <?= categoriesToString($category['childs']); ?>
    </ul>
    <?php endif;?>
</li>