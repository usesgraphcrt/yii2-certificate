<div class="modal fade" id="product-modal-<?= $modelType['model'] ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Сертификат для: "<?= $modelName ?>"    
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->render($url, [
                    'targetModel' => $modelName
                ]) ?>
            </div>
        </div>
    </div>
</div>