<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wishlist_Everywhere_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wishlist_everywhere';
	}

	public function get_title() {
		return __( 'Wishlist Everywhere', 'wishlist-everywhere' );
	}

	public function get_icon() {
		return 'eicon-heart';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'wishlist', 'favorites', 'save' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'wishlist-everywhere' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'wishlist_label',
			[
				'label' => __( 'Label Text', 'wishlist-everywhere' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'My Wishlist', 'wishlist-everywhere' ),
			]
		);

        $this->add_control(
        'wishlist_url',
        [
            'label' => __( 'Wishlist Link', 'wishlist-everywhere' ),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => home_url('/wishlist'),
            'default' => [
                'url' => home_url('/wishlist'),
                'is_external' => false,
                'nofollow' => false,
            ],
            'show_external' => true,
        ]
    );

		$this->end_controls_section();
	}

    protected function render() {
    $settings = $this->get_settings_for_display();

    $this->add_render_attribute( 'link', 'href', esc_url( $settings['wishlist_url']['url'] ) );

    if ( $settings['wishlist_url']['is_external'] ) {
        $this->add_render_attribute( 'link', 'target', '_blank' );
    }
    if ( $settings['wishlist_url']['nofollow'] ) {
        $this->add_render_attribute( 'link', 'rel', 'nofollow' );
    }

    echo '<a ' . $this->get_render_attribute_string( 'link' ) . ' class="wishlist-button">';
    echo esc_html( $settings['wishlist_label'] );
    echo '</a>';
}
}
