@php
	$bg_color = $style->bgcoloritem_opt;
	$fontsHead_opt = json_decode($style->fontsHead_opt);
    $fontContent_opt = json_decode($style->fontContent_opt);
    $color_opt = json_decode($style->color_opt);
    $menu_color_opt = json_decode($style->menu_color_opt);
    $m_menu_color_opt = json_decode($style->m_menu_color_opt);
    $bgimgitem_opt = json_decode($style->bgimgitem_opt);
	$bg_attr = $style->bgAttrib_opt;

	$font_heading_size = $fontsHead_opt->size;
	$font_heading_style = $fontsHead_opt->style;
	$font_heading_width = $fontsHead_opt->weight;
	$font_content_size = $fontContent_opt->size;
	$font_content_style = $fontContent_opt->style;
	$font_content_width = $fontContent_opt->weight;
	$bg_image = $bgimgitem_opt->presets;
	$bg_presets = $bgimgitem_opt->presets;
	$bg_position = $bgimgitem_opt->position;
	$bg_repeat = $bgimgitem_opt->repeat;
	$bg_scroll = $bgimgitem_opt->scroll;
	$bg_size = $bgimgitem_opt->size;
	
	if($bg_position == 'center-top'){
		$bg_position_val = "center top";
	}elseif($bg_position == 'right-top'){
		$bg_position_val = "right top";
	}elseif($bg_position == 'left-center'){
		$bg_position_val = "left center";
	}elseif($bg_position == 'center-center'){
		$bg_position_val = "center center";
	}elseif($bg_position == 'left-bottom'){
		$bg_position_val = "left bottom";
	}elseif($bg_position == 'center-bottom'){
		$bg_position_val = "center bottom";
	}elseif($bg_position == 'right-bottom'){
		$bg_position_val = "right bottom";
	}else{
		$bg_position_val = "left top";
	}

@endphp

body.seo-template{
	@if ( $bg_attr == "1" )
		background-color: {{ $bg_color }} !important;
	@else
		background-color: transparent;
		background-image: url({{ asset('/img/gallery/' . $bg_image_id->media_name) }});
		@if( $bg_presets == "default" )
			background-size: auto;
			background-position: left top;
			background-repeat: repeat;
			background-attachment: scroll;
		@elseif( $bg_presets == "fill-screen" )
			background-size: cover;
		    background-position: {{ $bg_position_val }};
		    background-repeat: no-repeat;
		    background-attachment: fixed;
		@elseif( $bg_presets == "fit-to-screen" )
			background-size: contain;
		    background-position:{{ $bg_position_val }};
		    background-repeat: {{ ( $bg_repeat == true ) ? 'repeat' : 'false' }};
		    background-attachment: fixed;
		@elseif( $bg_presets == "repeat" )
		    background-size: auto;
		    background-position: {{ $bg_position_val }};
		    background-repeat: repeat;
		    background-attachment: {{ ( $bg_repeat == true ) ? 'scroll' : 'fixed' }};
		@else
		    background-size: {{ $bg_size }};
		    background-position: {{ $bg_position_val }};
		    background-repeat: {{ ( $bg_repeat == true ) ? 'repeat' : 'false' }};
		    background-attachment: {{ ( $bg_repeat == true ) ? 'scroll' : 'fixed' }};
		@endif
	@endif
	font-family: {{ $style->familyHead_opt }};
}
.seo-template .panel-seo-body,
.seo-template .c-panel-box > .panel-seo-body{
	font-size: {{$font_content_size}}px;
}
.seo-template .c-panel-box > .panel-seo-heading > .panel-title,
body .modal-header, body .banner-heading, body .thead-liga{
	color: {{$color_opt->head}};
	font-size: {{$font_heading_size}}px;
}

.seo-template .c-panel-box > .panel-seo-body{
	color: {{$color_opt->default}};
}
.seo-template .navbar-seo-default{
	background: {{ $menu_color_opt->wrap }};
	border-color: {{ $menu_color_opt->wrap }};
}
.seo-template .navbar-seo-default .navbar-nav > li > a,
.seo-template .footer-socket .navbar-nav > li > a{
	color: {{ $menu_color_opt->text }};
}
.seo-template .navbar-seo-default .navbar-nav > li > a:hover,
.seo-template .navbar-seo-default .navbar-nav > li > a:focus,
.seo-admin-secondary .dropdown.open a{
	background-color: {{ $menu_color_opt->hover }};
}
.seo-template .navbar-seo-default .navbar-toggle:hover,
.seo-template .navbar-seo-default .navbar-toggle:focus{
	background-color: {{ $m_menu_color_opt->btn_wrap }};
}
.seo-template .navbar-seo-default .navbar-toggle{
	border-color: {{ $m_menu_color_opt->icon }};
}
.seo-template .navbar-seo-default .navbar-toggle .icon-bar{
	background-color: {{ $m_menu_color_opt->hover }} !important;
}

.nav-foot .nav.navbar-nav {
    float: none;
    text-align: center;
}

.nav-foot .navbar-nav > li {
    display: inline-block;
    float: none;
}

