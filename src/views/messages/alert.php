<div class="alert  
<?= $this->response['status']  > 300 ? 'alert-danger ' : 'alert-success ' ?>
<?= $this->response['status'] != 200 ? 'd-block' : '' ?>" id="dialog">

    <?php if($this->response['status'] != 200) : ?>
        <ul>
            <li><?= $this->response['message']; ?></li>
        </ul>  
    <?php endif; ?>
</div>