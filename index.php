<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF8" />
  <style type="text/css">
    * {
      padding: 0;
      margin: 0;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif
    }

    .listing {
      text-align: left;
      width: 90vw;
      margin: 30px auto;
      border: 1px solid #ccc;
      padding: 5px 10px 15px 10px;
      overflow: auto;
      height: 90vh;
    }

    .directory__list {
      list-style: none;
    }

    .icon_file,
    .icon_folder {
      display: inline-block;
    }

    .icon_file::before {
      background-image: url("file.png");
      background-size: cover;
      width: 22px;
      height: 29px;
      display: inline-block;
      content: " ";
      bottom: -10px;
      margin-right: 3px;
      position: relative;
    }

    .icon_folder::before {
      background-image: url("folder.png");
      background-size: cover;
      width: 22px;
      height: 29px;
      display: inline-block;
      content: " ";
      bottom: -10px;
      margin-right: 3px;
      position: relative;
    }
  </style>
</head>

<head>
  <?php

  // 1. Проверить баланс скобок в выражении, игнорируя любые внуренние символы. В решении по возможности испольщовать SplStack.
  // Примеры:
  // "Это тестовый вариант проверки (задачи со скобками). И вот еще скобки: {[][()]}" - true
  // ((a + b)/ c) - 2 - true
  // "([ошибка)" - false
  // "(") - false

  function bracketTest($string)
  {
    $brackets = ["{" => "}", "[" => "]", "(" => ")"];
    $openBrackets = ["{", "[", "("];
    $closeBrackets = ["}", "]", ")"];

    $stack = new SplStack();
    $symbols = str_split($string, 1);
    $len = count($symbols);
    for ($i = 0; $i < $len; $i++) {
      $symb = $symbols[$i];
      if (in_array($symb, $openBrackets)) {
        $stack->push($symb);
      } else if (in_array($symb, $closeBrackets)) {
        if ($stack->count() > 0) {
          $openBracket = $brackets[$stack->top()];
          if ($openBracket == $symb) {
            $stack->pop();
            // echo $stack->top(). "<br>";
          }
        } else {
          return false;
        }
      }
    }
    return $stack->count() == 0;
  }
  $inputStr0 = "()";
  $inputStr1 = "Это тестовый вариант проверки (задачи со скобками). И вот еще скобки: {[][()]}";
  $inputStr2 = "((a + b)/ c) - 2";
  $inputStr3 = "([ошибка)";
  $inputStr4 = "(";

  var_dump(bracketTest($inputStr0));
  echo " " . $inputStr0;
  echo "<br>";

  var_dump(bracketTest($inputStr1));
  echo " " . $inputStr1;
  echo "<br>";

  var_dump(bracketTest($inputStr2));
  echo " " . $inputStr2;
  echo "<br>";

  var_dump(bracketTest($inputStr3));
  echo " " . $inputStr3;
  echo "<br>";

  var_dump(bracketTest($inputStr4));
  echo " " . $inputStr4;

  // 2. Простые делители числа 13195 - это 5, 7, 13 и 29. Каков самый большой делитель числа 600851475143,
  // являющийся простым числом? Проверить ответ можно здесь(нужна регистрация)
  $number = 600851475143;
  $number = 13195;
  function isSimple(int $numb)
  {
    $limit = (int) $numb / 2;
    for ($i = 2; $i <= $limit; $i++) {
      if ($numb % $i == 0) {
        return false;
      }
    }
    return true;
  }
  function maxSimpleDelimiter(int $numb)
  {
    $startNumb = (int) ($numb / 2);
    for ($i = $startNumb; $i >= 2; $i--) {
      if (isSimple($i) && ($numb % $i == 0)) {
        return $i;
      }
    }
    return 1;
  }
  // echo maxSimpleDelimiter(600851475143);


  // 3. Написать аналог «Проводника» в Windows для директорий на сервере при помощи итераторов.

  $path = isset($_GET["path"]) ? $_GET["path"] : __DIR__;

  require_once "DirectoryList.php";

  $dl = new DirectoryList($path);
  echo $dl->render();




  ?>
</head>

</html>