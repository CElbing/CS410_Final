<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csvFile']['tmp_name'];

        $wants = [];
        $needs = [];
        $savings = [];

        if (($handle = fopen($fileTmpPath, "r")) !== FALSE) {
            $row = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row === 0) { // skip header
                    $row++;
                    continue;
                }

                $amount = (float) $data[2];
                $transactionType = (int) $data[3];
                $category = (int) $data[4];

                if ($transactionType === 1) {
                    $savings[] = $amount;
                } else {
                    if ($category === 1) {
                        $needs[] = $amount;
                    } else {
                        $wants[] = $amount;
                    }
                }
                $row++;
            }
            fclose($handle);

            // print arrays to verify
            echo "Wants: " . implode(", ", $wants) . "<br>";
            echo "Needs: " . implode(", ", $needs) . "<br>";
            echo "Savings: " . implode(", ", $savings) . "<br>";

            // send this to Java
            $wantsStr = implode(",", $wants);
            $needsStr = implode(",", $needs);
            $savingsStr = implode(",", $savings);

            // Run Java (ensure .class file is compiled and in the correct path)
            $command = "java generateStats \"$wantsStr\" \"$needsStr\" \"$savingsStr\"";
            $output = shell_exec($command);
            echo nl2br($output); // display Java output in browser

        } else {
            echo "Failed to open file.";
        }
    } else {
        echo "Upload failed.";
    }
}
