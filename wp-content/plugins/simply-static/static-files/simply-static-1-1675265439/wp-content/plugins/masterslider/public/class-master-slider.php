<br>
<b>Warning</b>:  Use of undefined constant MSWP_AVERTA_INC_DIR - assumed 'MSWP_AVERTA_INC_DIR' (this will throw an Error in a future version of PHP) in <b>/opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/public/class-master-slider.php</b> on line <b>78</b><br>
<br>
<b>Warning</b>:  include_once(MSWP_AVERTA_INC_DIR/index.php): failed to open stream: No such file or directory in <b>/opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/public/class-master-slider.php</b> on line <b>78</b><br>
<br>
<b>Warning</b>:  include_once(): Failed opening 'MSWP_AVERTA_INC_DIR/index.php' for inclusion (include_path='.:/opt/lampp/lib/php') in <b>/opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/public/class-master-slider.php</b> on line <b>78</b><br>
<br>
<b>Fatal error</b>:  Uncaught Error: Call to undefined function is_admin() in /opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/public/class-master-slider.php:82
Stack trace:
#0 /opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/public/class-master-slider.php(59): Master_Slider-&gt;includes()
#1 /opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/public/class-master-slider.php(138): Master_Slider-&gt;__construct()
#2 /opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/public/class-master-slider.php(364): Master_Slider::get_instance()
#3 /opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/public/class-master-slider.php(365): MSP()
#4 {main}
  thrown in <b>/opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/public/class-master-slider.php</b> on line <b>82</b><br>