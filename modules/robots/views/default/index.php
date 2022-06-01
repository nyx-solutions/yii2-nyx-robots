<?php

    use nyx\helpers\UrlHelper;
    use nyx\modules\robots\Module;
    use yii\web\View;

    /**
     * @var View   $this
     * @var bool   $disallowAllRobots
     * @var bool   $allowAllRobots
     * @var bool   $useSitemap
     * @var string $sitemapFile
     * @var array  $allowRules
     * @var array  $disallowRules
     * @var Module $robotsModule
     */

?>
<?php if ($allowAllRobots) : ?>
User-Agent: *
Allow: /
<?php elseif ($disallowAllRobots) : ?>
User-Agent: *
Disallow: /
<?php else : ?>

<?php foreach ($allowRules as $robot => $rules) : ?>
User-Agent: <?= $robotsModule->getRobotName($robot); ?>

<?php foreach ($rules as $rule) : ?>
Allow: <?= $rule; ?>

<?php endforeach; ?>
<?php endforeach; ?>

<?php foreach ($disallowRules as $robot => $rules) : ?>
User-Agent: <?= $robotsModule->getRobotName($robot); ?>

<?php foreach ($rules as $rule) : ?>
Disallow: <?= $rule; ?>

<?php endforeach; ?>
<?php endforeach; ?>

<?php endif; ?>

<?php if ((bool)$useSitemap) : ?>Sitemap: <?= UrlHelper::to($sitemapFile, true); ?><?php endif; ?>
