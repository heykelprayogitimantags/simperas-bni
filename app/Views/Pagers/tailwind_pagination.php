<?php if ($pager->hasPrevious() || $pager->hasNext()) : ?>
<nav class="flex items-center justify-between">
    
    <!-- Info -->
    <div class="text-sm text-gray-600">
        Menampilkan
        <span class="font-medium"><?= $pager->getFirstItem() ?></span>
        –
        <span class="font-medium"><?= $pager->getLastItem() ?></span>
        dari
        <span class="font-medium"><?= $pager->getTotal() ?></span>
        asset
    </div>

    <!-- Pagination -->
    <ul class="inline-flex items-center gap-1">
        
        <!-- Prev -->
        <li>
            <?php if ($pager->hasPrevious()) : ?>
                <a href="<?= $pager->getPrevious() ?>"
                   class="px-3 py-1 rounded-md bg-white border border-gray-300 text-gray-600 hover:bg-orange-500 hover:text-white transition">
                    &laquo;
                </a>
            <?php else : ?>
                <span class="px-3 py-1 rounded-md bg-gray-100 border border-gray-300 text-gray-400 cursor-not-allowed">
                    &laquo;
                </span>
            <?php endif ?>
        </li>

        <!-- Pages -->
        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <a href="<?= $link['uri'] ?>"
                   class="px-3 py-1 rounded-md border text-sm font-medium transition
                   <?= $link['active']
                        ? 'bg-orange-500 border-orange-500 text-white'
                        : 'bg-white border-gray-300 text-gray-600 hover:bg-orange-100' ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <!-- Next -->
        <li>
            <?php if ($pager->hasNext()) : ?>
                <a href="<?= $pager->getNext() ?>"
                   class="px-3 py-1 rounded-md bg-white border border-gray-300 text-gray-600 hover:bg-orange-500 hover:text-white transition">
                    &raquo;
                </a>
            <?php else : ?>
                <span class="px-3 py-1 rounded-md bg-gray-100 border border-gray-300 text-gray-400 cursor-not-allowed">
                    &raquo;
                </span>
            <?php endif ?>
        </li>

    </ul>
</nav>
<?php endif ?>
