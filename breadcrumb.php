<?php
$breadcrumb = new BreadcrumbMatrix();
$data = $breadcrumb->data;
?>
<?php if(count($data) > 0) { ?>
    <nav class="bread bg-darker">
        <div class="container">
            <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                <?php $i = 0; ?>
                <?php foreach($data as $page) { ?>
                    <?php $i++; ?>
                    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?php echo $page['url']; ?>"><span itemprop="name"><?php echo $page['title']; ?></span></a>
                        <meta itemprop="position" content="<?php echo $i; ?>" />
                    </li>
                <?php } ?>
            </ol>
        </div>
    </nav>
<?php } ?>
