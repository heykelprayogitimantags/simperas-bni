<?php
/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<nav aria-label="Page navigation">
    <ul class="flex items-center justify-center space-x-1">
        
        <?php if ($pager->hasPrevious()) : ?>
            <!-- First Page -->
            <li>
                <a href="<?= $pager->getFirst() ?>" class="px-3 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium transition-colors">
                    <i class="fas fa-angle-double-left"></i>
                </a>
            </li>
            
            <!-- Previous Page -->
            <li>
                <a href="<?= $pager->getPrevious() ?>" class="px-3 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium transition-colors">
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <?php if ($link['active']) : ?>
                    <span class="px-4 py-2 rounded-lg bg-orange-500 text-white text-sm font-semibold">
                        <?= $link['title'] ?>
                    </span>
                <?php else : ?>
                    <a href="<?= $link['uri'] ?>" class="px-4 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium transition-colors">
                        <?= $link['title'] ?>
                    </a>
                <?php endif ?>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <!-- Next Page -->
            <li>
                <a href="<?= $pager->getNext() ?>" class="px-3 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium transition-colors">
                    <i class="fas fa-angle-right"></i>
                </a>
            </li>
            
            <!-- Last Page -->
            <li>
                <a href="<?= $pager->getLast() ?>" class="px-3 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium transition-colors">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            </li>
        <?php endif ?>
        
    </ul>
    
    <!-- Info -->
    <div class="mt-3 text-center text-sm text-gray-600">
        Menampilkan halaman <?= $pager->getCurrentPagenumber() ?> dari <?= $pager->getPageCount() ?>
    </div>
</nav>