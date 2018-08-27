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
<input type = "text" name="name/">名前<br/>
<input type = "text" name="comment/">コメント<br/>
<input type = "text" name="pass1/">パスワード<br/>
<input type = "submit" value='送信'><br>

</form>
<form action= "mission_4.php" method="post">
<input type = "text" name="delete/">削除対象番号<br/>
<input type = "text" name="pass2/" >パスワード<br/>
<input type = "submit" value="削除"><br/>

</form>
<form action= "mission_4.php" method="post">
<input type = "text" name="edit/">編集対象番号<br/>
<input type = "text" name="ednam/">編集：名前<br/>
<input type = "text" name="edcom/">編集：コメント<br/>
<input type = "text" name="pass3/">パスワード<br/>
<input type = "submit" value='送信'><br/>
</form>
</body>
</html>



<?php
//-------------------------------------------------------------------------------------------------------------------------
//mission3-1 データベースへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

//-------------------------------------------------------------------------------------------------------------------------
//mission3-2 テーブル作成
$sql= "CREATE TABLE IF NOT EXISTS missionA"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date DATETIME,"
."password char(32)"
.");";
$stmt = $pdo->query($sql);

$sql=  "ALTER TABLE 'missionA' AUTO_INCREMENT = 1"; //idの連番を初期化したい

//エラーを返す
try {
  $pdo=new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(PDOException $Exception){
    die("Connection ERROR:".$Exception->getMessage());
}


//--------------------------------------------------------------------------------------------------------------------------
//mission3-3// テーブル一覧表示するコマンド
echo "<hr>";
echo 'テーブル一覧<br>';
$sql = 'SHOW TABLES';
$result = $pdo -> query($sql);
foreach ($result as $row){
echo $row[0];
echo '<br>';
}
echo "<hr>";

//------------------------------------------------------------------------------------------------------------------------
//mission3-4 テーブルの中身を確認するコマンド
echo 'テーブル内容<br>';
$sql = 'SHOW CREATE TABLE missionA';
$result = $pdo -> query($sql);
foreach($result as $row){
 print_r($row);
}

echo "<hr>";


//---------------------------------------------------------------------------------------------------------------------
//mission3-5 insretを使用してデータ入力

$name= $_POST["name/"];
$comment= $_POST["comment/"];
$date= date("Y/M/d H:i:s");
$password= $_POST["pass1/"];
echo "入力情報確認<br>";
echo "$name";
echo "$comment";
echo "$date";
echo "$password.<br/>";

if(empty($name)){
	echo '名前、コメント、パスワードを入力してください。<br>';}
elseif(empty($comment)){
	echo '名前、コメント、パスワードを入力してください。<br>';}
elseif(empty($password)){
	echo '名前、コメント、パスワードを入力してください。<br>';}

else{
$sql = $pdo -> prepare("INSERT INTO missionA(name,comment,date,password) VALUES(:name, :comment, :date, :password)");
$sql -> bindParam(':name'	,$_POST["name/"]);
$sql -> bindParam(':comment'	,$_POST["comment/"]);
$sql -> bindParam(':date'	,date("Y/m/d H:i:s"));
$sql -> bindParam(':password'	,$_POST["pass1/"]);

$sql -> execute();
}

//-----------------------------------------------------------------------------------------------------------------------
//mission3-7 入力したデータをupdateによって編集する
//変数の代入
$id_edit = $_POST["edit/"];
$id = strval($id_edit);
$nm = $_POST["ednam/"];
$kome = $_POST["edcom/"];
$edpass = $_POST["pass3/"];
if(empty($id)){echo'編集番号を入力してください。<br>';}
elseif(empty($nm)){echo'編集後の名前を入力してください。<br>';}
elseif(empty($kome)){echo'編集後のコメントを入力してください。<br>';}
elseif(empty($edpass)){echo'パスワードを入力してください。<br>';}
else{
$sql = "update missionA set name ='$nm',comment = '$kome' where id = '$id' and password = '$edpass'";//idとpasswordが一致する文のみ変数を更新する
$result = $pdo->query($sql);}
//------------------------------------------------------------------------------------------------------------------------


//mission3-8 入力したデータをdeleteによって削除する
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
	echo 'パスワードを入力してください。<br>';}
else{
echo '削除番号、パスワードを入力してください。<br>';}
/*echo "削除情報確認<br>";
if (empty($delnum)){echo"N/A_delnum<br>";}
	 else{echo "$delnum<br/>";}
if (empty($delpass)){echo"N/A_delpass<br>";}
	else{echo "$delpass<br/>";}*/

//-------------------------------------------------------------------------------------------------------------------------
//mission3-6 入力したデータをselectによって表示
echo "<hr>";
echo 'レコード確認';
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
