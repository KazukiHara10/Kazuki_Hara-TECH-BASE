</form>
</body>
</html1>

<!doctype html>
<html lang = "ja">
<head>
<meta charset="UFT-8">
</head>
<body>
<form action="mission_4.php" method="post">
<input type = "text" name="name/">���O<br/>
<input type = "text" name="comment/">�R�����g<br/>
<input type = "text" name="pass1/">�p�X���[�h<br/>
<input type = "submit" value='���M'><br>

</form>
<form action= "mission_4.php" method="post">
<input type = "text" name="delete/">�폜�Ώ۔ԍ�<br/>
<input type = "text" name="pass2/" >�p�X���[�h<br/>
<input type = "submit" value="�폜"><br/>

</form>
<form action= "mission_4.php" method="post">
<input type = "text" name="edit/">�ҏW�Ώ۔ԍ�<br/>
<input type = "text" name="ednam/">�ҏW�F���O<br/>
<input type = "text" name="edcom/">�ҏW�F�R�����g<br/>
<input type = "text" name="pass3/">�p�X���[�h<br/>
<input type = "submit" value='���M'><br/>
</form>
</body>
</html>



<?php
//-------------------------------------------------------------------------------------------------------------------------
//mission3-1 �f�[�^�x�[�X�ւ̐ڑ�
$dsn = '�f�[�^�x�[�X��';
$user = '���[�U�[��';
$password = '�p�X���[�h';
$pdo = new PDO($dsn,$user,$password);

//-------------------------------------------------------------------------------------------------------------------------
//mission3-2 �e�[�u���쐬
$sql= "CREATE TABLE IF NOT EXISTS missionA"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date DATETIME,"
."password char(32)"
.");";
$stmt = $pdo->query($sql);

$sql=  "ALTER TABLE 'missionA' AUTO_INCREMENT = 1"; //id�̘A�Ԃ�������������

//�G���[��Ԃ�
try {
  $pdo=new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(PDOException $Exception){
    die("Connection ERROR:".$Exception->getMessage());
}


//--------------------------------------------------------------------------------------------------------------------------
//mission3-3// �e�[�u���ꗗ�\������R�}���h
echo "<hr>";
echo '�e�[�u���ꗗ<br>';
$sql = 'SHOW TABLES';
$result = $pdo -> query($sql);
foreach ($result as $row){
echo $row[0];
echo '<br>';
}
echo "<hr>";

//------------------------------------------------------------------------------------------------------------------------
//mission3-4 �e�[�u���̒��g���m�F����R�}���h
echo '�e�[�u�����e<br>';
$sql = 'SHOW CREATE TABLE missionA';
$result = $pdo -> query($sql);
foreach($result as $row){
 print_r($row);
}

echo "<hr>";


//---------------------------------------------------------------------------------------------------------------------
//mission3-5 insret���g�p���ăf�[�^����

$name= $_POST["name/"];
$comment= $_POST["comment/"];
$date= date("Y/M/d H:i:s");
$password= $_POST["pass1/"];
echo "���͏��m�F<br>";
echo "$name";
echo "$comment";
echo "$date";
echo "$password.<br/>";

if(empty($name)){
	echo '���O�A�R�����g�A�p�X���[�h����͂��Ă��������B<br>';}
elseif(empty($comment)){
	echo '���O�A�R�����g�A�p�X���[�h����͂��Ă��������B<br>';}
elseif(empty($password)){
	echo '���O�A�R�����g�A�p�X���[�h����͂��Ă��������B<br>';}

else{
$sql = $pdo -> prepare("INSERT INTO missionA(name,comment,date,password) VALUES(:name, :comment, :date, :password)");
$sql -> bindParam(':name'	,$_POST["name/"]);
$sql -> bindParam(':comment'	,$_POST["comment/"]);
$sql -> bindParam(':date'	,date("Y/m/d H:i:s"));
$sql -> bindParam(':password'	,$_POST["pass1/"]);

$sql -> execute();
}

//-----------------------------------------------------------------------------------------------------------------------
//mission3-7 ���͂����f�[�^��update�ɂ���ĕҏW����
//�ϐ��̑��
$id_edit = $_POST["edit/"];
$id = strval($id_edit);
$nm = $_POST["ednam/"];
$kome = $_POST["edcom/"];
$edpass = $_POST["pass3/"];
if(empty($id)){echo'�ҏW�ԍ�����͂��Ă��������B<br>';}
elseif(empty($nm)){echo'�ҏW��̖��O����͂��Ă��������B<br>';}
elseif(empty($kome)){echo'�ҏW��̃R�����g����͂��Ă��������B<br>';}
elseif(empty($edpass)){echo'�p�X���[�h����͂��Ă��������B<br>';}
else{
$sql = "update missionA set name ='$nm',comment = '$kome' where id = '$id' and password = '$edpass'";//id��password����v���镶�̂ݕϐ����X�V����
$result = $pdo->query($sql);}
//------------------------------------------------------------------------------------------------------------------------


//mission3-8 ���͂����f�[�^��delete�ɂ���č폜����
$delete = $_POST["delete/"];
$delnum = strval($delete);
$deletepass = $_POST["pass2/"];
$delpass=strval($deletepass);

$sql = 'SELECT*FROM missionA';
$result = $pdo -> query($sql)
;

if(is_numeric($delnum)){
			$sql = "delete from missionA where id = '$delnum' and password = '$delpass'";
			$result = $pdo->query($sql);
			}
elseif(empty($delpass)){
	echo '�p�X���[�h����͂��Ă��������B<br>';}
else{
echo '�폜�ԍ��A�p�X���[�h����͂��Ă��������B<br>';}
/*echo "�폜���m�F<br>";
if (empty($delnum)){echo"N/A_delnum<br>";}
	 else{echo "$delnum<br/>";}
if (empty($delpass)){echo"N/A_delpass<br>";}
	else{echo "$delpass<br/>";}*/

//-------------------------------------------------------------------------------------------------------------------------
//mission3-6 ���͂����f�[�^��select�ɂ���ĕ\��
echo "<hr>";
echo '���R�[�h�m�F';
echo "<br>";
$sql = 'SELECT*FROM missionA ORDER BY id';
$result = $pdo -> query($sql);
foreach($result as $row){
	echo $row['id'].	',';
	echo $row['name'].	',';
	echo $row['comment'].	',';
	echo $row['date'].	',';
	echo $row['password'].	'<br>';
}

?>
