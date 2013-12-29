GraphchartPluginWordpress
=========================

Creer des graphiques animés pour WordPress entièrement en HTML5. (line, bar, pie, radar et donut) avec la blibliothèque chart.js : http://www.chartjs.org/.

== Description ==

 Ce Plugin permet de creer des graphiques animés pour WordPress entièrement en HTML5. (lignes, barres, camenbert, radar et donut) en utilisant la blibliothèque Chart.js : http://www.chartjs.org/ conçue par Nick Downie.


ce plugin c'est :

* 5 types de graphiques (lignes, barres, camenbert, radar et donut)

* Basé sur HTML5 :
 Chart.js utilise HTML5 canvas. il est compatible sur tout les navigateurs récents et supporte l'affichage sur écrans Rétina

*  Un outil simple et flexible et léger


== Installation ==

1.Telecharger le plugin
2.allez dans Tableau de bord>Extentions>Ajouter et choisissez le plugin
3. Activez le Plugin dans la liste des extentions
4. Enjoy


## Usage 

### Base
le shortcode de base est `[charts]` qui tout seul ne fait rien, vous devrez ajouter des options au shortcode pour que cela fonctionne. Le format des optionss du shortcode est `option =" quelquechose " par exemple, chaque graphique a besoin d'un titre et d'un type, donc ça nous fait [charts title =" son titre "type =" camenbert "]`. Certains graphiques nécessitent des propriétés de base spécifiques, tel que décrit ci-dessous. En outre, vous pouvez appliquer toute les propriétés avec ces descriptions ainsi.

### Important ###
* Chaque tableau requiert un type, le titre et les données ou groupes de données.
* Si vous utilisez le type de Camembert ou donut vous devez utiliser l'option "data" (parceque ceux ci utilisent 1 dimension), alors que si vous utilisez les barres, lignes ou le radar, vous devez utiliser "dataset" (parceque ceux ci sont multidimensionnel).

## Exemples d'utilisation du Shortcode 

``
	Camenbert
	[charts title="camenbert" type="pie" align="alignright" margin="5px 20px" data="10,22,50,35,5"]

	Donut

	[charts title="donut" type="doughnut" align="alignleft" margin="5px 20px" data="50,10,35,25,15,8" colors="#0fc611,#E0B4CC,#F38230,#94F5B,#E1BC17,#CE4264"]


	Barres

	[charts title="barres" type="bar" align="alignleft" margin="5px 20px" datasets="40,32,50,35 next 20,25,45,42 next 40,43, 61,50 next 33,15,40,22" labels="one,two,three,four"]

	Lignes

	[charts title="Lignes" type="line" align="alignright" margin="5px 20px" datasets="40,43,61,50 next 33,15,40,22" labels="awa,fanta,jack,tom"]

	Radar

	[charts title="radar" type="radar" align="alignleft" margin="5px 20px" datasets="20,22,40,25,55 next 15,20,30,40,35" labels="pierre,yves,alain,brice,paul" colors="#CEEC17,#FCB615"]
``

## Liste des Options 

``
	'type'             = "pie"
	choisissez le type de graphique : pie, doughnut, radar, polararea, bar, line

	'title'            = "chartname"
	titre du graphique (chaque titre doit être unique)

	'width'			   = "100%"
	facultatif - definit la taille du canevas du graphique les valeurs sont en % pour avoir une taille fluide.

	'height'		   = "auto"
	facultatif - la hauteur peut s'adapter automatiquement en fonction de la largeur (responsive design powaaa).

	'canvaswidth'      = "289"
	facultatif - ceci est la valeur par defaut, vous pouvez la modifier dans le fichier icps-charts.php, elle est en Pixels.

	'canvasheight'     = "289"
	facultatif - ceci est la valeur par defaut, vous pouvez la modifier dans le fichier icps-charts.php, elle est en Pixels.

	'margin'		   = "20px"
	facultatif - Applique l'attribut css sus-cité.

	'align'            = "alignleft"
	facultatif - Applique l'attribut css sus-cité.

	'class'			   = ""
	facultatif - applique une classe css au conteneur du graphique.

	'labels'           = ""
	Utilisé pour les graphiques de type barre ou ligne.

	'data'             = "30,50,100"
	Utilisé pour les graphiques de type camenbert et donut.

	'datasets'         = "30,50,100 next 20,90,75"
	Utilisé pour les graphiques de type barre, ligne, et radar

	'colors'           = "69D2E7,#E0E4CC,#F38630,#96CE7F,#CEBC17,#CE4264"
	facultatif -  choix des couleurs, elles doivent être exprimée en Hexadécimail seulement ( ref : exemple ci dessus). et doivent avoir le même nombre que les "data" ou "datasets".

	'fillopacity'      = "0.7"
	facultatif -  Utilisé pour les graphiques de type ligne et barre, modifie l'opacité du graphique.


	'animation'		   => 'true'
	facultatif -  pour activer ou desactiver les animations utilisez true ou false (c'est facile hein !! ^_^)

	'scaleFontSize'    => '12'
	facultatif -  adjuster la taille de la police pour les echelles de valeur

	'scaleFontColor'   => '#666'
	facultatif -  change la couleur des echelles de valeurs



##  Mise a jour a venir

Pour le moment je traque encore quelque bugs, et le plugin est bien plus avancé qu'il n'y parait (ceux qui l'ouvrions verrons bien)
 sinon dans un proche futur (croisons les doigts -_-") je compte ajouter ces features :

 - support personalisée des echelles de valeurs
 - support des graphiques en coordonées polaires
 - widgetisation du plugin (soyons fous)
 - simplification du shortcode
 - support des documents CSV et de google spreadsheet API


 merci et bonne chance  Σ(っ°д°)っ

