<?php

$page = $data['pagination']['page'] ?? $data['pagination']['gallery']['page'];
$pages = $data['pagination']['pages'] ?? $data['pagination']['gallery']['pages'];
$url =  $data['pagination']['url'] ?? $data['pagination']['gallery']['url'];


?>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item <?= ($page-1 <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>?page=1"><<</a></li>
        <li class="page-item <?= ($page-1 <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>?page=<?= $page-1 ?>"> < </a></li>
        <li class="page-item <?= ($page-1 <= 0) ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>?page=<?= $page-1 ?>"><?= ($page-1 == 0 ) ? $page : (($page == $pages) ? $page-2 : $page-1) ?></a></li>
        <li class="page-item"><a class="page-link" href="<?= $url ?>?page=<?= ($page==1) ? $page+1 : (($page == $pages) ? $page-1 : $page) ?>"><?= ($page==1) ? $page+1 : (($page == $pages) ? $page-1 : $page) ?></a></li>
        <li class="page-item <?= ($page == $pages) ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>?page=<?= ($page==1) ? $page+2 : (($page == $pages) ? $page : $page+1) ?>"><?= ($page==1) ? $page+2 : (($page == $pages) ? $page : $page+1) ?></a></li>
        <li class="page-item <?= ($page == $pages) ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>?page=<?= $page+1 ?>"> > </a></li>
        <li class="page-item <?= ($page == $pages) ? 'disabled' : '' ?>"><a class="page-link" href="<?= $url ?>?page=<?= $pages ?>"> >> </a></li>
    </ul>
</nav>
