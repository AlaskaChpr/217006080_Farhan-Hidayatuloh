<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AES File Encryption and Decryption</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>ENKRIPSI DAN DESKRIPSI MENGGUNAKAN ALGORITMA AES</h2>
    <form action="aes.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Choose File:</label>
            <input type="file" id="file" name="file" accept=".txt" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit" name="encrypt">Encrypt File</button>
            <button type="submit" name="decrypt">Decrypt File</button>
        </div>
    </form>
    <?php if(isset($_GET['message'])) { ?>
    <div class="message"><?php echo $_GET['message']; ?></div>
    <?php } ?>
    <div class="form-group">
        
    </div>
</div>
</body>
</html>
