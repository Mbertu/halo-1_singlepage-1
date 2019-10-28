<?php
class Halo1WalkerMainMenu extends Walker_Nav_Menu {

    private $parent_id;
    private $index = array();

    function start_lvl(&$output, $depth = 0, $args = array()){
        // depth dependent classes
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent

        // build html
        $output .= "\n" . $indent . '<div id="collapseSubItem_'.$this->parent_id.'" class="sub-level-outer collapse" >' . "\n";
        $output .= "\n" . $indent . '<ul class="sub-level">' . "\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array()){
        $output .= "\n" . '</ul>' . "\n";
        $output .= "\n" . '</div>' . "\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0 ) {

          $this->parent_id = $item->ID;

        if(!isset($this->index[$depth])){
            $this->index[$depth] = 0;
        }

        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // depth dependent classes
        $depth_classes = '';
        switch ($depth) {
          case 0: $depth_classes = 'first-level-item'; $attributes = ' class="menu-link first-level-link"'; break;
          case 1: $depth_classes = 'second-level-item'; $attributes = ' class="menu-link second-level-link"'; break;
          case 2: $depth_classes = 'third-level-item'; $attributes = ' class="menu-link third-level-link"'; break;
          default: break;
        }

        // passed classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
        $caret_class = $depth == 0 ? 'icon icon-caret-down hidden-xs hidden-sm' : ' icon icon-caret-right hidden-xs hidden-sm';
        $caret= in_array('menu-item-has-children', $item->classes) ? '<i class="'.$caret_class.'"></i>' : '';

        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_classes . ' ' . $class_names . '">';

        $attributes .= ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $this->current_element = apply_filters('the_title', $item->title, $item->ID);

        if(is_object($args)){
            $before = $args->before;
            $link_before = $args->link_before;
            $link_after = $args->link_after;
            $after = $args->after;
        }else if(is_array($args)){
            $before = $args['before'];
            $link_before = $args['link_before'];
            $link_after = $args['link_after'];
            $after = $args['after'];
        }else{
            return;
        }


        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s%7$s</a>%6$s',
            $before,
            $attributes,
            $link_before,
            $this->current_element,
            $link_after,
            $after,
            $caret
        );

        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        // build html
        if(in_array('menu-item-has-children', $item->classes)){
            $output .='<div class="btn btn-open-submenu collapsed hidden-md hidden-lg" data-toggle="collapse" data-target="#collapseSubItem_'.$item->ID.'" aria-expanded="false" aria-controls="collapseSubItem_'.$item->ID.'"><i class="icon icon-plus" aria-hidden="false"></i><i class="icon icon-minus" aria-hidden="false"></i></div>';
        }
        $output .= "\n" . '</li>' . "\n";
    }
}
