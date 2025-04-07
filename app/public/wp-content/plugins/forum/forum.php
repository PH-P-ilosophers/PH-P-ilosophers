<?php
/**
 * Plugin Name: Q&A FORUM
 * Description: Asking the Imam OR other members Q&A's
 * Version: 1.0
 */

function create_forum_post_type()
{
    register_post_type(
        'forum_question',
        array(
            'labels' => array(
                'name' => 'Questions',
                'singular_name' => 'Question',
                'add_new' => 'Add New Question',
                'add_new_item' => 'Add New Question',
                'edit_item' => 'Edit Question',
                'view_item' => 'View Question',
                'all_items' => 'All Questions'
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'author', 'comments'),
            'menu_icon' => 'dashicons-format-chat',
            'show_in_rest' => true, // Enables Gutenberg editor
        )
    );
}
add_action('init', 'create_forum_post_type');

function forum_question_form_shortcode()
{
    if (!is_user_logged_in()) {
        return '<p>Please login to ask a question.</p>';
    }

    if (isset($_POST['submit_question']) && wp_verify_nonce($_POST['question_nonce'], 'forum_question_nonce')) {
        $question = array(
            'post_title' => sanitize_text_field($_POST['question_title']),
            'post_content' => wp_kses_post($_POST['question_content']),
            'post_status' => 'publish',
            'post_type' => 'forum_question',
            'post_author' => get_current_user_id()
        );

        $post_id = wp_insert_post($question);

        if ($post_id) {
            return '<p>Question submitted successfully! <a href="' . get_permalink($post_id) . '">View your question</a>.</p>';
        }
    }


    ob_start();
    ?>
    <form method="post">
        <?php wp_nonce_field('forum_question_nonce', 'question_nonce'); ?>
        <p>
            <label for="question_title">Question Title:</label><br>
            <input type="text" name="question_title" id="question_title" required>
        </p>
        <p>
            <label for="question_content">Question Details:</label><br>
            <textarea name="question_content" id="question_content" rows="5" required></textarea>
        </p>
        <p>
            <input type="submit" name="submit_question" value="Submit Question">
        </p>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('forum_form', 'forum_question_form_shortcode');

function forum_questions_list_shortcode($atts)
{
    $args = array(
        'post_type' => 'forum_question',
        'posts_per_page' => 10,
    );

    $questions = new WP_Query($args);

    ob_start();
    if ($questions->have_posts()) {
        echo '<div class="questions-list">';
        while ($questions->have_posts()) {
            $questions->the_post();
            ?>
            <div class="question">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p>Asked by <?php the_author(); ?> | <?php comments_number('0 answers', '1 answer', '% answers'); ?></p>
                <div class="excerpt"><?php the_excerpt(); ?></div>
            </div>
            <?php
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>No questions found.</p>';
    }

    return ob_get_clean();
}
add_shortcode('forum_list', 'forum_questions_list_shortcode');