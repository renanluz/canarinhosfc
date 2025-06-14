<!-- Social Media -->
<section class="social-section">
    <div class="social-links">
        <a href="<?php echo get_theme_mod('facebook_url', '#'); ?>" class="social-link" aria-label="Facebook">📘</a>
        <a href="<?php echo get_theme_mod('instagram_url', '#'); ?>" class="social-link" aria-label="Instagram">📷</a>
        <a href="<?php echo get_theme_mod('twitter_url', '#'); ?>" class="social-link" aria-label="Twitter">🐦</a>
        <a href="<?php echo get_theme_mod('youtube_url', '#'); ?>" class="social-link" aria-label="YouTube">📺</a>
    </div>
    <div class="footer-info">
        <p>&copy; <?php echo date('Y'); ?> <?php echo get_theme_mod('team_name', 'Canarinhos FC'); ?>. All rights reserved.</p>
    </div>
</section>

<?php wp_footer(); ?>
</body>
</html>