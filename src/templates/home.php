<div class="container p-4 d-flex justify-content-center align-items-center flex-column">
    <div class="banner">
        <img src="images/banner.png" alt="banner">
    </div>
    <p class="my-4">Upload your highest quality and most memorable content here, this is your presentation to all
        your followers, do not forget to upload new content weekly.</p>

    <div class="p-4 d-flex justify-content-between align-items-center flex-column upload">
        <img src="images/upload.png" alt="upload">
        <form action="/upload" method="post" id="upload-form" enctype="multipart/form-data">
            <input type="file" name="media" hidden id="input-file">
            <button type="button" class="primary" id="browse-button">
                Browse files
            </button>
        </form>
    </div>

    <div class="d-flex justify-content-center align-items-center gap-2 my-4">
        <button class="secondary">
            <img src="images/photo.png" alt="photos" class="mx-1">
            <?= count($photos) ?> photos
        </button>

        <button class="secondary">
            <img src="images/video.png" alt="videos" class="mx-1">
            <?= count($videos) ?> videos
        </button>
    </div>

    <div class="media-container">
        <?php foreach ($media as $entity): ?>
            <div class="media my-4 d-flex justify-content-start align-items-center p-2">
                <?php if ($entity->media_type === \Vanilla\enums\MediaEnum::video): ?>
                    <a href="/storage/videos/<?= $entity->filepath ?>" class="video-link">
                        <img src="/storage/thumbnails/<?= $entity->thumbnail ?>" alt="thumbnail" style="object-fit: cover; min-height:100% !important; min-width:100% !important;">
                    </a>
                <?php else: ?>
                    <a href="/storage/photos/<?= $entity->filepath ?>" class="photo">
                        <img src="/storage/photos/<?= $entity->filepath ?>" alt="media" style="object-fit: cover; min-height:100% !important; min-width:100% !important;">
                    </a>
                <?php endif; ?>
                <div class="d-flex justify-content-between align-items-start flex-column media-right">
                    <p class="headline"><?= $entity->name ?></p>
                    <ul class="ms-3">
                        <li><?= $entity->media_type->label() ?></li>
                        <?php if ($entity->media_type === \Vanilla\enums\MediaEnum::video): ?>
                            <li>Video duration: <?= $entity->duration ?> seconds</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    const input_file = document.querySelector('#input-file');
    // trigger file input from styled button
    document.querySelector('#browse-button')
        .addEventListener('click', () => input_file.click());

    // trigger submit on file select
    input_file.onchange = function () {
        document.querySelector("#upload-form").submit();
    };
</script>