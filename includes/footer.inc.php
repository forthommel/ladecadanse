</div>
<!-- fin conteneur -->

<div id="pied-wrapper"> 
	
	<!-- Début pied -->
	<div id="pied">

		<ul class="menu_pied">

        <?php
        foreach ($glo_menu_pratique as $nom => $lien)
        {
        	if (strstr($_SERVER['PHP_SELF'], $lien))
        	{
        		$ici = " class=\"ici\"";
        	}
        ?>
        
            <li><a href="<?php echo $url_site.$lien; ?>" title="<?php echo $nom; ?>" <?php echo $ici; ?>><?php echo $nom; ?></a></li>
        <?php } ?>
            
            
		<li><a href="<?php echo $url_site ?>charte-editoriale.php">Charte éditoriale</a></li>
		<li><a href="<?php echo $url_site ?>liens.php">Liens</a></li>
	<li>
	<form class="recherche" action="<?php echo $url_site ?>recherche.php" method="get">
<input type="text" class="mots" name="mots" size="22" maxlength="50" value="" placeholder="Rechercher un événement" /><input type="submit" class="submit" name="formulaire" value=""  /><input type="text" name="name_as" value="" class="name_as" id="name_as" />
	</form>
	</li>
</ul>
	</div>
	<!-- Fin Pied -->

</div> 

 </div>
<!-- Fin Global -->

<?php include("comportements.inc.php");?>


</body>

</html>


