<?php
$file = "C:/xampp/htdocs/test/test.csv";
//$handle = fopen($filename, "rb");
//$contents = fread($handle, filesize($filename));
//print_r(explode(",",$contents));

//fclose($handle);

$delimiter = ",";


if (($handle = fopen($file, "r")) !== FALSE) {
            $i = 0;
            while (($lineArray = fgetcsv($handle, 4000, $delimiter)) !== FALSE) {
                for ($j=0; $j<count($lineArray); $j++) {
                    $data2DArray[$i][$j] = $lineArray[$j];
                }
                $i++;
            }
            fclose($handle);
        }
		echo "<pre>";
        print_r($data2DArray);
		
		?>