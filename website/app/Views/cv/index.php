<?php 
include __DIR__ . '/../layouts/head.php';
include __DIR__ . '/../layouts/header.php';
?>

<section class="hero" id="cv-hero">
    <div class="container container-lg text-center">
        <h1 class="mb-md"><?php echo t('cv.title'); ?></h1>
        <p class="text-lg text-secondary"><?php echo t('cv.subtitle'); ?></p>
        <div class="mt-lg">
            <a href="#cv-download" class="btn btn-primary"><?php echo t('cv.download'); ?></a>
            <a href="/cv.pdf" class="btn btn-secondary" download><?php echo t('cv.pdf'); ?></a>
        </div>
    </div>
</section>

<section id="cv-content" class="container container-lg">
    <div class="grid grid-cols-2">
        <div>
            <section id="experience" class="mb-2xl">
                <h2 class="mb-lg"><?php echo t('cv.experience'); ?></h2>
                <?php if (!empty($cv['experience'])): ?>
                    <?php foreach ($cv['experience'] as $job): ?>
                        <article class="mb-xl">
                            <h3><?php echo htmlspecialchars($job['title'] ?? '', ENT_QUOTES); ?></h3>
                            <p class="text-secondary"><?php echo htmlspecialchars($job['company'] ?? '', ENT_QUOTES); ?></p>
                            <p class="text-sm text-secondary">
                                <?php echo htmlspecialchars($job['period'] ?? '', ENT_QUOTES); ?>
                            </p>
                            <?php if (!empty($job['description'])): ?>
                                <p class="mt-md"><?php echo htmlspecialchars($job['description'], ENT_QUOTES); ?></p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <section id="education">
                <h2 class="mb-lg"><?php echo t('cv.education'); ?></h2>
                <?php if (!empty($cv['education'])): ?>
                    <?php foreach ($cv['education'] as $edu): ?>
                        <article class="mb-xl">
                            <h3><?php echo htmlspecialchars($edu['degree'] ?? '', ENT_QUOTES); ?></h3>
                            <p class="text-secondary"><?php echo htmlspecialchars($edu['school'] ?? '', ENT_QUOTES); ?></p>
                            <p class="text-sm text-secondary"><?php echo htmlspecialchars($edu['year'] ?? '', ENT_QUOTES); ?></p>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </div>

        <div>
            <section id="skills" class="mb-2xl">
                <h2 class="mb-lg"><?php echo t('cv.skills'); ?></h2>
                <?php if (!empty($cv['skills'])): ?>
                    <?php foreach ($cv['skills'] as $skillGroup): ?>
                        <div class="mb-xl">
                            <h3 class="text-base mb-md"><?php echo htmlspecialchars($skillGroup['category'] ?? '', ENT_QUOTES); ?></h3>
                            <div class="flex gap-sm flex-wrap">
                                <?php foreach ($skillGroup['items'] as $skill): ?>
                                    <span class="badge"><?php echo htmlspecialchars($skill, ENT_QUOTES); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <section id="languages">
                <h2 class="mb-lg"><?php echo t('cv.languages'); ?></h2>
                <?php if (!empty($cv['languages'])): ?>
                    <ul class="space-y-sm">
                        <?php foreach ($cv['languages'] as $lang): ?>
                            <li>
                                <strong><?php echo htmlspecialchars($lang['name'], ENT_QUOTES); ?></strong>
                                <span class="text-secondary"><?php echo htmlspecialchars($lang['level'], ENT_QUOTES); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </section>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
