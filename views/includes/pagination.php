<?php

$page = $data['pagination']['page'] ?? $data['pagination']['gallery']['page'];
$pages = $data['pagination']['pages'] ?? $data['pagination']['gallery']['pages'];
$url =  $data['pagination']['url'] ?? $data['pagination']['gallery']['url'];


?>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php if ($pages > 2): ?>
            <?php if($page > 1): ?>
            <li class="page-item <?= ($page-1 <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>?page=1"><<</a></li>
            <li class="page-item <?= ($page-1 <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>?page=<?= $page-1 ?>"> < </a></li>
            <?php endif; ?>
            <li class="page-item <?= ($page-1 <= 0) ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>?page=<?= $page-1 ?>"><?= ($page-1 == 0 ) ? $page : (($page == $pages) ? $page-2 : $page-1) ?></a></li>

            <li class="page-item"><a class="page-link" href="<?= $url ?>?page=<?= ($page==1) ? $page+1 : (($page == $pages) ? $page-1 : $page) ?>"><?= ($page==1) ? $page+1 : (($page == $pages) ? $page-1 : $page) ?></a></li>
            <li class="page-item <?= ($page == $pages) ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>?page=<?= ($page==1) ? $page+2 : (($page == $pages) ? $page : $page+1) ?>"><?= ($page==1) ? $page+2 : (($page == $pages) ? $page : $page+1) ?></a></li>
            <?php if($page < $pages): ?>
            <li class="page-item "><a class="page-link" href="<?= $url ?>?page=<?= $page+1 ?>"> > </a></li>
            <li class="page-item "><a class="page-link" href="<?= $url ?>?page=<?= $pages ?>"> >> </a></li>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
</nav>
