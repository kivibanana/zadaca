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

            <p>Odaberi početnu lokaciju:</p>
            <div>
            <input type="radio" name="start_point" id="start-point-ul" value="ul" checked>
            <label for="start-point-ul">Gore lijevo</label>
            <input type="radio" name="start_point" id="start-point-ur" value="ur">
            <label for="start-point-ur">Gore desno</label>
            </div>
            <div>
            <input type="radio" name="start_point" id="start-point-bl" value="bl">
            <label for="start-point-bl">Dole lijevo</label>
            <input type="radio" name="start_point" id="start-point-br" value="br">
            <label for="start-point-br">Dole desno</label>
            </div>
            
            <p>Odaberi smjer kretanja brojeva:</p>
            <div>
            <input type="radio" name="rot_dir" id="rot-dir-cw" value="cw" checked>
            <label for="rot-dir-cw">U smjeru kretanja kazaljke na satu</label>
            </div>
            <div>
            <input type="radio" name="rot_dir" id="rot-dir-cc" value="cc">
            <label for="rot-dir-cc">U smjeru suprotnom od smjera kretanja kazaljke na satu</label>
            </div>
            <p><input type="submit" value="Izradi matricu" id="button"></input></p>
        </form>
    </div>
    <div id="rezultat">
        <h2>Rezultat:</h2>

        <?php
        
        if(isset($_POST['num_rows']) && isset($_POST['num_columns'])){

            $NUM_ROWS = (is_numeric($_POST['num_rows']) ? (int)$_POST['num_rows'] : 1);
            
            $NUM_COLUMNS = (is_numeric($_POST['num_columns']) ? (int)$_POST['num_columns'] : 1);
            
            $START_POINT = $_POST['start_point'];
            
            $ROT_DIR = $_POST['rot_dir'];
            
            $MATRIX = [];

            $ROUTE_CW = ['right', 'down', 'left', 'up'];
            
            $ROUTE_CC = ['down', 'right', 'up', 'left'];
            
            $START_POINTS = [
                'ul'=>[0, 0],
                'ur'=>[0, $NUM_COLUMNS - 1],
                'bl'=>[$NUM_ROWS - 1, 0],
                'br'=>[$NUM_ROWS - 1, $NUM_COLUMNS - 1]
            ];

            $NUM_ELEMENTS = $NUM_ROWS * $NUM_COLUMNS;

            for($i = 0; $i < $NUM_ROWS; $i++){
                $MATRIX[$i] = [];
                for ($j = 0; $j < $NUM_COLUMNS; $j++){
                    $MATRIX[$i][$j] = [''];
                }
            }
            
            $COORD_START_POINT = $START_POINTS[$START_POINT];

            function start_directions($start_point, $rot_direction)
            {
                global $ROUTE_CW, $ROUTE_CC;
                
                if($start_point === 'ul' and $rot_direction === 'cw'){
                    $start_direction = $ROUTE_CW[0];
                }else if($start_point === 'ur' and $rot_direction === 'cw'){
                    $start_direction = $ROUTE_CW[1];
                }else if($start_point === 'br' and $rot_direction === 'cw'){
                    $start_direction = $ROUTE_CW[2];
                }else if($start_point === 'bl' and $rot_direction === 'cw'){
                    $start_direction = $ROUTE_CW[3];
                }else if($start_point === 'ul' and $rot_direction === 'cc'){
                    $start_direction = $ROUTE_CC[0];
                }else if($start_point === 'bl' and $rot_direction === 'cc'){
                    $start_direction = $ROUTE_CC[1];
                }else if($start_point === 'br' and $rot_direction === 'cc'){
                    $start_direction = $ROUTE_CC[2];
                }else{ //($start_point === 'ur' and $rot_direction === 'cc')
                    $start_direction = $ROUTE_CW[3];
                }

                if($rot_direction === 'cw'){
                    return [$start_direction, $ROUTE_CW];
                }else{
                    return [$start_direction, $ROUTE_CC];
                }
            }

            function next_direction($current_direction)
            {
                global $ROUTE;
                
                if(array_search($current_direction, $ROUTE) === 3){
                    return $ROUTE[0];
                }else{
                    return $ROUTE[array_search($current_direction, $ROUTE) + 1];
                }
            }

            function left($coord)
            {
                global $DIRECTION, $NUM_ELEMENTS, $MATRIX;

                if(($coord[1] - 1 > 0) && ($MATRIX[$coord[0]][$coord[1] - 1] == [''])){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, 'left'];
                    $NUM_ELEMENTS -= 1;
                    $coord = [$coord[0], $coord[1] - 1];
                    left($coord);
                }else if(($coord[1] - 1 == 0) && ($MATRIX[$coord[0]][$coord[1] - 1] == [''])){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, 'left'];
                    $NUM_ELEMENTS -= 1;
                    $coord = [$coord[0], $coord[1] - 1];
                    $DIRECTION = next_direction('left');
                    write_element($coord);
                }else if($NUM_ELEMENTS == 1){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, ''];
                    $NUM_ELEMENTS -= 1;
                }else{
                    $DIRECTION = next_direction('left');
                    write_element($coord);
                }
            }

            function right($coord)
            {
                global $DIRECTION, $NUM_ELEMENTS, $MATRIX, $NUM_COLUMNS;
                
                if(($coord[1] + 1) < ($NUM_COLUMNS - 1) && ($MATRIX[$coord[0]][$coord[1] + 1] == [''])){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, 'right'];
                    $NUM_ELEMENTS -= 1;
                    $coord = [$coord[0], $coord[1] + 1];
                    right($coord);
                }else if(($coord[1] + 1) == ($NUM_COLUMNS - 1) && ($MATRIX[$coord[0]][$coord[1] + 1] == [''])){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, 'right'];
                    $NUM_ELEMENTS -= 1;
                    $coord = [$coord[0], $coord[1] + 1];
                    $DIRECTION = next_direction('right');
                    write_element($coord);
                }else if($NUM_ELEMENTS == 1){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, ''];
                    $NUM_ELEMENTS -= 1;
                }else{
                    $DIRECTION = next_direction('right');
                    write_element($coord);
                }
            }

            function up($coord)
            {
                global $DIRECTION, $NUM_ELEMENTS, $MATRIX;
                
                if(($coord[0] - 1) > 0 && ($MATRIX[$coord[0] - 1][$coord[1]] == [''])){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, 'up'];
                    $NUM_ELEMENTS -= 1;
                    $coord = [$coord[0] - 1, $coord[1]];
                    up($coord);
                }else if(($coord[0] - 1) == 0 && ($MATRIX[$coord[0] - 1][$coord[1]] == [''])){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, 'up'];
                    $NUM_ELEMENTS -= 1;
                    $coord = [$coord[0] - 1, $coord[1]];
                    $DIRECTION = next_direction('up');
                    write_element($coord);
                }else if($NUM_ELEMENTS == 1){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, ''];
                    $NUM_ELEMENTS -= 1;
                }else{
                    $DIRECTION = next_direction('up');
                    write_element($coord);
                }
            }

            function down($coord)
            {
                
                global $DIRECTION, $NUM_ELEMENTS, $MATRIX, $NUM_ROWS;
                
                if(($coord[0] + 1) < ($NUM_ROWS - 1) && ($MATRIX[$coord[0] + 1][$coord[1]] == [''])){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, 'down'];
                    $NUM_ELEMENTS -= 1;
                    $coord = [$coord[0] + 1, $coord[1]];
                    down($coord);
                }else if(($coord[0] + 1) == ($NUM_ROWS - 1) && ($MATRIX[$coord[0] + 1][$coord[1]] == [''])){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, 'down'];
                    $NUM_ELEMENTS -= 1;
                    $coord = [$coord[0] + 1, $coord[1]];
                    $DIRECTION = next_direction('down');
                    write_element($coord);
                }else if($NUM_ELEMENTS == 1){
                    $MATRIX[$coord[0]][$coord[1]] = [$NUM_ELEMENTS, ''];
                    $NUM_ELEMENTS -= 1;
                }else{
                    $DIRECTION = next_direction('down');
                    write_element($coord);
                }
            }
            
            function write_element($coord)
            {
                global $NUM_ELEMENTS, $DIRECTION;

                while($NUM_ELEMENTS > 0){

                    if($DIRECTION == 'left'){
                        left($coord);
                    }
                    if($DIRECTION == 'right'){
                        right($coord);
                    }
                    if($DIRECTION == 'down'){
                        down($coord);
                    }
                    if($DIRECTION == 'up'){
                        up($coord);
                    }
                }
            }

            $DIRECTION = start_directions($START_POINT, $ROT_DIR)[0];
            $ROUTE = start_directions($START_POINT, $ROT_DIR)[1];
            write_element($COORD_START_POINT);

            echo '<table>';
            for($i=0, $cti = count($MATRIX); $i < $cti; $i++){
                echo '<tr>';
                for($j=0, $ctj = count($MATRIX[$i]); $j < $ctj; $j++){
                    echo '<td class="' . $MATRIX[$i][$j][1] . '">' . $MATRIX[$i][$j][0] . '</td>';
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
