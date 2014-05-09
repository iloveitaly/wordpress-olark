<?php
/*
Plugin Name: olark
Description: Live Chat via olark in your WordPress installation
Version: 1.0
License: MIT

Author: Michael Bianco
Author URI: Author URI: http://cliffsidemedia.com/
Plugin URI: https://github.com/iloveitaly/wordpress-olark
*/

add_action('wp_footer', 'olark_insert');
function olark_insert() {
	$olark_key = get_option('olark_key');
	if(empty($olark_key)) return;

	echo <<<EOL
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});

/* custom configuration goes here (www.olark.com/documentation) */
olark.configure('system.require_name', 2)
olark.configure('system.require_email', 0);
olark.configure('system.require_phone', 0);
olark.identify('$olark_key');/*]]>*/</script>
EOL;
}

function olark_set_up_admin_page () {
	add_options_page('olark', 'olark', 'manage_options', 'olark_options', 'olark_admin_page');
}

function olark_admin_page () {
	?>
	<div class="wrap">
		<h2>olark Settings</h2>
		<p>Enter your olark API key. If the API key exists, the oLark code will be inserted into your footer.</p>
		<form action="options.php" method="post">
			<?php settings_fields('olark_options'); ?>
			<?php do_settings_sections('olark_options'); ?>
			<input class="regular-text" name="olark_key" type="text" value="<?php echo get_option('olark_key'); ?>" />
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

function olark_register_settings() {
	register_setting('olark_options', 'olark_key');
}

if(is_admin()) {
	add_action('admin_init', 'olark_register_settings');
	add_action('admin_menu', 'olark_set_up_admin_page');
}

register_activation_hook(__FILE__, 'olark_set_up_options');
function olark_set_up_options () {
	add_option('olark_options', '');
}
