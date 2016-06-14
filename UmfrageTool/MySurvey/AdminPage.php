<?php 
namespace MySurvey;//Test hallo neue Version 2

class AdminPage extends lib\HomePage {
	use lib\DataBase;

	/*
	 * Beim Neuladen auswerten
	 */
	protected function init(){
		session_start();
		$rows=self::query("select * from tbl_umfragen");
		$toDelete=[];//Leer
		foreach ($rows as $row){
			$id=$row['id'];
			if (isset($_POST["del$id"])){//Eintrag Loeschen
			error_log("ID:".$id);
				array_push($toDelete,$id);
			}
		}
		//Alle raus
		foreach ($toDelete as $id) {
			self::query("delete from tbl_umfragen where ID = '$id'");
			self::query("delete from tbl_beitraege where thread_ID = '$id'");
		}
		
		if (isset($_POST["newsurvey"])){//Neuer Eintrag
			$val=$_POST["newsurvey"];
			if ($val!="") {
				self::query("insert into tbl_umfragen values (NULL,'$val')");
				self::createtbl("create table survey_'$val' (
						id int NOT NULL AUTO_INCREMENT,
						Question text,
						Answer_1 text,
						Answer_2 text,
						Answer_3 text,
						Answer_4 text)");
			}
		}
	}

	/*
	 * Ausgabe
	 */
	protected function body(){
		$ret='';
		if (!isset($_SESSION['loggedin'])) {
			die ("<div id='meldung'>Bitte anmelden!</div>");
		}
		
		$ret.= "
<h2>Umfragen-Verwaltung</h2>
		";
		
		$rows=self::query("select * from tbl_umfragen");
		$ret.='
<form action="index.php?p=admin" method="post">
<table class="table table-striped table-bordered">
 		'; 	
		foreach ($rows as $row) {
			$ret.= "
<tr>
<td>$row[name]</td>
<td><form action='index.php?p=edit' method='post'><input name='edit$row[id]' class='btn btn-default' type='submit' value=' Bearbeiten ' /></form></td>
<td align='right'>L&ouml;schen?</td>
<td><input type='checkbox' name='del$row[id]' value='$row[id]'></td>
</tr>
			";
		}
		$ret.= '
</table>
<label>Neue Umfrage</label>
<input name="newsurvey" type="text" size="40" maxlength="90"/>
<input class="btn btn-success" type="submit" value=" Absenden " />
<input class="btn btn-warning" type="reset" value=" Abbrechen" />

</form>
		';
		return $ret;
	}
}
?>