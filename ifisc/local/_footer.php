 		
 		
 		
 			<?php 
 			if ($alertaPendiente) {
                		echo '<div data-role="footer" class="ui-bar ui-bar-e"  data-inset="false"
                data-position="fixed" style="width:97%; height:30px;">
           		<ul data-role="listview" >
                <li data-icon="alert"><a style="text-align:center; width:92%;" data-ajax="false" data-rel="external" href="/ifisc/local/common/whats_new.php">
                    ¡Tienes publicaciones nuevas!</a></li></ul>
            		</div>';
            		$show_footer=false;
                	}
                    $show_footer=false;
 			if ($show_footer === true) {
 				echo '<div data-theme="a" data-role="footer" data-position="fixed"><h3>';
                echo $footer_string;
                echo '</h3></div>';
                }
            ?>
            
        </div>
        </div>
    </body>
</html>