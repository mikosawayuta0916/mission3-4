

<?php
        ini_set('display_errors', 0);//エラー非表示
        $date = date("Y/m/d/ H:i:s"); //日付
        $filename="m3-4.txt"; //ファイル名前
        $lines = file($filename,FILE_IGNORE_NEW_LINES);
        //編集したい箇所を代入する
        $edit_val= '';
        $edit_name = '';
        $edit_comment = '';
        $edit = $_POST["edit"]; //編集ボタン
        $submit = $_POST["submit"]; //送信ボタン
        $name = $_POST['name'];  //名前受信
        $text = $_POST['text'];  //コメント受信
        
         if(file_exists($filename)){ //投稿番号
        //ファイルが有るなら...
             $num = count(file($filename))+1;
             //一番はじめの値は０にだから＋１
             }else{
                $num = 1; //
             }
        //データ保存     1<>赤坂太郎<>これはテストです<>2017/10/20 0:00:00
        $savetext = $num. "<>" .$name. "<>".$text. "<>" .$date;
        $delete = $_POST['delete'];   //削除したい番号
        
    
        
        
        
        if(isset($edit)) { //編集ボタンを押したとき
            foreach($lines as $line){
              
                $line_date = explode("<>",$line);
                if($line_date[0] == $_POST['edit_number']){ //入力された編集番号のデータを探す
                    $edit_val = $line_date[0]; //変数に代入
                    $edit_name = $line_date[1];
                    $edit_comment = $line_date[2];
                    echo "データをセットしました";
                    break;
                }
            }
        } 
        elseif(isset($submit)){ //送信ボタン押したとき
            //書き込みデータ作成（テキストに書き込まれたデータで）
            $write_date = $num  . "<>" . $_POST['name'] . "<>" . $_POST['text'] . "<>" . $date;
            echo "書き込みデータ作成";
            echo "<br>";
            if($_POST["edit_post"]){ //編集番号があれば
                foreach($lines as &$line){ 
                    $line_date = explode("<>",$line);
                    //編集番号のとき上書き
                    if($line_date[0] == $_POST["edit_post"]) { 
                        echo "<br>";
                        echo "上書き";
                        $line = $write_date;
                    }
                }
            }
             else {  //編集番号がないとき
            echo "新規投稿";
            echo "<br>";
            $lines[] = $write_date;
        }
        
            file_put_contents($filename,implode("\n",$lines));
            echo "<br>";
            echo "ファイル書き込み";
        }
       
     //削除
         if(strlen($delete)){ //$deleteに記入されているとき
           echo "もう一度入力してください";
           $file_date = file($filename);//file中身読み込む
           $fpw = fopen($filename,"w");//書き込み準備
            
           for ($i = 0; $i < count($file_date);$i++) {
            $del_date = explode("<>",$file_date[$i]);
            if($del_date[0] != $delete){
                fwrite($fpw,$file_date[$i]);
            } else {
                fwrite($fpw,"削除しました".PHP_EOL);
            }
           }
           fclose($fpw);//ファイル閉じる
         } 
         
    
    ?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>m3-4</title>
        <meta charaset="UTF-8">
    </head>
    <body>
        <form action="m3-04.php" method="post">
            <input type="hidden" name="edit_post" value="<?php echo $edit_val; ?>">
            <input type="text" name="name" placeholder="名前" value="<?php echo $edit_name; ?>">
            <input type="text" name="text" placeholder="コメント" value="<?php echo $edit_comment; ?>">
            <br>
            <input type="submit" name="submit" value="送信">
            <br>
        </form>
        <form action="m3-04.php" method="post">
            <input type="text" name="delete" placeholder="削除対象番号">
            <br>
            <input type="submit" value="削除">
        </form>
        <form action="m3-04.php" method="post">
            <input type="text" name="edit_number" placeholder="編集対象番号">
            <br>
            <input type="submit" name="edit" value="編集">
        </form>
        <?php    
         //ファイル内容表示
          $lines = file($filename,FILE_IGNORE_NEW_LINES);
          if(file_exists($filename)){
                 foreach($lines as $line){
                     $explode = explode("<>",$line);//<>で区切って保存
                     $implode = implode(" ",$explode);//文字連結
                     echo $implode;
                     echo "<br>";
                 }
                 }
        ?>
            
    </body>
    </html>
