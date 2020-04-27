<?php
function printMsg($msg,$buttonMsg,$buttonLink)
{
?>
	<div class="container">
		<div class=" row center">
			<div class="col s12">
			    <h5 class="header col s12 light"><?php echo $msg ?></h5>  
			</div>
		</div>
		<?php if($buttonMsg!='' AND $buttonLink!=''){ // Si on veut un bouton  ?>
			<div class="row center">
		        <a class="waves-effect waves-light btn blue darken-4" href="<?php echo $buttonLink ?>"><?php echo $buttonMsg ?></a>
		    </div>
		<?php } ?>
	</div>
<?php
}
?>