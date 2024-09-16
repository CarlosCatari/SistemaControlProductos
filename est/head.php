<?php
class Head {
    private $title;

    public function __construct($title = 'Title') {
        $this->title = $title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function render() {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8'); ?></title>
            <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
            <link href="../source/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
            <link href="../source/bootstrap/css/sb-admin-2.min.css" rel="stylesheet">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        </head>
        <?php
    }
}
?>
