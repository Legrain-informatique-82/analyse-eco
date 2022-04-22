<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<hr>
<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
<form enctype="multipart/form-data" action="test_edition.php" method="post">
  <!-- MAX_FILE_SIZE doit précéder le champs input de type file -->
  <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
  <!-- Le nom de l'élément input détermine le nom dans le tableau $_FILES -->  
Envoi du fichier d'analyse économique vers le serveur : <input name="analyse" type="file" />
<input type="submit" value="Envoyer le fichier" />
</form>
<hr>
Le fichier à envoyer se trouve dans le répertoire de la liasse fiscale correspondante.<br>
Par défaut : c:/lgrdoss/BureauDeGestion/liasse/"nom du dossier"/liasse fiscale/"année de la liasse"/analyseEco.xml<br>
Ex: c:/lgrdoss/BureauDeGestion/liasse/12345/liasse fiscale/2002/analyseEco.xml<br>
<hr>
</body>
</html>
