<?php
$mois = array('janvier','février','mars','avril','mai','juin',
			'juillet','août','septembre','octobre','novembre','decembre'
		);
$mois_small = array('janv.','févr.','mars','avril','mai','juin',
			'juil.','août','sept.','oct.','nov.','dec.'
		);

list($anne, $mois_i, $jour) = explode('-', $Event['event_date']);
$mois_i = intval($mois_i)-1;

?><div class="event">
	<h1 class="event-title">
		<?php echo $Event['title']; ?>
	</h1>
	<div class="event-date">
	
            <?php 
            $interval = false;
	            if(!empty($Event['event_end'])  && $Event['event_end'] > $Event['event_date'])
	            {
	            	echo 'Du '; 
					$interval = true;
					list($anne_end, $mois_i_end, $jour_end) = explode('-', $Event['event_end']);
					$mois_i_end = intval($mois_i_end)-1;
	            } ?>
            <div class="numJour"><?php echo $jour; ?></div>
            <?php if(!$interval || $mois_i_end != $mois_i_end){
	            echo '<div class="mois">'.$mois[$mois_i].'</div>';
            }
            
	            if($interval)
	            {
					?>
					au 
		            <div class="numJour"><?php echo $jour_end; ?></div>
		            <div class="mois"><?php echo $mois[$mois_i_end]; ?></div>
		            <?php
	            }
	            
            ?>
    </div>
	<div class="event-location">
		<span>Lieu: </span><?php echo $Event['location']; ?>
	</div>
	<!-- JE TE MACHE LE TRAVAIL ^^>
    <div class="event-contact">
		<span>Contact: </span><?php echo $Event['contact']; ?>
	</div></-->
	<div class="event-content">
		<?php echo $Event['content']; ?>
	</div>
</div>

<?php 
$this->start('left');
echo $this->element('calendar');
$this->end();
?>
	