<?php

// fragment : menu burger
// si utilisation mettre burger-blur et burger-transition sur les élément a rendre blur lorsque le menu est ouvert
// si des li comporte des liens, leurs mettre la class burger-lien

?>

<!-- burger a afficher au format smartphone -->
<div class="burger-button d-none" title="menu">
    <span class="burger-top"></span>
    <span class="burger-middle"></span>
    <span class="burger-bottom"></span>
</div>
<!-- menu -->
<div class="burger-menu large-12">
    <div class="flex j-between a-center large-12">
        <!-- header gauche -->
        <div class="flex a-center gap16">
            <!-- nav -->
            <nav class="burger-nav-1">
                <ul class="flex a-center gap16">
                    <li> <!-- Construire votre menu --> </li>
                    <li> <!-- Construire votre menu --> </li>
                </ul>
            </nav>
        </div>
        <!-- header droit -->
        <div class="flex a-center j-end gap16">
            <!-- nav reseaux / contact -->
            <nav class="burger-nav-2">
                <ul class="flex a-center gap16">
                    <!--  <li><a class="curs-point" href="tel:+33666529277" title="lien pour m'appeler"><div class="picto p-phone"></div></a></li> -->
                    <li> <!-- Construire votre menu --> </li>
                    <li><?php include "templates/fragments/switch_access.php"; ?></li>
                    <li><?php include "templates/fragments/dark_mode.php"; ?></li>  
                </ul>
            </nav>
        </div>
    </div>
</div>