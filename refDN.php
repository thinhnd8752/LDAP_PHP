<?php
	//connexion au serveur ldap
	$ldapBase	=$adldap->getBaseDn();
	$filter="(|(objectclass=Organizationalunit)(name=*))";
	$fields = array("*");
	$sr = ldap_search($adldap->getLdapConnection(), $adldap->getBaseDn(), $filter);
	$info = ldap_get_entries($adldap->getLdapConnection(), $sr);
?>

<div id="divNoir"></div>
<div id="ocontent">
	<div id="ohead">
		Selectionner l'objet parent
		<div style="float:right;">
			<a href="#" onclick="JavaScript:closeBox()">Fermer</a>
		</div>
	</div>

	<div id="olistou">
		<a href=""></a>
<?php
	echo "<div class='dtree'>
	<p><a href='javascript: d.openAll();'>Développer tout</a> | <a href='javascript: d.closeAll();'>Réduire tout</a></p>
	<script type='text/javascript'>
	d = new dTree('d');
	d.add(\"".strtoupper($ldapBase)."\",-1,\"".strtoupper($ldapBase)."\",\"javascript:getRD('".$ldapBase."')\");";
	for ($i=0; $i < $info ["count"]; $i++){
		$nomobj    =$info[$i]["name"][0];
		$refdn     =strtoupper($info[$i]["distinguishedname"][0]);
		$posvir    =strpos($refdn,",");
		$reflen    =strlen($refdn);
		$ref       =strtoupper(substr($refdn,$posvir+1,$reflen-$posvir));
		$lien="javascript:getRD(\'".$refdn."\')";
		$objetCategory 	=$info[$i]["objectcategory"][0];
		$posfin 		=strpos($objetCategory,",");
		$categoryName 	=substr($objetCategory,3,$posfin-3);
		if($categoryName=='Organizational-Unit'){
			echo 'd.add("'.$refdn.'","'.$ref.'","'.$nomobj.'","'.$lien.'","","","images/imgtree/folder.gif");';
		}
	}
	echo "document.write(d);
     </script>
     </div>
	 <br>";
?>
	</div>
	<div id="obottom">
		Ref Parent:
		<input type="text" name="parentpath" id="parentpath" disabled="true" size=65>
		<input type="button" name="submit" value="OK" onClick="insertRDN();"  class="submit small"></div>
</div>
<input type="text" name="parent" id="prentRDN" placeholder="Objet parent" size="45" class="text small">
<input type="button" name="selectRDN" value="RDN" onClick="chooseRDN();" class="submit small">
