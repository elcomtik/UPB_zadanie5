<?php
// A1 - uplne najlepsie http://php.net/manual/en/mysqli-stmt.get-result.php 
// A1 - pripade treba pozriet na real_escape_string() a whitelistovat vyhladavanie teda povolit len znaky a cisla napriklad regexom ;)
// A5 minimalne treba povypinat error message no najlepsie je osetrit cyklus try catchom a v pripade chyby presmerovanie na error_page.php

// NAHRADIME $search = $db->query('SELECT * FROM articles WHERE title LIKE "%'.$_POST[search].'%" OR content LIKE "%'.$_POST[search].'%"');
//Týmto
if ($stmt = $db->prepare('SELECT * FROM articles WHERE title LIKE "%?%" OR content LIKE "%?%"')) {

    /* bind parameters for markers */
    $stmt->bind_param("ss", $_POST[search], $_POST[search]);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($search);

    /* fetch value */
    $stmt->fetch();

    /* close statement */
    $stmt->close();
}


?>

<!--Co tak dat vysledky vyhladavania a data[title] do htmlspecialchars? -->
<h1> Výsledky vyhľadavania: <?=$_POST['search']?></h1>

<div>
    <?php
    try {
      while($data = $search->fetch_array(MYSQL_ASSOC)){
	  echo 'Article: <a href=/index.php?id='.$data["id"].'>'.$data["title"].'</a><br />';
    }
    } catch (Exception $e) {
      header("LOCATION: error_page.php");
     } 
    ?>
</div>
