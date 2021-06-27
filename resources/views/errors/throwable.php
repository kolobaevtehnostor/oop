<div class="page-wrap d-flex flex-row align-items-center" style="min-height: 70vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <span class="display-1 d-block">
                    <?= $this->errorCode ?>
                </span>
                <br>
                <div class="mb-4">
                    Ошибка:
                    <strong>
                        <?= $this->errorMessage ?>
                    </strong>
                </div>
                <div class="mb-4 text-left">
                    В файле:
                    <strong>
                        <?= $this->errorFile ?>
                    </strong>
                    <br>
                    в строке:
                    <strong>
                        <?= $this->errorLine ?>
                    </strong>
                </div>
                <a href="http://oop.com/index.php/calculator" class="btn btn-link">Back to Home</a>
            </div>
        </div>
    </div>
</div>
