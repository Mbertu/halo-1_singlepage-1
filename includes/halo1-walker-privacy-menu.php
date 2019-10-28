<?php
class Halo1WalkerPrivacyMenu extends Walker_Nav_Menu {

    private $current_element;
    private $index = array();

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0 ) {
        if(!isset($this->index[$depth])){
            $this->index[$depth] = 0;
        }

        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // passed classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $class_names . '">';

        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $this->current_element = apply_filters('the_title', $item->title, $item->ID);


        $item_output = sprintf( '<a%1$s itemprop="name">%2$s</a>',
            $attributes,
            $this->current_element
        );

        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        // build html
        $output .= "\n" . '</li>' . "\n";
    }
}
