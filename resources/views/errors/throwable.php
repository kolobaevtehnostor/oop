<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Ошибка!</h1>
                <h2><?= $this->errorCode ?></h2>
                <div class="error-details">
                  В файле  <?= $this->errorFile ?> в строке  <?= $this->errorLine ?>
                </div>
                
                <div class="error-details">
                    <?= $this->errorMessage ?>
                </div>
            </div>
        </div>
    </div>
</div>

