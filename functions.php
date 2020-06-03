<?php 
$currentPage = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
define( 'CHILD_THEME_DIRECTORY', get_stylesheet_directory() );
define('FULL_PATH',$currentPage);


add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles');
function salient_child_enqueue_styles() {
	
		$nectar_theme_version = nectar_get_theme_version();
		
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array('font-awesome'), $nectar_theme_version);

    if ( is_rtl() ) 
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
}


function my_login_logo() { 
  $logo_url = get_stylesheet_directory_uri() . '/images/logo.png';
  ?>
  <style type="text/css">
    body.login div#login h1 a {
      background-image: url(<?php echo $logo_url; ?>);
      background-size: contain;
      width: 100%;
      height: 100px;
      margin-bottom: 10px;
    }
    .login #backtoblog, .login #nav {
      text-align: center;
    }

  </style> 
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function loginpage_custom_link() {
  return get_site_url();
}
add_filter('login_headerurl','loginpage_custom_link');

function bella_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'bella_login_logo_url_title' );



function child_theme_next_post_display() {

	 global $post;
	 global $nectar_options;

	 $post_header_style            = ( ! empty( $nectar_options['blog_header_type'] ) ) ? $nectar_options['blog_header_type'] : 'default';
	 $post_pagination_style        = ( ! empty( $nectar_options['blog_next_post_link_style'] ) ) ? $nectar_options['blog_next_post_link_style'] : 'fullwidth_next_only';
	 $post_pagination_style_output = ( $post_pagination_style == 'contained_next_prev' ) ? 'fullwidth_next_prev' : $post_pagination_style;
	 $full_width_content_class     = ( $post_pagination_style == 'contained_next_prev' ) ? '' : 'full-width-content';

	 ob_start();
	 $next_post = get_previous_post();
	if ( ! empty( $next_post ) && ! empty( $nectar_options['blog_next_post_link'] ) && $nectar_options['blog_next_post_link'] == '1' ||
	   $post_pagination_style == 'contained_next_prev' && ! empty( $nectar_options['blog_next_post_link'] ) && $nectar_options['blog_next_post_link'] == '1' ||
		   $post_pagination_style == 'fullwidth_next_prev' && ! empty( $nectar_options['blog_next_post_link'] ) && $nectar_options['blog_next_post_link'] == '1' ) { ?>

			<div data-post-header-style="<?php echo esc_attr( $post_header_style ); ?>" class="blog_next_prev_buttons wpb_row vc_row-fluid <?php echo esc_attr( $full_width_content_class ); ?> standard_section" data-style="<?php echo esc_attr( $post_pagination_style_output ); ?>" data-midnight="light">

				<?php

				if ( ! empty( $next_post ) ) {
					  $bg       = get_post_meta( $next_post->ID, '_nectar_header_bg', true );
					  $bg_color = get_post_meta( $next_post->ID, '_nectar_header_bg_color', true );
				} else {
					$bg       = '';
					$bg_color = '';
				}

				if ( $post_pagination_style == 'fullwidth_next_prev' || $post_pagination_style == 'contained_next_prev' ) {

					// next & prev
						$previous_post = get_next_post();
						$next_post     = get_previous_post();

						$hidden_class = ( empty( $previous_post ) ) ? 'hidden' : null;
						$only_class   = ( empty( $next_post ) ) ? ' only' : null;
						echo '<ul class="controls blog-controls"><li class="previous-post ' . $hidden_class . $only_class . '">';

					if ( ! empty( $previous_post ) ) {
						$previous_post_id = $previous_post->ID;
						$bg               = get_post_meta( $previous_post_id, '_nectar_header_bg', true );

						if ( ! empty( $bg ) ) {
							// page header
							//echo '<div class="post-bg-img" style="background-image: url(' . $bg . ');"></div>';
						} elseif ( has_post_thumbnail( $previous_post_id ) ) {
							// featured image
							$post_thumbnail_id  = get_post_thumbnail_id( $previous_post_id );
							$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
							//echo '<div class="post-bg-img" style="background-image: url(' . esc_url( $post_thumbnail_url ) . ');"></div>';
						}

							echo '<a href="' . esc_url( get_permalink( $previous_post_id ) ) . '"></a><h3><span class="toptxt"><i><b>&larr;</b>' . esc_html__( 'Previous Post', 'salient' ) . '</i></span><span class="text">' . wp_kses_post( $previous_post->post_title ) . '
					<svg class="next-arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 12"><line class="top" x1="23" y1="-0.5" x2="29.5" y2="6.5" stroke="#ffffff;"></line><line class="bottom" x1="23" y1="12.5" x2="29.5" y2="5.5" stroke="#ffffff;"></line></svg><span class="line"></span></span></h3>';
					}
						echo '</li>';

						$hidden_class = ( empty( $next_post ) ) ? 'hidden' : null;
						$only_class   = ( empty( $previous_post ) ) ? ' only' : null;

						echo '<li class="next-post ' . $hidden_class . $only_class . '">';

					if ( ! empty( $next_post ) ) {
						$next_post_id = $next_post->ID;
						$bg           = get_post_meta( $next_post_id, '_nectar_header_bg', true );

						if ( ! empty( $bg ) ) {
							// page header
							//echo '<div class="post-bg-img" style="background-image: url(' . $bg . ');"></div>';
						} elseif ( has_post_thumbnail( $next_post_id ) ) {
							// featured image
							$post_thumbnail_id  = get_post_thumbnail_id( $next_post_id );
							$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
							//echo '<div class="post-bg-img" style="background-image: url(' . esc_url( $post_thumbnail_url ) . ');"></div>';
						}
					}

							echo '<a href="' . esc_url( get_permalink( $next_post_id ) ) . '"></a><h3><span class="toptxt"><i>' . esc_html__( 'Next Post', 'salient' ) . '<b>&rarr;</b></i></span><span class="text">' . wp_kses_post( $next_post->post_title ) . '
					<svg class="next-arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 12"><line class="top" x1="23" y1="-0.5" x2="29.5" y2="6.5" stroke="#ffffff;"></line><line class="bottom" x1="23" y1="12.5" x2="29.5" y2="5.5" stroke="#ffffff;"></line></svg><span class="line"></span></span></h3>';

						echo '</li></ul>';

				} else {

					// next only
					if ( ! empty( $bg ) || ! empty( $bg_color ) ) {
						// page header
						if ( ! empty( $bg ) ) {
							echo '<img src="' . esc_url( $bg ) . '" alt="' . get_the_title( $next_post->ID ) . '" />';
						} else {
							echo '<span class="bg-color-only-indicator"></span>';
						}
					} elseif ( has_post_thumbnail( $next_post->ID ) ) {
						// featured image
						$post_thumbnail_id  = get_post_thumbnail_id( $next_post->ID );
						$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
						echo '<img src="' . esc_url( $post_thumbnail_url ) . '" alt="' . get_the_title( $next_post->ID ) . '" />';
					}
					?>

						<div class="col span_12 dark left">
						<div class="inner">
							<span><?php echo '<i>' . esc_html__( 'Next Post', 'salient' ) . '</i>'; ?></span>
							<?php previous_post_link( '%link', '<h3>%title</h3>' ); ?>
						</div>		
						</div>
						<span class="bg-overlay"></span>
						<span class="full-link"><?php previous_post_link( '%link' ); ?></span>

					<?php } ?>
				
					
			 
		 </div>

		<?php
	}

	$next_post_link_output = ob_get_contents();
	ob_end_clean();

	echo $next_post_link_output; // WPCS: XSS ok.

}


function child_theme_related_post_display() {

	global $post;
	global $nectar_options;

	$using_related_posts = ( ! empty( $nectar_options['blog_related_posts'] ) && ! empty( $nectar_options['blog_related_posts'] ) == '1' ) ? true : false;

	if ( $using_related_posts == false ) {
		return;
	}

	ob_start();

	$current_categories = get_the_category( $post->ID );
	if ( $current_categories ) {

		$category_ids = array();
		foreach ( $current_categories as $individual_category ) {
			$category_ids[] = $individual_category->term_id;
		}

		$relatedBlogPosts = array(
			'category__in'        => $category_ids,
			'post__not_in'        => array( $post->ID ),
			'showposts'           => 3,
			'ignore_sticky_posts' => 1,
		);

		$related_posts_query = new WP_Query( $relatedBlogPosts );
		$related_post_count  = $related_posts_query->post_count;

		if ( $related_post_count < 2 ) {
			return;
		}

		$span_num = ( $related_post_count == 2 ) ? 'span_6' : 'span_4';

		$related_title_text        = esc_html__( 'Related Posts', 'salient' );
		$related_post_title_option = ( ! empty( $nectar_options['blog_related_posts_title_text'] ) ) ? wp_kses_post( $nectar_options['blog_related_posts_title_text'] ) : 'Related Posts';

		switch ( $related_post_title_option ) {
			case 'related_posts':
				$related_title_text = esc_html__( 'Related Posts', 'salient' );
				break;

			case 'similar_posts':
				$related_title_text = esc_html__( 'Similar Posts', 'salient' );
				break;

			case 'you_may_also_like':
				$related_title_text = esc_html__( 'You May Also Like', 'salient' );
				break;
			case 'recommended_for_you':
				$related_title_text = esc_html__( 'Recommended For You', 'salient' );
				break;
		}

		$hidden_title_class = null;
		if ( $related_post_title_option == 'hidden' ) {
			$hidden_title_class = 'hidden';
		}

		$using_post_pag     = ( ! empty( $nectar_options['blog_next_post_link'] ) && $nectar_options['blog_next_post_link'] == '1' ) ? 'true' : 'false';
		$related_post_style = ( ! empty( $nectar_options['blog_related_posts_style'] ) ) ? esc_html( $nectar_options['blog_related_posts_style'] ) : 'material';

		echo '<div class="row vc_row-fluid full-width-section related-post-wrap" data-using-post-pagination="' . esc_attr( $using_post_pag ) . '" data-midnight="dark"> <div class="row-bg-wrap"><div class="row-bg"></div></div> <h3 class="related-title ' . $hidden_title_class . '">' . wp_kses_post( $related_title_text ) . '</h3><div class="row span_12 blog-recent related-posts columns-' . esc_attr( $related_post_count ) . '" data-style="' . esc_attr( $related_post_style ) . '" data-color-scheme="light">';
		if ( $related_posts_query->have_posts() ) :
			while ( $related_posts_query->have_posts() ) :
				$related_posts_query->the_post();
				?>
	
	<div class="col <?php echo esc_attr( $span_num ); ?>">
	<div <?php post_class( 'inner-wrap' ); ?>>

					<?php
					if ( has_post_thumbnail() ) {
						$related_image_size = ( $related_post_count == 2 ) ? 'wide_photography' : 'portfolio-thumb';
						echo '<a href="' . esc_url( get_permalink() ) . '" class="img-link"><span class="post-featured-img">' . get_the_post_thumbnail( $post->ID, $related_image_size, array( 'title' => '' ) ) . '</span></a>';
					}
					?>

					<?php
					echo '<span class="meta-category">';
					$categories = get_the_category();
					if ( ! empty( $categories ) ) {
						$output = null;
						foreach ( $categories as $category ) {
							$output .= '<a class="' . esc_attr( $category->slug ) . '" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
						}
						echo trim( $output );
					}
					echo '</span>';
					?>
		
					<a class="entire-meta-link" href="<?php the_permalink(); ?>"></a>

					<div class="article-content-wrap">
						<div class="post-header">
							<span class="meta"> 
								<?php
								if ( $related_post_style != 'material' ) {
									echo get_the_date();}
								?>
							 </span> 
							<h3 class="title"><?php the_title(); ?></h3>	
						</div><!--/post-header-->
		
						<?php
						if ( function_exists( 'get_avatar' ) && $related_post_style == 'material' ) {
							 echo '<div class="grav-wrap">' . get_avatar( get_the_author_meta( 'email' ), 70, null, get_the_author() ) . '<div class="text"> <a href="' . get_author_posts_url( $post->post_author ) . '">' . get_the_author() . '</a><span>' . get_the_date() . '</span></div></div>'; }

						?>
					</div>
	
					<?php if ( $related_post_style != 'material' ) { ?>
		
	<div class="post-meta">
		<span class="meta-author"> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"> <i class="icon-default-style icon-salient-m-user"></i> <?php the_author(); ?></a> </span> 
		
						<?php if ( comments_open() ) { ?>
			<span class="meta-comment-count">  <a href="<?php comments_link(); ?>">
				<i class="icon-default-style steadysets-icon-chat-3"></i> <?php comments_number( '0', '1', '%' ); ?></a>
			</span>
		<?php } ?>
		
	</div>
						<?php

}
?>
	 
</div>
</div>
				 <?php

			endwhile;
endif;

		echo '</div></div>';

		wp_reset_postdata();

	}// if has categories
		$related_posts_content = ob_get_contents();

		ob_end_clean();

		echo $related_posts_content; // WPCS: XSS ok.

}

/* Display user photo on admin (users) using the `User Profile Picture` plugin */
function custom_admin_js() {
	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}users ORDER BY ID ASC");
	if($results) {
		foreach($results as $row) {
			$user_id = $row->ID;
			$display_name = $row->display_name;
			$email = $row->user_email;
			$metaValue = get_user_meta($user_id,'wp_metronet_image_id',true); /* return post id */
			$customPic = ($metaValue) ? wp_get_attachment_image_src($metaValue,'thumbnail') : '';
			$default_gravatar = get_avatar( $email, 32, null, null );
			$avatar_url = ($customPic) ? $customPic[0] : get_avatar_url($email);
			$row->avatar = $avatar_url;
			$row->custom_avatar = ($customPic) ? 1:'';
		}
	}
	$users = ($results) ? json_encode($results) : '';
	if (strpos(FULL_PATH, 'users.php') !== false) { ?>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		var userList = '<?php echo $users; ?>';
		if(userList) {
			var users = $.parseJSON(userList);
			$(users).each(function(k,v){
				var photoURL = v.avatar;
			});
			$("#the-list tr").each(function(){
				var tr = $(this);
				var id = $(this).attr("id");
				var userId = id.replace("user-","");
				$(users).each(function(k,v){
					var uId = v.ID;
					var photoURL = v.avatar;
					var avatar_class = (v.custom_avatar) ? 'custom':'default';
					if(userId==uId) {
						if(photoURL) {
							tr.find("td.username .avatar").attr("src",photoURL);
							tr.find("td.username .avatar").attr("srcset",photoURL);
							tr.find("td.username .avatar").addClass(avatar_class);
						}
					}
				});
			});
		}
	});
	</script>
	<?php
	}   
}
add_action('admin_footer', 'custom_admin_js');


//custom avatar
function custom_author_avatar( $authorId, $size) {
	$author_name = get_the_author_meta('display_name',$authorId);
	$metaValue = get_user_meta($authorId,'wp_metronet_image_id',true); /* return post id */
	$img = ($metaValue) ? wp_get_attachment_image_src($metaValue,'thumbnail') : '';
	$photo = ($img) ? '<img alt="'.$author_name.'" src="'.$img[0].'" class="avatar avatar-'.$size.' photo" height="'.$size.'" width="'.$size.'" />' : '';
    return $photo;
}


/*-------------------------------------
	Adds Options page for ACF.
---------------------------------------*/
if( function_exists('acf_add_options_page') ) {acf_add_options_page();}



