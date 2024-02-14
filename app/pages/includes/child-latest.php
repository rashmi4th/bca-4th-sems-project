<div class=" span-transform-4-6">
    <!-- <div class="int-list-news"> -->
    <div class="cat-3-cards">
    <a href="<?= ROOT ?>/post/<?= $row['slug'] ?>">
            <!-- <div class="int-list-news-img"> -->
            <div class="cat-3-cards-img">
            <img src="<?= get_image($row['image']) ?>">
            </div>
            <div class="cat-3-cards-info">
                <h6> <?=$row['title']?></h6>
                <div class="upload-detail">
                    <i class="fa-regular fa-clock"></i>
                    <span><?=date("jS M, Y",strtotime($row['post_date']))?></span>
                </div>
            </div>
        </a>
    </div>
</div>