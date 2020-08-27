<?php
session_start();
if(!isset($_SESSION['loggedin'])&&$_SESSION['loggedin']!=true)
{
	header("Location: index.php");
	die();
}

include("requestuserdata.php");
require_once('dbutils.php');
require_once('userinfo.php');
require_once('colorsbuisness.php');



if(isset($_POST['coloridtobuy']))
{
	$colorid=intval($_POST['coloridtobuy']);

	if($colorid>0)
	{
		if($row=easyQuery('SELECT id, adminonly, redaktoronly, cost, IF(EXISTS(SELECT colorpurchase.id FROM colorpurchase WHERE buyerid=? AND colorid=colors.id),1,0) AS purchased FROM colors WHERE id=?', "ii", $_SESSION['userid'], $colorid)->fetch_assoc())
		{
			if($row['adminonly']<=$_SESSION['userisadmin']&&$row['redaktoronly']<=$_SESSION['redaktor'])
			{
				$purchased=$row['purchased'];
				if($row['adminonly']>0||$row['redaktoronly']>0||$row['id']==1)
				{
					$purchased=1;
				}


				if($purchased)
				{
					assigncolor($_SESSION['userid'], $colorid);
				}else
				{
					if(getusersrakcoins($_SESSION['userid'])>=$row['cost'])
					{
						givecolor($_SESSION['userid'], $colorid);
						giverakcoins($_SESSION['userid'], -$row['cost']);
						assigncolor($_SESSION['userid'], $colorid);
						$buymessage='Udało się kupić kolor!';
					}else
					{
						$buymessage='Jesteś zbyt biedny aby kupić ten kolor!';
					}
				}
			}else
			{
				$buymessage='Jesteś za mało prestiżowy aby kupić ten kolor!';
			}
		}else
		{
			$buymessage='Taki kolor nie istnieje!';
		}
	}

}


?>


<!DOCTYPE html>
<html>
<head>
  <?php require('standardHead.php'); ?>
    <link rel="stylesheet" type="text/css" href="colorsshopstyles.css">
</head>
<body>
  <div class="container">
    <?php require('topbar.php') ?>

    <div class="content">

        <div class="hello"> Witaj w sklepie z kolorkami <?php echo getusersformattedname($_SESSION['userid']); ?>!</div>
			<div class="headline"> Masz <?php echo getstyledrakcoins(getusersrakcoins($_SESSION['userid'])); ?> </div><br>

    <?php
        if(isset($buymessage))
        {
            echo $buymessage;
        }

        $query='SELECT colors.id, colorname, colorclass, adminonly, redaktoronly, cost, IF(EXISTS(SELECT colorpurchase.id FROM colorpurchase WHERE buyerid=? AND colorid=colors.id),1,0) AS purchased FROM colors WHERE adminonly<=? AND redaktoronly<=? ORDER BY purchased DESC, cost ASC';

        $result=easyQuery($query, "iii", $_SESSION['userid'], $_SESSION['userisadmin'], $_SESSION['redaktor']);

        if($result->num_rows>0)
        {

            echo '<table class="tabela" cellspacing="0" cellpadding="0">';
            echo '<tr>
            <th class="name">&nbsp;Nazwa</th>
            <th>Styl</th>
            <th class="buy" style="margin: 0; padding:2px;">Kup/Wybierz</th>
            </tr>';
						echo '<tr style="height:10px;"></tr>';

            while($row=$result->fetch_assoc())
            {
                echo '<tr>';
                echo '<td class="name">'.$row['colorname'].'</td>';
                echo '<td class="styl">'.formatnamewithcolorclass($_SESSION['username'], $row['colorclass']).'</td>';

                echo '<td class="buy">';


								$buttonclass="buybutton";
                if(getuserscolornumber($_SESSION['userid']) == $row['id'])
								{
									$buttonmessage='Aktualny';
									$buttonclass="selected";

								}else if($row['purchased']||$row['adminonly']||$row['redaktoronly']||$row['id']==1)
	              {
	                    $buttonmessage="Wybierz";

								}else
                {
                    $buttonmessage='Kup za &nbsp;<span class="price">'.$row['cost'].'</span> &nbsp; <img src="images/rakcoin.svg" class="rakcoinImage" style="height: 1em;">';
                }

                echo '<form method="post" action=""><input type="hidden" name="coloridtobuy" value="'.$row['id'].'"/><button class="'.$buttonclass.'" type="submit">'.$buttonmessage.'</button></form>';
                echo '</td>';

                echo '</tr>';
            }

							echo ' <tr><td class="podkresl"></td><td class="podkresl"></td><td class="podkresl"></td></tr>';
            echo '</table>';


        }else
        {
            echo 'Sklep jest pusty :(';
        }

    ?>



    </div>
  </div>
</body>
</html>
