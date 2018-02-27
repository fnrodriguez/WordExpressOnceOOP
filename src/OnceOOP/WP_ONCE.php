<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 2/15/2018
 * Time: 9:18 AM
 */

namespace OnceOOP;


class WP_ONCE
{

    /**
     * Display "Are You Sure" message to confirm the action being taken.
     *
     * If the action has the nonce explain message, then it will be displayed
     * along with the "Are you sure?" message.
     *
     * @since 2.0.4
     *
     * @param string $action The nonce action.
     */
    static function wp_nonce_ays( $action ) {
        if ( 'log-out' == $action ) {
            $html = sprintf(
            /* translators: %s: site name */
                __( 'You are attempting to log out of %s' ),
                get_bloginfo( 'name' )
            );
            $html .= '</p><p>';
            $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
            $html .= sprintf(
            /* translators: %s: logout URL */
                __( 'Do you really want to <a href="%s">log out</a>?' ),
                wp_logout_url( $redirect_to )
            );
        } else {
            $html = __( 'Are you sure you want to do this?' );
            if ( wp_get_referer() ) {
                $html .= '</p><p>';
                $html .= sprintf( '<a href="%s">%s</a>',
                    esc_url( remove_query_arg( 'updated', wp_get_referer() ) ),
                    __( 'Please try again.' )
                );
            }
        }

        wp_die( $html, __( 'WordPress Failure Notice' ), 403 );
    }

    /**
     * Retrieve URL with nonce added to URL query.
     *
     * @since 2.0.4
     *
     * @param string     $actionurl URL to add nonce action.
     * @param int|string $action    Optional. Nonce action name. Default -1.
     * @param string     $name      Optional. Nonce name. Default '_wpnonce'.
     * @return string Escaped URL with nonce action added.
     */
    static function wp_nonce_url( $actionurl, $action = -1, $name = '_wpnonce' ) {
        $actionurl = str_replace( '&amp;', '&', $actionurl );
        return esc_html( add_query_arg( $name, wp_create_nonce( $action ), $actionurl ) );
    }

    /**
     * Retrieve or display nonce hidden field for forms.
     *
     * The nonce field is used to validate that the contents of the form came from
     * the location on the current site and not somewhere else. The nonce does not
     * offer absolute protection, but should protect against most cases. It is very
     * important to use nonce field in forms.
     *
     * The $action and $name are optional, but if you want to have better security,
     * it is strongly suggested to set those two parameters. It is easier to just
     * call the function without any parameters, because validation of the nonce
     * doesn't require any parameters, but since crackers know what the default is
     * it won't be difficult for them to find a way around your nonce and cause
     * damage.
     *
     * The input name will be whatever $name value you gave. The input value will be
     * the nonce creation value.
     *
     * @since 2.0.4
     *
     * @param int|string $action  Optional. Action name. Default -1.
     * @param string     $name    Optional. Nonce name. Default '_wpnonce'.
     * @param bool       $referer Optional. Whether to set the referer field for validation. Default true.
     * @param bool       $echo    Optional. Whether to display or return hidden form field. Default true.
     * @return string Nonce field HTML markup.
     */
    static function wp_nonce_field( $action = -1, $name = "_wpnonce", $referer = true , $echo = true ) {
        $name = esc_attr( $name );
        $nonce_field = '<input type="hidden" id="' . $name . '" name="' . $name . '" value="' . wp_create_nonce( $action ) . '" />';

        if ( $referer )
            $nonce_field .= wp_referer_field( false );

        if ( $echo )
            echo $nonce_field;

        return $nonce_field;
    }
}