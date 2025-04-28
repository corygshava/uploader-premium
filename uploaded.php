<?php
$folder = 'uploads/';

$files = array_diff(scandir($folder), array('.', '..'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
    <style>
        * {
            box-sizing: border-box;
            transition: 0.3s ease-out;
        }
        h1 {
            text-align: center;
            /* color: #333; */
            margin-bottom: 30px;
        }
        ul {
            list-style: none;
            padding: 0;
            max-width: 800px;
            margin: auto;
        }
        li {
            background: white;
            padding: 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .file-info {
            text-align: left;
        }
        .file-name {
            font-weight: bold;
            color: #4CAF50;
        }
        .file-meta {
            font-size: 0.9rem;
            color: #777;
        }
    </style>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/w3.css">
</head>
<body>
    <div class="content w3-text-white">
        <h1>Uploaded Files</h1>

        <ul>
            <?php if (!empty($files)): ?>
                <?php foreach ($files as $file): 
                    $filePath = $folder . $file;
                    if (is_file($filePath)):
                        $size = round(filesize($filePath) / 1024, 2) . ' KB';
                        $created = date("F d Y, H:i", filectime($filePath));
                ?>
                    <li>
                        <div class="file-info">
                            <div class="file-name"><?php echo htmlspecialchars($file); ?></div>
                            <div class="file-meta"><?php echo $size . ' | Created: ' . $created; ?></div>
                        </div>
                    </li>
                <?php endif; endforeach; ?>
            <?php else: ?>
                <li>No files found.</li>
            <?php endif; ?>
        </ul>
    </div>

</body>
</html>
