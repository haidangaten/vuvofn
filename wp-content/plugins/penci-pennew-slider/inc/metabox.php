<?php
if ( ! class_exists( 'Penci_PenNew_Slider_MetaBox' ) ) :

	class Penci_PenNew_Slider_MetaBox {

		public function __construct() {
			
			add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_boxes' ) );

			// Add columns to manage columns pencislider
			add_filter( 'manage_edit-penci_slider_columns', array( $this, 'add_columns_penci_slider' ) );

			// Change default column title
			add_filter( 'manage_penci_slider_posts_columns', array( $this, 'penci_slider_modify_table_title' ) );

			// Custom columns pencislider
			add_action( 'manage_penci_slider_posts_custom_column', array( $this, 'penci_slider_custom_columns' ), 10, 2 );
		}

		function register_meta_boxes( $meta_boxes ) {
			$meta_boxes[] = array(
				'title'      => 'Slider Settings',
				'post_types' => 'penci_slider',
				'fields'     => array(
					array(
						'id'         => 'penci_sliders',
						'type'       => 'group',
						'clone'      => true,
						'sort_clone' => true,
						'fields'     => array(
							array(
								'type' => 'custom_html',
								'std'  => '<div class="penci-param-heading-wrapper penci-slider-heading">' . esc_html( 'General','penci-framework' ) . '</div>',
							),
							array(
				                'id'    => 'background_type',
				                'name'  => esc_html__( 'Background Type', 'penci-framework' ),
				                'type'  => 'select',
				                'options' => array(
				                    'image'       => 'Image',
				                    'yt_vm_video' => 'YouTube',
				                    'video'       => 'Local Video'
				                )
				            ),
							array(
								'name'             => esc_html__( 'Slide Image', 'penci-framework' ),
								'desc'             => esc_html__( 'The image should be between 1600px - 2000px in width and have a minimum height of 650px for best results. Click the "Add media" button to begin add your image', 'penci-framework' ),
								'id'               => '_slider_image',
								'type'             => 'image_advanced',
								'max_file_uploads' => 1,
								'std'              => ''
							),
							array(
								'name' => esc_html__( 'Youtube URLs', 'penci-framework' ),
								'desc' => esc_html__( 'Supported YouTube URLs', 'penci-framework' ),
								'id'   => 'yt_vm_video',
								'type' => 'text',
								'std'  => '',
								'hidden' => array( 'background_type', '!=', 'yt_vm_video' )
							),
							array(
								'name' => esc_html__( 'Local Video URLs', 'penci-framework' ),
								'id'   => 'local_video',
								'type' => 'video',
								'max_file_uploads' => 1,
								 'max_status'       => true,
								  'force_delete'     => false,
								'hidden' => array( 'background_type', '!=', 'video' )
							),
							array(
								'name' => esc_html__( 'Slide Title', 'penci-framework' ),
								'id'   => '_slider_title',
								'type' => 'textarea',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Slide Caption', 'penci-framework' ),
								'id'   => '_slider_caption',
								'type' => 'textarea',
								'std'  => ''
							),
							array( 'type' => 'divider' ),
							array(
								'name' => esc_html__( 'Button 1 Text', 'penci-framework' ),
								'desc' => esc_html__( 'If you would like a button to appear below your slide caption, please fill the text for it here.', 'penci-framework' ),
								'id'   => '_slider_button',
								'type' => 'text',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 1 Link', 'penci-framework' ),
								'id'   => '_slider_button_url',
								'type' => 'text',
								'std'  => ''
							),
							array(
								'id'      => 'button1_type',
								'name'    => esc_html__( 'Button 1 Type', 'penci-framework' ),
								'type'    => 'select',
								'options' => array(
									'fill'   => 'Fill button',
									'simple' => 'Simple link',
									'trans'  => 'Transparent button'
								),
								'std' => 'fill'
							),
							array(
								'name'   => esc_html__( 'Button 1 padding left/right', 'penci-framework' ),
								'desc'   => esc_html__( 'Numeric value only, unit is pixel', 'penci-framework' ),
								'id'     => '_slider_btn_plr',
								'type'   => 'number',
								'std'    => '',
								'hidden' => array( 'button1_type', '=', 'simple' )
							),
							array(
								'name'   => esc_html__( 'Button 1 padding top/bottom', 'penci-framework' ),
								'desc'   => esc_html__( 'Numeric value only, unit is pixel', 'penci-framework' ),
								'id'     => '_slider_btn_ptb',
								'type'   => 'number',
								'std'    => '',
								'hidden' => array( 'button1_type', '=', 'simple' )
							),
							array(
								'name'   => esc_html__( 'Button 1 border radius', 'penci-framework' ),
								'desc'   => esc_html__( 'Numeric value only, unit is pixel', 'penci-framework' ),
								'id'     => '_slider_btn1_radius',
								'type'   => 'number',
								'std'    => '',
								'hidden' => array( 'button1_type', '=', 'simple' )
							),
							array(
								'name'   => esc_html__( 'Button 1 border width', 'penci-framework' ),
								'desc'   => esc_html__( 'Numeric value only, unit is pixel', 'penci-framework' ),
								'id'     => '_slider_btn1_width',
								'type'   => 'number',
								'std'    => '',
								'hidden' => array( 'button1_type', '=', 'simple' )
							),
							array(
								'name' => esc_html__( 'Button 2 Text', 'penci-framework' ),
								'desc' => esc_html__( 'If you would like a button to appear below your slide caption, please fill the text for it here.', 'penci-framework' ),
								'id'   => '_slider_button2',
								'type' => 'text',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 2 Link', 'penci-framework' ),
								'id'   => '_slider_button2_url',
								'type' => 'text',
								'std'  => ''
							),
							array(
								'id'      => 'button2_type',
								'name'    => esc_html__( 'Button 2 Type', 'penci-framework' ),
								'type'    => 'select',
								'options' => array(
									'fill'   => 'Fill button',
									'simple' => 'Simple link',
									'trans'  => 'Transparent button'
								),
								'std' => 'fill'
							),
							array(
								'name'   => esc_html__( 'Button 2 margin left', 'penci-framework' ),
								'desc'   => esc_html__( 'Numeric value only, unit is pixel', 'penci-framework' ),
								'id'     => '_slider_mgn_left',
								'type'   => 'number',
								'std'    => ''
							),
							array(
								'name'   => esc_html__( 'Button 2 padding left/right', 'penci-framework' ),
								'desc'   => esc_html__( 'Numeric value only, unit is pixel', 'penci-framework' ),
								'id'     => '_slider_btn2_plr',
								'type'   => 'number',
								'std'    => '',
								'hidden' => array( 'button2_type', '=', 'simple' )
							),
							array(
								'name'   => esc_html__( 'Button 2 padding top/bottom', 'penci-framework' ),
								'desc'   => esc_html__( 'Numeric value only, unit is pixel', 'penci-framework' ),
								'id'     => '_slider_btn2_ptb',
								'type'   => 'number',
								'std'    => '',
								'hidden' => array( 'button2_type', '=', 'simple' )
							),
							array(
								'name'   => esc_html__( 'Button 2 border radius', 'penci-framework' ),
								'desc'   => esc_html__( 'Numeric value only, unit is pixel', 'penci-framework' ),
								'id'     => '_slider_btn2_radius',
								'type'   => 'number',
								'std'    => '',
								'hidden' => array( 'button2_type', '=', 'simple' )
							),
							array(
								'name'   => esc_html__( 'Button 2 border width', 'penci-framework' ),
								'desc'   => esc_html__( 'Numeric value only, unit is pixel', 'penci-framework' ),
								'id'     => '_slider_btn2_width',
								'type'   => 'number',
								'std'    => '',
								'hidden' => array( 'button1_type', '=', 'simple' )
							),
							array(
								'type' => 'custom_html',
								'std'  => '<div class="penci-param-heading-wrapper penci-slider-heading">' . esc_html( 'Color Settings','penci-framework' ) . '</div>',
							),
							array(
								'id'   => 'title-cap-bg',
								'name' => __( 'Turn On Background Slide Title and Caption', 'penci-framework' ),
								'type' => 'checkbox',
							),
							array(
								'name' => esc_html__( 'Slide Title Color', 'penci-framework' ),
								'id'   => '_slider_title_color',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Slide Title Background Color', 'penci-framework' ),
								'id'   => '_slider_title_bgcolor',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Slide Caption Color', 'penci-framework' ),
								'id'   => '_slider_caption_color',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Slide Caption Background Color', 'penci-framework' ),
								'id'   => '_slider_caption_bgcolor',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 1 Text Color', 'penci-framework' ),
								'id'   => '_slider_button_text_color',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 1 Background Color', 'penci-framework' ),
								'id'   => '_slider_button_bg',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 1 Border Color', 'penci-framework' ),
								'id'   => '_slider_button_bcolor',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 1 Hover Text Color', 'penci-framework' ),
								'id'   => '_slider_btn1_hcolor',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 1 Hover Background Color', 'penci-framework' ),
								'id'   => '_slider_btn_hbg',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 1 Hover Border Color', 'penci-framework' ),
								'id'   => '_slider_btn_hbcolor',
								'type' => 'color',
								'std'  => ''
							),
							array( 'type' => 'divider' ),
							array(
								'name' => esc_html__( 'Button 2 Text Color', 'penci-framework' ),
								'id'   => '_slider_button2_color',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 2 Background Color', 'penci-framework' ),
								'id'   => '_slider_button2_bg',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 2 Border Color', 'penci-framework' ),
								'id'   => '_slider_button2_bcolor',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 2 Hover Text Color', 'penci-framework' ),
								'id'   => '_slider_btn2_hcolor',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 2 Hover Background Color', 'penci-framework' ),
								'id'   => '_slider_btn2_hbg',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'name' => esc_html__( 'Button 2 Hover Border Color', 'penci-framework' ),
								'id'   => '_slider_btn2_hbcolor',
								'type' => 'color',
								'std'  => ''
							),
							array(
								'type' => 'custom_html',
								'std'  => '<div class="penci-param-heading-wrapper penci-slider-heading">' . esc_html( 'Typography Settings','penci-framework' ) . '</div>',
							),
							// Typo title
							array(
								'id'   => '_slider_title_offuppear',
								'name' => __( 'Turn Off Uppercase Slide Title', 'penci-framework' ),
								'type' => 'checkbox',
							),
							array(
								'name' => esc_html__( 'Font Size for Slide Title', 'penci-framework' ),
								'desc' => esc_html__( 'Custom Size Of Title Slider ( Numeric value only, unit is pixel )', 'penci-framework' ),
								'id'   => '_slider_title_fsize',
								'type' => 'number',
								'std'  => ''
							),array(
								'name' => esc_html__( 'Letter Spacing for Slide Title', 'penci-framework' ),
								'desc' => esc_html__( 'Custom Size Of Title Slider ( Numeric value only, unit is pixel )', 'penci-framework' ),
								'id'   => '_slider_title_spacing',
								'type' => 'number',
								'std'  => ''
							),
							array(
								'name'    => esc_html__( 'Font Family For Slider Title', 'penci-framework' ),
								'id'      => '_slider_title_family',
								'type'    => 'select',
								'options' =>  $this->get_fonts(),
								'desc'   => 'Default font is "Roboto"',
							),
							array(
								'name'    => esc_html__( 'Font Weight For Slider Title', 'penci-framework' ),
								'id'      => '_slider_title_fweight',
								'type'    => 'select',
								'options' =>  array(
									'normal'  => 'Normal',
									'bold'    => 'Bold',
									'bolder'  => 'Bolder',
									'lighter' => 'Lighter',
									'100'     => '100',
									'200'     => '200',
									'300'     => '300',
									'400'     => '400',
									'500'     => '500',
									'600'     => '600',
									'700'     => '700',
									'800'     => '800',
									'900'     => '900'
								),
								'std'     => 'normal'
							),
							array(
								'name'    => esc_html__( 'Font Style For Slider Title', 'penci-framework' ),
								'id'      => '_slider_title_fstyle',
								'type'    => 'select',
								'options' => array(
									'normal'  => 'Normal',
									'italic'  => 'Italic',
									'oblique' => 'Oblique'
								),
								'std'     => 'normal'
							),
							array( 'type' => 'divider' ),
							// Typo caption
							array(
								'name' => esc_html__( 'Font size for Slide Caption', 'penci-framework' ),
								'desc' => esc_html__( 'Custom Size Of Caption Slider ( Numeric value only, unit is pixel )', 'penci-framework' ),
								'id'   => '_slider_cap_fsize',
								'type' => 'number',
								'std'  => ''
							),
							array(
								'name'    => esc_html__( 'Font family For Slider Caption', 'penci-framework' ),
								'id'      => '_slider_cap_family',
								'type'    => 'select',
								'options' =>  $this->get_fonts(),
								'desc'   => 'Default font is "Roboto"',
							),
							array(
								'name'    => esc_html__( 'Font Weight For Slider Caption', 'penci-framework' ),
								'id'      => '_slider_cap_fweight',
								'type'    => 'select',
								'options' =>  array(
									'normal'  => 'Normal',
									'bold'    => 'Bold',
									'bolder'  => 'Bolder',
									'lighter' => 'Lighter',
									'100'     => '100',
									'200'     => '200',
									'300'     => '300',
									'400'     => '400',
									'500'     => '500',
									'600'     => '600',
									'700'     => '700',
									'800'     => '800',
									'900'     => '900'
								),
								'std'     => 'normal'
							),
							array(
								'name'    => esc_html__( 'Font Style For Slider Caption', 'penci-framework' ),
								'id'      => '_slider_cap_fstyle',
								'type'    => 'select',
								'options' => array(
									'normal'  => 'Normal',
									'italic'  => 'Italic',
									'oblique' => 'Oblique'
								),
								'std'     => 'normal'
							),
							array( 'type' => 'divider' ),
							// Typo button
							array(
								'name' => esc_html__( 'Font size for Slide Button 1', 'penci-framework' ),
								'desc' => esc_html__( 'Custom Size Of Caption Button ( Numeric value only, unit is pixel )', 'penci-framework' ),
								'id'   => '_slider_button_fsize',
								'type' => 'number',
								'std'  => ''
							),
							array(
								'name'    => esc_html__( 'Font family For Slider Button 1', 'penci-framework' ),
								'id'      => '_slider_button_family',
								'type'    => 'select',
								'options' =>  $this->get_fonts(),
								'desc'   => 'Default font is "Roboto"',
							),
							array(
								'name'    => esc_html__( 'Font Weight For Slider Button 1', 'penci-framework' ),
								'id'      => '_slider_button_fweight',
								'type'    => 'select',
								'options' =>  array(
									'normal'  => 'Normal',
									'bold'    => 'Bold',
									'bolder'  => 'Bolder',
									'lighter' => 'Lighter',
									'100'     => '100',
									'200'     => '200',
									'300'     => '300',
									'400'     => '400',
									'500'     => '500',
									'600'     => '600',
									'700'     => '700',
									'800'     => '800',
									'900'     => '900'
								),
								'std'     => 'normal'
							),
							array(
								'name'    => esc_html__( 'Font Style For Slider Button 1', 'penci-framework' ),
								'id'      => '_slider_button1_fstyle',
								'type'    => 'select',
								'options' => array(
									'normal'  => 'Normal',
									'italic'  => 'Italic',
									'oblique' => 'Oblique'
								),
								'std'     => 'normal'
							),
							array(
								'name' => esc_html__( 'Font size for Slide Button 2', 'penci-framework' ),
								'desc' => esc_html__( 'Custom Size Of Caption Button ( Numeric value only, unit is pixel )', 'penci-framework' ),
								'id'   => '_slider_button2_fsize',
								'type' => 'number',
								'std'  => ''
							),
							array(
								'name'    => esc_html__( 'Font family For Slider Button 2', 'penci-framework' ),
								'id'      => '_slider_button2_family',
								'type'    => 'select',
								'options' =>  $this->get_fonts(),
								'desc'   => 'Default font is "Roboto"',
							),
							array(
								'name'    => esc_html__( 'Font Weight For Slider Button 2', 'penci-framework' ),
								'id'      => '_slider_button2_fweight',
								'type'    => 'select',
								'options' =>  array(
									'normal'  => 'Normal',
									'bold'    => 'Bold',
									'bolder'  => 'Bolder',
									'lighter' => 'Lighter',
									'100'     => '100',
									'200'     => '200',
									'300'     => '300',
									'400'     => '400',
									'500'     => '500',
									'600'     => '600',
									'700'     => '700',
									'800'     => '800',
									'900'     => '900'
								),
								'std'     => 'normal'
							),
							array(
								'name'    => esc_html__( 'Font Style For Slider Button 2', 'penci-framework' ),
								'id'      => '_slider_button2_fstyle',
								'type'    => 'select',
								'options' => array(
									'normal'  => 'Normal',
									'italic'  => 'Italic',
									'oblique' => 'Oblique'
								),
								'std'     => 'normal'
							),
							array( 'type' => 'divider' ),
							array(
								'name'   => esc_html__( 'Custom width content', 'penci-framework' ),
								'desc'   => esc_html__( 'Numeric value only, unit is pixel', 'penci-framework' ),
								'id'     => '_slider_content_width',
								'type'   => 'number',
								'std'    => '',
							),
							array(
								'name'    => esc_html__( 'Text Alignment', 'penci-framework' ),
								'desc'    => esc_html__( 'Select the alignment for your caption and button.', 'penci-framework' ),
								'id'      => '_slide_alignment',
								'type'    => 'select',
								'options' => array(
									'left'     => 'Left',
									'center'   => 'Center',
									'right'    => 'Right',
									'left50l'  => 'Left 50% & Align Left',
									'left50c'  => 'Left 50% & Align Center',
									'left50r'  => 'Left 50% & Align Right',
									'right50l' => 'Right 50% & Align Left',
									'right50c' => 'Right 50% & Align Center',
									'right50r' => 'Right 50% & Align Right',
								),
								'std'     => 'center'
							),
							array(
								'name'    => esc_html__( 'Elements Animation', 'penci-framework' ),
								'desc'    => esc_html__( 'Choose Animation of Slide title, Caption and Button when slide is active', 'penci-framework' ),
								'id'      => '_slide_element_animation',
								'type'    => 'select',
								'options' => array(
									'fadeInUp'    => 'fadeInUp',
									'fadeInDown'  => 'fadeInDown',
									'fadeInLeft'  => 'fadeInLeft',
									'fadeInRight' => 'fadeInRight',
								),
								'std'     => 'fadeInUp'
							)
						),
					),
				),
			);

			$meta_boxes[] = array(
				'title'      => __( 'Slider Options', 'penci-framework' ),
				'post_types' => 'penci_slider',
				'context'    => 'side',
				'priority'   => 'low',
				'fields'     => array(
					array(
						'id'   => 'slider_autoplay',
						'name' => __( 'Enable Auto Play Slider', 'penci-framework' ),
						'type' => 'checkbox',
					),
					array(
						'id'   => 'slider_auto_time',
						'name' => __( 'Featured Slider Auto Time', 'penci-framework' ),
						'type' => 'number',
						'std'  => '4000'
					),
					array(
						'id'   => 'slider_auto_speed',
						'name' => __( 'Featured Slider Auto Speed', 'penci-framework' ),
						'type' => 'number',
						'std'  => '600'
					),
					array(
						'id'   => 'slider_fullscreen',
						'name' => __( 'Fullscreen Slider', 'penci-framework' ),
						'type' => 'checkbox',
					),array(
						'id'   => 'slider_height',
						'name' => __( 'Featured Slider Height', 'penci-framework' ),
						'type' => 'number',
						'std'  => '650',
						'hidden' => array( 'slider_fullscreen', true )
					),
					array(
						'id'   => 'slider_dots',
						'name' => __( 'Enable Slider Dots', 'penci-framework' ),
						'type' => 'checkbox',
					),
					array(
						'name' => esc_html__( 'Custom Accent Color for Dots', 'penci-framework' ),
						'id'   => 'slider_dots_color',
						'type' => 'color',
						'std'  => '',
						'hidden' => array( 'slider_dots', false )
					),
					array(
						'name'   => esc_html__( 'Custom Size for Dots', 'penci-framework' ),
						'id'     => 'slider_dots_size',
						'type'   => 'number',
						'std'    => '',
						'hidden' => array( 'slider_dots', false )
					),
					array(
						'id'   => 'slider_nav',
						'name' => __( 'Disable Slider Navigation', 'penci-framework' ),
						'type' => 'checkbox',
					),


				),
			);

			if ( ! empty( $_GET['post'] ) ) {
				$meta_boxes[] = array(
					'title'      => esc_html__( 'Usage', 'penci-framework' ),
					'post_types' => 'penci_slider',
					'context'    => 'side',
					'priority'   => 'low',
					'fields'     => array(
						array(
							'id'   => 'custom_html',
							'type' => 'custom_html',
							'std'  => sprintf( '<strong>%s</strong><div><p>%s</p><textarea style="width:%s;height:40px;line-height: 35px; background-color: #eee;">[penci_custom_slider slider_id="%s"]</textarea></div>',
								esc_html__( 'Shortcode', 'penci-framework' ),
								esc_html__( 'Copy &amp; paste the shortcode directly into any WordPress post or page.', 'penci-framework' ),
								'100%',
								$_GET['post']
							),
						),
						array(
							'type' => 'custom_html',
							'std'  => sprintf( '<hr><strong>%s</strong><div><p>%s</p><textarea style="width:%s;height:%s" readonly="readonly">&lt;?php &#13;&#10; echo do_shortcode("[penci_custom_slider slider_id="%s"]"); &#13;&#10;?></textarea></div>',
								esc_html__( 'Template Include', 'penci-framework' ),
								esc_html__( 'Copy & paste this code into a template file to include the slideshow within your theme', 'penci-framework' ),
								'100%', '100px',
								$_GET['post']
							),
						),
					),
				);
			}

			return $meta_boxes;
		}


		public function get_fonts() {

			$all_fonts = function_exists( 'penci_all_fonts' ) ? penci_all_fonts() : array();
			return array_merge(
				array(
				'' => esc_html__( '-- Default --','penci-framework' )
				),$all_fonts
			 );
			 
		}

		/**
		 * Change title default for Actions
		 *
		 * @access public
		 * @return array new $defaults
		 * @since  1.0
		 */
		public function penci_slider_modify_table_title( $defaults ) {
			$defaults['title'] = 'Title And Actions Slider';

			return $defaults;
		}

		/**
		 * Add thumbnail & caption columns
		 *
		 * @access public
		 * @return array $columns
		 * @since  1.0
		 */
		public function add_columns_penci_slider( $columns ) {
			$column_thumbnail = array( 'content_slider' => 'Content Slider' );
			$column_shortcode   = array( 'shortcode' => 'Shortcode' );
			$columns          = array_slice( $columns, 0, 2, true ) + $column_shortcode + array_slice( $columns, 2, null, true );
			$columns          = array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, null, true );


			return $columns;
		}

		/**
		 * Enqueue media to use choose image in a slide
		 *
		 * @access public
		 * @return void
		 * @since  1.0
		 */
		public function penci_slider_custom_columns( $column, $post_id ) {
			switch ( $column ) {
				case 'content_slider':
					$slider_settings = get_post_meta( $post_id, 'penci_sliders', true );
					if( $slider_settings ) {
						foreach ( $slider_settings as $slider_setting ) {

							echo '<div class="slider-item">';
							if( ! empty( $slider_setting['_slider_image'][0] ) ) {
								echo '<img class="slider-thumb" src="' . wp_get_attachment_url( $slider_setting['_slider_image'][0] )  . '" />';
							} else {
								echo '<img class="slider-thumb" src="' . get_template_directory() . '/images/no-thumb.jpg" /></a>' . '<strong>' . __( 'No image', 'pencidesign' ) . '</strong>';
							}

							$caption = ! empty( $slider_setting['_slider_caption'] ) ? $slider_setting['_slider_caption'] : '';
							$title   = ! empty( $slider_setting['_slider_title'] ) ? $slider_setting['_slider_title'] : '';
							echo '<h2>' . $title . '</h2><p>' . $caption . '</p>';

							echo '</div>';
						}
					}
				break;
				case 'shortcode':
					echo '<textarea>[penci_custom_slider slider_id="' . $post_id . '"]</textarea>';
				break;
			}
		}
	}

endif; // End Check if Class Not Exists