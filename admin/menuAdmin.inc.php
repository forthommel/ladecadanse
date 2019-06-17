<style>
#gestion ul li
{
	margin:0.4em 0;
}
</style>

<!-- Deb gestion -->
<div id="gestion">

	<h2 style="font-size:0.95em;margin-top:1em;color:#5c7378">Gérer :</h2>

	<ul style="list-style-type:none">
		<li>
            <a href="<?php echo $url_admin ?>gererEvenements.php"><img src="<?php echo $IMGicones ?>calendar.png" alt="" />les événements</a>
		</li>                
		<li>
            <a href="<?php echo $url_admin ?>gerer.php?element=lieu"><img src="<?php echo $IMGicones ?>building.png" alt="" />les lieux</a>
		</li>
		<li>
            <a href="<?php echo $url_admin ?>gerer.php?element=organisateur"><img src="<?php echo $IMGicones ?>group.png" alt="" />les organisateurs</a>
		</li>
                
        <?php if ($_SESSION['Sgroupe'] == 1) { ?>                
		<li>
            <a href="<?php echo $url_admin ?>gerer.php?element=description"><img src="<?php echo $IMGicones ?>page_white.png" alt="" />les descriptions</a>
		</li>                       
		<li>
            <a href="<?php echo $url_admin ?>gerer.php?element=personne"><img src="<?php echo $IMGicones ?>user.png" alt="" />les personnes</a>
		</li>
        <?php } ?>
        <?php if ($_SESSION['Sgroupe'] == 1) { ?>   
		<li>
            <a href="<?php echo $url_admin ?>gerer.php?element=commentaire"><img src="<?php echo $IMGicones ?>comment.png" alt="" />les commentaires</a>
        </li>        
        <?php } ?>
	</ul>

    <?php if (isset($_SESSION['Sgroupe']) && ($_SESSION['Sgroupe'] <= 1)) { ?>
    <h2 style="font-size:0.95em;margin-top:1em;color:#5c7378">Ajouter :</h2>
    <ul  style="list-style-type:none">
        <li><a href="/ajouterPersonne.php?action=ajouter"><img src="/web/interface/icons/user_add.png" alt="" style="vertical-align:bottom" />une personne</a></li>
    </ul>
    <?php } ?>
</div>
<!-- Fin gestion -->
