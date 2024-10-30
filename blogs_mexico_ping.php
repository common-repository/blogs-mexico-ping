<?php
/*
Plugin Name: Blogs Mexico Ping
Plugin URI: http://g30rg3x.com/blogs-mexico-ping/
Description: Envia pings de manera automatica hacia <a href="http://www.blogsmexico.com">Blogs Mexico</a>, cada vez que publiques una nueva entrada.
Author: g30rg3_x
Version: 2.0-alpha
Author URI: http://g30rg3x.com/
*/

/*
    Copyright 2006,2007 g30rg3_x (email: g30rg3x@gmail.com)
    
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// No se puede acceder directamente
if ( !defined('ABSPATH') )
	die();

function blogs_mexico_ping_menu_adherir() {
	if ( function_exists('add_submenu_page') )
		add_submenu_page('plugins.php', 'Blogs Mexico Ping', 'Blogs Mexico Ping', 'manage_options', 'b-m-p-config', 'blogs_mexico_ping_menu');
}

function blogs_mexico_ping_menu() {
	?>
	<div class="wrap">
		<h2>Configuracion de Blogs Mexico Ping</h2>
		<div class="narrow">
			<p>
				Le recordamos que debe teclear la direccion (URL) asi como el Titulo, tal como se registro en la pagina,
				de otra forma el plugin no funcionara.<br/>
				Ejemplo, si registraste la direccion http://www.mibitacora.blogspot.com
				no podras hacer ping con la direccion http://mibitacora.blogspot.com<br/>
			</p>
		</div>
	</div>
<?php
}

add_action( 'admin_menu', 'blogs_mexico_ping_menu_adherir' );

/*
	Closed: Under Heavy Re-Development
	ToDo: Sockets and cURL capacity
*/
function blogs_mexico_ping($post_ID) {
	
	if ( extension_loaded('sockets') )
		echo ''; // do nothing
	
	if ( extension_loaded('curl') )
		echo ''; // do nothing
	
	$conexion = fsockopen( 'www.blogsmexico.com', 80, $errno, $errstr, 30 );

	if ( !$conexion )
		echo ''; //add_action('admin_head', print("<center><b>ERROR $errno</b>: $errstr</center>"));
	else {
		$titulo = urlencode($titulo);
		$url = urlencode($url);
		$cabecera = "GET /hacerping.php?titulo=$titulo&url=$url HTTP/1.1\r\n";
		$cabecera .= "Host: www.blogsmexico.com\r\n";
		$cabecera .= "User-Agent: Blogs Mexico Ping 1.0 (WordPress Plugin)\r\n";
		$cabecera .= "Connection: Close\r\n\r\n";
		fwrite( $conexion, $cabecera );
		fclose( $conexion );
	}
  
  return $post_ID;
}


add_action('publish_post', 'blogs_mexico_ping');
?>