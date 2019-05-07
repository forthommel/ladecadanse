<?php
if (is_file("config/reglages.php"))
{
	require_once("config/reglages.php");
}

require_once($rep_librairies."Sentry.php");
$videur = new Sentry();

if (!$videur->checkGroup(8))
{
	header("Location: index.php"); die();
}

$get['id'] = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$get['action'] = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

if ($get['action'] == 'delete' && !empty($get['id']))
{
        $req_im = $connector->query("SELECT titre, flyer, image, idLieu, genre, dateEvenement
        FROM evenement WHERE idEvenement=".$get['id']);

        $val_even = $connector->fetchArray($req_im);
    
    	if (!empty($val_even) && ((estAuteur($_SESSION['SidPersonne'], $get['id'], 'evenement') && $_SESSION['Sgroupe'] <= 8) || $_SESSION['Sgroupe'] < 2))
		{
           
			if (!empty($val_even['flyer']))
			{
				unlink($rep_images.$val_even['flyer']);
				unlink($rep_images."s_".$val_even['flyer']);
				unlink($rep_images."t_".$val_even['flyer']);
			}

			if (!empty($val_even['image']))
			{
				unlink($rep_images.$val_even['image']);
				unlink($rep_images."s_".$val_even['image']);
			}

			if ($connector->query("DELETE FROM evenement WHERE idEvenement=".$get['id']))
			{
				header('HTTP/1.1 200 OK');
                echo 1;
			}
			else
			{
				header('HTTP/1.1 304 Not Modified');
                echo 0;
			}
		}
		else
		{
			header('HTTP/1.1 403 Forbidden');
            echo 0;
		}

}