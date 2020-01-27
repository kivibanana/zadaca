<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Ciklična matrica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Ciklična matrica</h1>

    <div id="unos">
        <h2>Ulazni podaci:</h2>

        <form class="unos" action="" method="POST">

            <label for="num_rows">Unesi broj redova:</label>
            <input type="number" name="num_rows" id="num_rows">
            <br /><br />
            <label for="num_columns">Unesi broj stupaca:</label>
            <input type="number" name="num_columns" id="num_columns">
            <p><input type="submit" value="Izradi matricu" id="button"></input></p>
        </form>
    </div>
    <div id="rezultat">
        <h2>Rezultat:</h2>

        <?php
        
        if(isset($_POST['num_rows']) && isset($_POST['num_columns'])){

            $numRows = (is_numeric($_POST['num_rows']) ? (int)$_POST['num_rows'] : 1);
            $numColumns = (is_numeric($_POST['num_columns']) ? (int)$_POST['num_columns'] : 1);
            
            $numElements = $numRows * $numColumns;
            $numSubtractor = $numElements + 1;

            $rowIdx = $numRows - 1;
            $columnIdx = $numColumns - 1;

            $rowCounter = $numRows - 1;
            $columnCounter = $numColumns;

            for($i = 0; $i < $numRows; $i++){
                $matrix[$i] = [];
                for ($j = 0; $j < $numColumns; $j++){
                    $matrix[$i][$j] = [''];
                }
            }

            $coordinate = [$rowIdx, $columnIdx];

            if ($numColumns === 1){
                for($i = 0; $i < $numRows; $i++){
                    if($numElements === 1){
                        $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, ''];
                    }else{
                        $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, 'up'];
                    }
                    $numElements -= 1;
                    $rowIdx -= 1;
                }
            }else if($numRows === 1){
                for($i = 0; $i < $columnCounter; $i++){
                    if($numElements === 1){
                        $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, ''];
                    }else{
                        $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, 'left'];
                    }
                    $numElements -= 1;
                    $columnIdx -= 1;
                }
            }else{
                while($numElements > 0){
                    for($i = 0; $i < $columnCounter; $i++){
                        if($numElements == 1){
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, ''];
                        }else if($i < ($columnCounter - 1)){
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, 'left'];
                        }else{
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, 'up'];
                        }
                        $numElements -= 1;
                        $columnIdx -= 1;
                    }

                    if($numElements === 0){
                        break;
                    }

                    $columnIdx += 1;
                    $columnCounter -= 1;
                    $rowIdx -= 1;


                    for($i = 0; $i < $rowCounter; $i++){
                        if($numElements == 1){
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, ''];
                        }else if($i < ($rowCounter - 1)){
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, 'up'];
                        }else{
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, 'right'];
                        }
                        $numElements -= 1;
                        $rowIdx -= 1;
                    }

                    if($numElements === 0){
                        break;
                    }

                    $rowIdx += 1;
                    $rowCounter -= 1;
                    $columnIdx += 1;


                    for($i = 0; $i < $columnCounter; $i++){
                        if($numElements == 1){
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, ""];
                        }else if($i < ($columnCounter - 1)){
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, 'right'];
                        }else{
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, 'down'];
                        }
                        $numElements -= 1;
                        $columnIdx += 1;
                    }

                    if($numElements === 0){
                        break;
                    }

                    $columnIdx -= 1;
                    $columnCounter -= 1;
                    $rowIdx += 1;


                    for($i = 0; $i < $rowCounter; $i++){
                        if($numElements == 1){
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, ""];
                        }else if($i < ($rowCounter - 1)){
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, 'down'];
                        }else{
                            $matrix[$rowIdx][$columnIdx] = [$numSubtractor - $numElements, 'left'];
                        }
                        $numElements -= 1;
                        $rowIdx += 1;
                    }

                    if($numElements === 0){
                        break;
                    }

                    $rowIdx -= 1;
                    $rowCounter -= 1;
                    $columnIdx -= 1;
                }
            }

            // echo '<pre>';
            // print_r($matrix);
            // echo '</pre>';
            echo '<table>';
            for($i=0, $cti = count($matrix); $i < $cti; $i++){
                echo '<tr>';
                for($j=0, $ctj = count($matrix[$i]); $j < $ctj; $j++){
                    echo '<td class="' . $matrix[$i][$j][1] . '">' . $matrix[$i][$j][0] . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';

        }else{
            
            echo "Neispravni parametri";
            
        }
        ?>

    </div>
</body>
</html>
