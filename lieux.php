<?php
if (is_file("config/reglages.php"))
{
	require_once("config/reglages.php");
}
require_once($rep_librairies."Sentry.php");
$videur = new Sentry();

require_once($rep_librairies.'CollectionDescription.class.php');

$page_titre = "Lieux de sorties à Genève : bistrots, salles, bars, restaurants, cinémas,
 théâtres, galeries, boutiques, musées, ...";
$page_description = "Dernières descriptions de lieux à Genève";
$extra_css = array("menu_lieux");
include("includes/header.inc.php");

$get['idL'] = "";
if (isset($_GET['idL']))
{
	$get['idL'] = verif_get($_GET['idL'], "int", 1);
}

/**
* Récupère les dernières description + infos sur lieux et utilisateurs
*/

$fiches = new CollectionDescription();

$fiches->loadFiches('description');


$pair = 0;


?>




<!-- Début Contenu -->
<div id="contenu" class="colonne">

<p class="mobile" id="btn_listelieux">
	<button href="#"><i class="fa fa-list fa-lg"></i>&nbsp;Liste des lieux</button>
</p>


	<div id="entete_contenu">
		<h2>Dernières descriptions</h2>
	<ul class="entete_contenu_menu">
<li><a href="<?php echo $url_site ?>rss.php?type=lieux_descriptions" title="Flux RSS des dernières descriptions de lieux"><i class="fa fa-rss fa-lg" style="color:#f5b045"></i></a></li>
			</ul>
				<div class="spacer"></div>
	</div>

	<div class="spacer"></div>
	<ol id="dernieres_descriptions">

<?php
foreach($fiches->getElements() as $id => $fiche)
{

	$photo_principale = '';
	if ($fiche->getValue('photo1') != "")
	{
		$photo_principale = "<a href=\"".$url_site."lieu.php?idL=".$fiche->getValue('idLieu')."\" title=\"Voir la fiche du lieu : ".securise_string($fiche->getValue('nom'))."\">
		<img src=\"images/lieux/s_".$fiche->getValue('photo1')."?".filemtime($rep_images_lieux."s_".$fiche->getValue('photo1'))."\" width=\"100\" alt=\"".securise_string($fiche->getValue('nom'))."\" /></a>\n";
	}

	$nomAuteur = securise_string($fiche->getValue('pseudo'));
	if ($fiche->getValue('groupe') >= 8)
		$nomAuteur = $fiche->getValue('prenom')." ".$fiche->getValue('nomAuteur');

	//Réduction du descriptif
	$maxChar = trouveMaxChar($fiche->getValue('contenu'), 36, 7);
	$tailleCont = mb_strlen($fiche->getValue('contenu'));

	$apercu = '';
    

    if (datetime_iso2time($fiche->getValue('date_derniere_modif')) > datetime_iso2time("2009-10-12 12:00:00"))
    {
        $apercu = $fiche->getValue('contenu'); 
        
    }
    else
    {
        $apercu = textToHtml($fiche->getHtmlValue('contenu'));
    }
    
    
    
	if ($tailleCont > $maxChar)
	{
		//$apercu = html_substr($apercu, $maxChar, 2);
        $apercu = texteHtmlReduit($apercu, $maxChar);
	}

	?>

	<!-- Début vignette -->
	<li class="vignette<?php if ($pair % 2 != 0){echo " ici";} ?>">
		<h3><a href="<?php echo $url_site; ?>lieu.php?idL=<?php echo $fiche->getValue('idLieu'); ?>" title="Voir la fiche du lieu : <?php echo securise_string($fiche->getValue('nom')); ?>"><?php echo securise_string($fiche->getValue('nom')); ?></a></h3>
		<div class="icone">
		<?php echo $photo_principale; ?>
		</div>

		<span class="qui">par <?php echo securise_string($nomAuteur); ?><br /><?php echo date_fr($fiche->getValue('dateAjout'), "annee", "non", "non"); ?></span>
		<div class="spacer"></div>
		<div class="apercu">
		<?php echo $apercu; ?>
		</div>
		<div class="continuer">
			<a href="<?php echo $url_site; ?>lieu.php?idL=<?php echo $fiche->getValue('idLieu'); ?>" title="Voir la fiche du lieu : <?php echo securise_string($fiche->getValue('nom')); ?>">
		Voir la fiche complète</a>
		</div>
	</li>
	<!-- FIN vignette -->
<?php
	$pair++;

} // while
?>

	</ol>
	<!-- Fin dernieres_descriptions -->
<div class="clear_mobile"></div>
</div>
<!-- fin Contenu -->

<div id="colonne_gauche" class="colonne">

<?php
include("includes/navigation_calendrier.inc.php");
?>
<div style="clear:both"></div>
	<div id="derniers_lieux">

	<h2>Derniers lieux ajoutés</h2>

	<?php
	$req_lieux_recents = $connector->query("
	SELECT idLieu, nom, adresse, quartier, dateAjout 
	FROM lieu ORDER BY dateAjout DESC LIMIT 8");

	// Création de la section si il y a moins un lieu
	if ($connector->getNumRows($req_lieux_recents) > 0)
	{

		while ($tab_lieux_recents = $connector->fetchArray($req_lieux_recents))
		{
		//printr($tab_lieux_recents);
		?>
		<h3><a href="<?php echo $url_site; ?>lieu.php?idL=<?php echo $tab_lieux_recents['idLieu']; ?>" title="Voir la fiche du lieu" ><?php echo $tab_lieux_recents['nom']; ?></a></h3>
		<p><?php echo $tab_lieux_recents['adresse']; ?> (<?php echo $tab_lieux_recents['quartier']; ?>)</p>
		<?php
		}
	}
	?>

	</div>

</div>
<!-- Fin Colonnegauche -->

<div id="colonne_droite" class="colonne">

<?php include("includes/menulieux.inc.php");echo $aff_menulieux; ?>

</div>
<!-- Fin colonne_droite -->

<div class="spacer"><!-- --></div>
<?php
include("includes/footer.inc.php");
?>