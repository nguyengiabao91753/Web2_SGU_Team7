<?php 
function recursiveCategory($categories, $selected, $parent = 0, $str = '') {
    foreach ($categories as $key => $value) {
        if ($value['parentID'] == $parent) {
            $isSelect = $selected == $value['CategoryID'];
            
            echo '<option value="' . $value['CategoryID'] . '"'.( $isSelect ? 'selected' : '').'>' . $str . $value['CategoryName'] . '</option>';
            
            unset($categories[$key]);
            recursiveCategory($categories, $selected, $value['CategoryID'], $str . "--|");
            continue;
        }
    }
}
?>

