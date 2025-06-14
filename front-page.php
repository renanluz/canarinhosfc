<?php get_header(); ?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <h3>WEEKLY DIGEST</h3>
            <h1><?php echo get_theme_mod('team_slogan', 'Detailed football games news & reviews'); ?></h1>
            <p>Follow the latest news from <?php echo get_theme_mod('team_name', 'Canarinhos FC'); ?>, match results, tactical analysis and much more exclusive content about the world of football.</p>
            <button class="cta-button">READ MORE</button>
        </div>
        <div class="hero-sidebar">
    <div class="match-result">
        <div class="match-date">Last Tuesday</div>
        <div class="match-score-container">
            <div class="team home-team">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Canarinho-logo.png" 
                     alt="Canarinhos FC" class="team-logo">
                <span class="team-name">Canarinhos FC</span>
            </div>
            
            <div class="score-section">
                <div class="score">2 - 7</div>
                <div class="league-name">Premier League</div>
                <div class="venue">Away</div>
            </div>
            
            <div class="team away-team">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/cactus-logo.png" 
                     alt="Cactus FC" class="team-logo">
                <span class="team-name">Cactus FC</span>
            </div>
        </div>
        
        <div class="match-status">
            <span class="result-badge loss">Loss</span>
        </div>
    </div>
</div>
    </div>
    <div class="scroll-indicator">
        ↓ SCROLL DOWN
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="stats-container">
        <div class="stat-item">
            <h3><?php echo get_theme_mod('stat_fans', '150+'); ?></h3>
            <p>Fans</p>
        </div>
        <div class="stat-item">
            <h3><?php echo get_theme_mod('stat_matches', '85'); ?></h3>
            <p>Matches</p>
        </div>
        <div class="stat-item">
            <h3><?php echo get_theme_mod('stat_years', '25+'); ?></h3>
            <p>Years</p>
        </div>
        <div class="stat-item">
            <h3><?php echo get_theme_mod('stat_trophies', '12'); ?></h3>
            <p>Trophies</p>
        </div>
    </div>
</section>

<!-- League Table -->
<section class="league-section" id="league">
    <div class="league-container">
        <h2 class="league-title">Team Standing</h2>
        <div class="league-table-wrapper">
            <div class="league-table">
                <div class="table-header">
                    <div class="table-header-title">
                        <span>Pos</span>
                        <span>Team</span>
                    </div>
                    <div class="table-stats">
                        <span>E</span>
                        <span>W</span>
                        <span>L</span>
                        <span>P</span>
                    </div>
                </div>
                
                <?php
                // Teams data for the clean table
                $teams = array(
                    array('pos' => 1, 'name' => get_theme_mod('team_name', 'Canarinhos FC'), 'logo' => 'C', 'e' => 20, 'w' => 15, 'l' => 3, 'p' => 48),
                    array('pos' => 2, 'name' => 'Eagles United', 'logo' => 'E', 'e' => 20, 'w' => 14, 'l' => 4, 'p' => 46),
                    array('pos' => 3, 'name' => 'Lions FC', 'logo' => 'L', 'e' => 20, 'w' => 12, 'l' => 5, 'p' => 41),
                    array('pos' => 4, 'name' => 'Tigers SC', 'logo' => 'T', 'e' => 20, 'w' => 11, 'l' => 6, 'p' => 38),
                    array('pos' => 5, 'name' => 'Falcons FC', 'logo' => 'F', 'e' => 20, 'w' => 10, 'l' => 7, 'p' => 35),
                    array('pos' => 6, 'name' => 'Panthers United', 'logo' => 'P', 'e' => 18, 'w' => 8, 'l' => 8, 'p' => 28),
                    array('pos' => 7, 'name' => 'Wolves SC', 'logo' => 'W', 'e' => 18, 'w' => 7, 'l' => 9, 'p' => 25),
                );
                
                foreach ($teams as $team) {
                    $highlight_class = ($team['pos'] == 1) ? 'first-place' : '';
                    echo '<div class="table-row ' . $highlight_class . '">';
                    echo '<div class="team-info-section">';
                    echo '<div class="position">' . $team['pos'] . '</div>';
                    echo '<div class="team-data">';
                    echo '<div class="team-logo ' . strtolower($team['logo']) . '">' . $team['logo'] . '</div>';
                    echo '<span class="team-name">' . $team['name'] . '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="team-stats">';
                    echo '<span>' . $team['e'] . '</span>';
                    echo '<span>' . $team['w'] . '</span>';
                    echo '<span>' . $team['l'] . '</span>';
                    echo '<span class="points">' . $team['p'] . '</span>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Players Section -->
<section class="players-section" id="players">
    <div class="players-container">
        <h2 class="players-title">PLAYERS</h2>
        <p class="players-subtitle">Our main team</p>
        <div class="players-grid">
            <?php
            // Query for players (custom post type)
            $players = new WP_Query(array(
                'post_type' => 'player',
                'posts_per_page' => 6,
                'meta_key' => 'player_position',
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            if ($players->have_posts()) {
                while ($players->have_posts()) {
                    $players->the_post();
                    $position = get_post_meta(get_the_ID(), 'player_position', true);
                    $initials = substr(get_the_title(), 0, 1) . substr(strstr(get_the_title(), ' '), 1, 1);
                    ?>
                    <div class="player-card">
                        <div class="player-avatar"><?php echo $initials; ?></div>
                        <div class="player-name"><?php the_title(); ?></div>
                        <div class="player-position"><?php echo $position; ?></div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            } else {
                // Default players with the names you specified
                $default_players = array(
                    array('name' => 'Jullius Bevan', 'position' => 'Goalkeeper', 'initials' => 'JB'),
                    array('name' => 'Xavier Bevan', 'position' => 'Defender', 'initials' => 'XB'),
                    array('name' => 'Denilson', 'position' => 'Forward', 'initials' => 'DE'),
                    array('name' => 'Marcos', 'position' => 'Goalkeeper', 'initials' => 'MA'),
                    array('name' => 'Dijon Bevan', 'position' => 'Defender', 'initials' => 'DB'),
                    array('name' => 'Renan Luz', 'position' => 'Midfielder', 'initials' => 'RL'),
                );
                
                foreach ($default_players as $player) {
                    echo '<div class="player-card">';
                    echo '<div class="player-avatar">' . $player['initials'] . '</div>';
                    echo '<div class="player-name">' . $player['name'] . '</div>';
                    echo '<div class="player-position">' . $player['position'] . '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>